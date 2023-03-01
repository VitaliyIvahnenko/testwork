<?php

class User {
    private $db;
    private $id;
    private $email;

    public function __construct(Database $database){
        $this->db = $database;
    }

    public function login($email, $password){
        $query = "SELECT * FROM users WHERE email=:email AND password=:password";
        $stmt = $this->db->query($query, [':email' => $email, ':password' => $password]);
        $row_count = $stmt->rowCount();
        if($row_count > 0){
            $row = $stmt->fetch();
            $this->setUserData($row);
            return true;
        } else {
            return false;
        }
    }

    public function register($data){
        $query = "INSERT INTO users ( email, password) VALUES ( :email, :password)";
        $stmt = $this->db->query($query, [
            ':email' => $data['email'],
            ':password' => $data['password']
        ]);
        if($stmt){
            return true;
        } else {
            return false;
        }
    }

    private function setUserData($row){
        $this->id = $row['id'];
        $this->email = $row['email'];
    }

    public function getUserData($user_id){
        $query = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->db->query($query, [':id' => $user_id]);
        $row = $stmt->single();
        return $row;
    }
}
?>