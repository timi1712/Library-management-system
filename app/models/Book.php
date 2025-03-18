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
        $sql = "INSERT INTO books (title, author, isbn, category_id, published_year, quantity, image, description) 
                VALUES (:title, :author, :isbn, :category_id, :published_year, :quantity, :image, :description)";
        return $this->db->query($sql, $data);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE books SET title = :title, author = :author, isbn = :isbn,
                category_id = :category_id, published_year = :published_year, quantity = :quantity, image = :image,
                description = :description
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

    public function getAvailableBooks()
    {
        $query = "
            SELECT books.id, books.title, books.author, books.quantity 
            FROM books
            LEFT JOIN (
                SELECT book_id, COUNT(*) as borrowed_count
                FROM borrowed_books 
                WHERE status = 'borrowed' OR status = 'overdue'
                GROUP BY book_id
            ) as borrowed ON books.id = borrowed.book_id
            WHERE books.quantity > COALESCE(borrowed.borrowed_count, 0)
        ";

        return $this->db->query($query)->fetchAll();
    }

    public function getBooksByCategory($categoryId)
    {
        return $this->db->query("SELECT * FROM books WHERE category_id = ?", [$categoryId])->fetchAll();
    }


    public function searchBooks($query)
    {
        $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?";
        $params = ["%$query%", "%$query%", "%$query%"];

        $results = $this->db->query($sql, $params)->fetchAll();

        return $results ?: [];
    }


    public function getBookCount()
    {
        $query = "SELECT SUM(quantity) AS count FROM books";
        $result = $this->db->query($query)->fetch();
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
