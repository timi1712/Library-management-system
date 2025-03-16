<?php

class Borrow extends Model
{
    protected $table = "borrowed_books"; // Table for storing borrow records

    public function borrowBook($user_id, $book_id)
    {
        $return_date = date("Y-m-d", strtotime("+14 days")); // 2 weeks from today
       

        $query = "INSERT INTO borrowed_books (user_id, book_id, borrow_date, return_date, status) 
                  VALUES (?, ?, NOW(), ?, 'borrowed')";

        return $this->db->query($query, [$user_id, $book_id, $return_date]);
    }

    public function getBorrowedBooksCount()
    {
        $query = "SELECT COUNT(*) AS count FROM borrowed_books WHERE status = 'borrowed'";
        return $this->db->query($query)->fetch()['count'] ?? 0;
    }

    public function getIssuedBooksCount()
    {
        $query = "SELECT COUNT(*) AS count FROM borrowed_books";
        return $this->db->query($query)->fetch()['count'] ?? 0;
    }

    public function returnBook($borrow_id)
    {
        $query = "UPDATE borrowed_books SET status = 'returned', returned_at = NOW() WHERE id = :id";

        return $this->db->query($query,$borrow_id);
    }

    public function getUserBorrowedBooks($user_id)
    {
        $query = "SELECT b.id, bk.title, bk.author, b.return_date, b.status
                  FROM borrowed_books b
                  JOIN books bk ON b.book_id = bk.id
                  WHERE b.user_id = user_id";

        return $this->db->query($query,$user_id)->fetchAll();
    }

    public function checkOverdueBooks()
    {
        $query = "UPDATE borrowed_books 
                  SET status = 'overdue' 
                  WHERE status = 'borrowed' AND return_date < CURDATE()";

        return $this->db->query($query);
    }
    // Check if a user has already borrowed a specific book
    public function isBookBorrowed($user_id, $book_id)
    {
        //$query = "SELECT * FROM borrowed_books WHERE user_id = ? AND book_id = ? AND status = 'borrowed'";
        //return $this->db->query($query, [$user_id, $book_id]); // Returns an array if borrowed, otherwise false
        //return $this->db->query($query, [$user_id, $book_id]);
        //return $this->db->query($query,[$user_id, $book_id])->fetch();
        $query = "SELECT COUNT(*) AS count FROM borrowed_books WHERE user_id = ? AND book_id = ? AND status = 'borrowed'";
        $result = $this->db->query($query, [$user_id, $book_id])->fetch();

        return $result && $result['count'] > 0;
    }
}
