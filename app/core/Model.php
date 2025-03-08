<?php
// parent class for all models

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findAll()
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id])->fetch();
    }

    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $this->db->query($sql, $data);
        return $this->db->lastInsertId();
    }

    public function get_row($query, $data = [])
    {
        $stmt = $this->db->query($query, $data);
        return $stmt ? $stmt->fetch(PDO::FETCH_OBJ) : false;
    }

    public function update($id, $data)
    {
        $updates = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $updates WHERE id = :id";
        $data['id'] = $id;
        return $this->db->query($sql, $data);
    }

    public function delete($id)
    {
        return $this->db->query("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
