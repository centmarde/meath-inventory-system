<?php
class User {
    public $username;
    public $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function save() {
        // Logic to save user to the database
    }

    public function validate() {
        // Logic to validate user credentials
    }
}
?>