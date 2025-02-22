<?php

class User extends Model
{
    protected $table = "users";

    public function create($data)
    {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $result = $this->db->query($sql, $data);
        if (!$result) {
            die("Error inserting user. Check database connection or query.");
        }
        return $result;
    }

    public function emailExists($email)
    {
        $sql = "SELECT id FROM users WHERE email = ?";
        return $this->get_row($sql, [$email]);
    }
}
