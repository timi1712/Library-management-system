<?php

class Book extends Model
{
    protected $table = "books";

    public function isValidISBN($isbn) {
        $isbn = str_replace(['-', ' '], '', $isbn); // Remove dashes and spaces
    
        if (strlen($isbn) == 10) {
            return $this->isValidISBN10($isbn);
        } elseif (strlen($isbn) == 13) {
            return $this->isValidISBN13($isbn);
        }
    
        return false; // Invalid length
    }
    
    private function isValidISBN10($isbn) {
        if (!preg_match('/^\d{9}[\dX]$/', $isbn)) return false;
    
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ($isbn[$i] * ($i + 1));
        }
        $check = ($sum % 11 == 10) ? 'X' : ($sum % 11);
    
        return $check == $isbn[9];
    }
    
    private function isValidISBN13($isbn) {
        if (!preg_match('/^\d{13}$/', $isbn)) return false;
    
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += ($isbn[$i] * ($i % 2 == 0 ? 1 : 3));
        }
    
        return ($sum % 10) == 0;
    }
    
    public function create($data)
    {
        // Ensure ISBN is valid before inserting
        if (!$this->isValidISBN($data['isbn'])) {
            return false; // Prevent insertion if ISBN is invalid
        }
        $sql = "INSERT INTO books (title, author, isbn, category_id, published_year, quantity, image) 
                VALUES (:title, :author, :isbn, :category_id, :published_year, :quantity, :image)";
        return $this->db->query($sql, $data);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE books SET title = :title, author = :author, isbn = :isbn,
                category_id = :category_id, published_year = :published_year, quantity = :quantity, image = :image 
                WHERE id = :id";
        $data['id'] = $id;
        return $this->db->query($sql, $data);
    }
    public function delete($id)
    {
        return $this->db->query("DELETE FROM books WHERE id = ?", [$id]);
    }
    public function getAllBooks()
    {
       return $this->db->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBookById($id)
    {
        $query = "SELECT * FROM books WHERE id = ?";
        $result = $this->db->query($query, [$id]);

        return $result ? $result->fetch(PDO::FETCH_ASSOC) : null; 
    }
    public function getBooksByCategory($categoryId)
    {
        return $this->db->query("SELECT * FROM books WHERE category_id = ?", [$categoryId])->fetchAll();
    }

    public function searchBooks($query)
    {
        $sql = "SELECT * FROM books WHERE title LIKE :query OR author LIKE :query OR isbn LIKE :query";
        return $this->db->query($sql, [':query' => "%$query%"]);
    }

    public function getBookCount()
    {
        $query = "SELECT COUNT(*) as count FROM books";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    public function getPaginatedBooks($limit, $offset)
    {
        // Directly include integers in SQL instead of parameter binding
        $sql = "SELECT * FROM {$this->table} LIMIT $limit OFFSET $offset";
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getTotalBooks()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->get_row($sql);
        return $result ? $result->total : 0;
    }

}
