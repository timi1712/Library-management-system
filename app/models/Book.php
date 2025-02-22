<?php

class Book extends Model
{
    protected $table = "books";

    public function create($data)
    {
        $sql = "INSERT INTO books (title, author, category_id, quantity, image) 
                VALUES (:title, :author, :category_id, :quantity, :image)";
        return $this->db->query($sql, $data);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE books SET title = :title, author = :author, 
                category_id = :category_id, quantity = :quantity, image = :image 
                WHERE id = :id";
        $data['id'] = $id;
        return $this->db->query($sql, $data);
    }
}
