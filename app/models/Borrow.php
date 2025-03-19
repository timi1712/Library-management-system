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

    public function countBorrowedBooks()
    {
        $query = "SELECT COUNT(*) AS total FROM borrowed_books"; 
        $stmt = $this->db->query($query);
        // Fetch the result as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }


    public function getIssuedBooksCount()
    {
        $query = "SELECT COUNT(*) AS count FROM borrowed_books";
        return $this->db->query($query)->fetch()['count'] ?? 0;
    }


    public function returnBook($borrow_id)
    {
        $db = Database::getInstance();

        try {
            // Start transaction
            $db->beginTransaction();

            // Check if the borrow_id exists in the borrowed_books table
            $checkSql = "SELECT * FROM borrowed_books WHERE book_id = :book_id";
            $stmt = $db->query($checkSql, ['book_id' => $borrow_id]);
            $borrowed = $stmt->fetch();

            // Debugging: Check if the row exists
            if (!$borrowed) {
                error_log("Error: Borrowed book entry with borrow_id $borrow_id not found.");
                throw new Exception("Error: Borrowed book entry not found.");
            }

            error_log("Borrowed Book Found: " . json_encode($borrowed));

            // Update the book status
            $updateSql = "UPDATE borrowed_books SET status = :status, return_date = NOW() WHERE book_id = :book_id";
            $db->query($updateSql, [
                'status' => 'returned',
                'book_id' => $borrow_id
            ]);

            // Commit transaction
            $db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback on failure
            $db->rollBack();
            error_log("Transaction failed: " . $e->getMessage());
            die($e->getMessage()); // Debugging: Print error message
        }
    }


    public function findById($borrow_id)
    {
        $query = "SELECT * FROM borrowed_books WHERE id = ?";
        return $this->db->query($query, [$borrow_id])->fetch();
    }

    public function getUserBorrowedBooks($user_id, $limit, $offset)
    {
        $query = "
            SELECT bb.id AS borrow_id, b.id AS book_id, 
                b.title, b.author, b.isbn, 
                bb.return_date, bb.status
            FROM borrowed_books bb
            JOIN books b ON bb.book_id = b.id
            WHERE bb.user_id = :user_id
            ORDER BY bb.return_date DESC
            LIMIT " . intval($limit) . " OFFSET " . intval($offset);
        
        return $this->db->query($query, ['user_id' => $user_id])->fetchAll();
    }

    

    public function countUserBorrowedBooks($user_id)
    {
        $query = "SELECT COUNT(*) as total FROM borrowed_books WHERE user_id = :user_id";
        return $this->db->query($query, ['user_id' => $user_id])->fetch()["total"];
    }


    public function getBorrowedBooks($limit, $offset)
    {
        $query = "SELECT 
                    books.id, 
                    books.title, 
                    books.image, 
                    bb.status,
                    bb.return_date,
                    u.name AS user_name
                    FROM borrowed_books bb
                    JOIN books ON bb.book_id = books.id
                    JOIN users u ON bb.user_id = u.id
                    ORDER BY bb.borrow_date DESC
                    LIMIT $limit OFFSET $offset
                ";

    return $this->db->query($query);

    
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
