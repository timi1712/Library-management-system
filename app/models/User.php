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

    public function getByEmail($email)
    {
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    return $this->db->query($sql, ['email' => $email])->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC");
    }

    public function getUserCount()
    {
        $query = "SELECT COUNT(*) as count FROM users";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        #$result = $this->db->query("SELECT COUNT(*) as count FROM users");
        return $result['count'] ?? 0;
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $result = $this->db->query($query, [$id]);

        return $result ? $result->fetch(PDO::FETCH_ASSOC) : null; 
    }

    public function updateUser($id, $data)
    {
        $query = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
        return $this->db->query($query, [$data['name'], $data['email'], $data['role'], $id]);
    }

    public function deleteUser($id)
    {
        return $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
    }

}
