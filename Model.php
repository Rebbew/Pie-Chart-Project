<?php
class Model {
    protected $db = null;

    protected $table = '';
    protected $fields = array();
    protected $idField = '';

    public function __construct() {
        $theConnectionJSON = getenv("VCAP_SERVICES");
        $theConnection = json_decode($theConnectionJSON, true);

        $dbname = $theConnection['mysql-5.1'][0]['credentials']['name'];
        $hostname = $theConnection['mysql-5.1'][0]['credentials']['hostname'];
        $username = $theConnection['mysql-5.1'][0]['credentials']['username'];
        $password = $theConnection['mysql-5.1'][0]['credentials']['password'];

        $this->db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    }

    protected function query($sql, $parameters) {
        $statement = $this->db->prepare($sql);
        $statement->execute($parameters);

        // return an object of this class, rather than an associative array
        $return = $statement->fetchAll(PDO::FETCH_CLASS, get_class($this));
        return $return;
    }

    public function getID() {
        return $this->{$this->idField};
    }

    public function save() {
        $return = '';
        $id = $this->getID();
        $myFieldsToSave = array();

        foreach ($this->fields as $field) {
            $myFieldsToSave[$field] = $this->{$field};
        }
        if ($id) {
            $return = $this->updateByID($id, $myFieldsToSave);
        } else {
            $return = $this->create($myFieldsToSave);
            $this->{$this->idField} = $return;
        }
        return true;
    }

    // Create
    protected function create($arr_fields) {
        // PHP's associative arrays are guaranteed to produce the same order each call
        $fields = array();

        // backtick all of the field names
        foreach ($arr_fields as $field => $value) {
            $str = '`' . $field . '`';
            $fields[$str] = $value;
        }
        unset($arr_fields);

        // Create a comma-separated list of field names
        $fieldsStr = implode(',', array_keys($fields));

        // Creates an array of '?' for filling in our prepare-query
        $questions = array_fill(0, count($fields), '?');
        $questionStr = implode(', ', $questions);

        $sql = "INSERT INTO $this->table ($fieldsStr) VALUES ($questionStr)";
        $return = $this->query($sql, array_values($fields));

        return $this->db->lastInsertId();

    }

    // Read

    public function all() {
        $sql = "SELECT * FROM $this->table";
        return $this->query($sql, array());
    }

    protected function getByID($id) {
        return $this->getBy(
            array($this->idField => $id),
            $limit=1
        );
    }

    protected function getBy($arr_fields, $limit=0) {
        $sql_params = array();
        $sql = "SELECT * FROM $this->table ";
        if (!empty($arr_fields)) {
            $sql .= 'WHERE ';
            foreach (array_keys($arr_fields) as $field) {
                $sql_params[] = "$field = ?";
            }
        }
        $sql .= implode(' AND ', $sql_params);

        return $this->query($sql, array_values($arr_fields));
    }

    // Update
    protected function updateBy($arr_fields_matching, $arr_fields_update, $limit=0) {
        $sql_update_params = array();
        $sql_where_params = array();
        $sql = "UPDATE $this->table SET ";

        foreach (array_keys($arr_fields_update) as $field) {
            $sql_update_params[] = "$field = ?";
        }
        if (!empty($arr_fields)) {
            $sql .= 'WHERE ';
            foreach (array_keys($arr_fields) as $field) {
                $sql_params[] = "$field = ?";
            }
        }
        $sql .= implode(',', $sql_update_params);
        $sql .= ' WHERE ';
        $sql .= implode(' AND ', $sql_params);

        return $this->query($sql, array_merge(array_values($arr_fields_update), array_values($arr_fields_matching)));
    }

    protected function updateByID($id, $arr_fields_update) {
        $this->updateBy(
            array($this->idField => $id),
            $arr_fields_update,
            $limit=1
        );
    }

    // Destroy
    protected function deleteByID($id) {
        $this->deleteBy(
            array($this->idField => $id),
            $limit=1
        );
    }

    protected function deleteBy($arr_fields, $limit=0) {
        $sql_params = array();
        $sql = "DELETE FROM $this->table ";
        if (!empty($arr_fields)) {
            $sql .= 'WHERE ';
            foreach (array_keys($arr_fields) as $field) {
                $sql_params[] = "$field = ?";
            }
        }
        $sql .= implode(' AND ', $sql_params);

        return $this->query($sql, array_values($arr_fields));
    }

}
?>