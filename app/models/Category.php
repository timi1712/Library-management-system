<?php

class Category extends Model
{
    protected $table = "categories";

    public function getAllCategories()
    {
       // return $this->findAll();
       return $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addCategory($name, $imagePath)
    {
        $this->db->query("INSERT INTO categories (name, image) VALUES (:name, :image)", [
            "name" => $name,
            "image" => $imagePath
        ]);
    }

    public function delete($id)
    {
        return $this->db->query("DELETE FROM categories WHERE id = ?", [$id]);
    }

    public function getCategoryByID($id)
    {
        $query = "SELECT * FROM categories WHERE id = ?";
        $result = $this->db->query($query, [$id]);

        return $result ? $result->fetch(PDO::FETCH_ASSOC) : null; 
    }

    public function updateCategory($id, $data)
    {
        $query = "UPDATE categories SET name = ?, image = ? WHERE id = ?";
        return $this->db->query($query, [$data['name'], $data['image'], $id]);
    }
    public function getPaginatedCategories($limit, $offset)
    {
        // Directly include integers in SQL instead of parameter binding
        $sql = "SELECT * FROM {$this->table} LIMIT $limit OFFSET $offset";
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getTotalCategories()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->get_row($sql);
        return $result ? $result->total : 0;
    }

}
