<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 23.2.2017.
 * Time: 20:03
 */
class RentQuery
{
    public static function giveMeBookWhichUserRent (PDO $pdo,User $user)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT ISBN,title,author,date_rented,email_notified FROM rentBook,books WHERE isbn=book_isbn AND user_id
            =:user_id AND date_returned IS NULL");
            $stmt->bindValue(':user_id', $user->id);
            $stmt->execute();
            $collectionOfNotReturnedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $collectionOfNotReturnedBooks;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeUsersWhichLate(PDO $pdo)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT rentbook.id as rentId, users.id as userId,firstName,lastName,email,ISBN,title,author
          FROM users INNER JOIN rentbook INNER JOIN books WHERE book_isbn =ISBN AND user_id = users.id
          AND date_returned IS NULL AND DATEDIFF(CURDATE(),date_rented)>15 AND email_notified = 'N';");
            $stmt->execute();
            $userIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userIds;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

}