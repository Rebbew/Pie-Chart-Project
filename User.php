<?php
class User extends Controller {
    function loadRegisterUser() {
        if (!empty($_POST)) {

            $user = new User_Model();
            $user->username = $_POST['username'];
            $user->password = User_Model::hashPassword($_POST['password']);
            $user->save();
            $_SESSION['userID'] = $user->getID();
            $_SESSION['username'] = $user->getUsername();

            $index = new Index();
            $index->loadIndex();
        } else {
            $this->loadView('register', array());
        }
    }

	function loadLogin() {
		if (!empty($_POST)) {
		    $user = new User_Model();
		    $success = $user->login($_POST['username'], $_POST['password']);
		    if ($success) {
		        $_SESSION['userID'] = $user->getID();
		        // We also set username because our views look for it, rather than the ID
		        $_SESSION['username'] = $user->getUsername();
                $index = new Index();
                $index->loadIndex();
		    } else {
		        $this->loadView('invaliduser', array());
		    }
		} else {
            $index = new Index();
            $index->loadIndex();
        }
	}
	/*
		We're currently using the logout.php script.
		function logoutUser() {	
		}
	*/
}
?>