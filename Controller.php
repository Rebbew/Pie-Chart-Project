<?php
include_once 'models/user_model.php';

class Controller {
    private $name = '';
        $this->user_model = new User_model();
    }

    public function loadView($view_location, $data) {
        extract($data);
        include('views/' . $view_location . '.php');
    }
}
?>