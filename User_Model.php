<?php
class User_Model extends Model {

    public $username = '';
    public $password = '';

    protected $table = 'Users';
    protected $fields = array('username', 'password');
    protected $idField = 'userID';

    protected $userID = 0;

    public function __construct() {
        parent::__construct();
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public static function hashPassword($pass) {
        return $pass;
    }

    public function login($username, $password) {
        $user = $this->getBy(
            array(
                'username' => $username,
                'password' => $password
            )
        );

        if (isset($user[0])) {
            $user = $user[0];

            $this->username = $user->username;
            $this->password = $user->password;
            $this->userID = $user->userID;

            return true;
        } else {
            return false;
        }
    }

}

$user_model = new User_Model();
?>