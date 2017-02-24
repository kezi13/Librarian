<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 23.2.2017.
 * Time: 3:18
 */
class BookQuery
{
    public static function checkIfBookExistsInTable(PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT COUNT(*) as number FROM books WHERE ISBN=?");
            $stmt->execute([$book->ISBN]);
            $bookExistence = $stmt->fetch(PDO::FETCH_ASSOC);

            if($bookExistence['number']>0)
            {
                return true;
            }
            else return false;


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function insertBookIntoDatabase(PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO  books (ISBN,title,year,cover,createdDate,author) VALUES (:ISBN,:title,:year,:cover,
            :createdDate,:author)");
            $stmt->bindParam(':ISBN',$book->ISBN);
            $stmt->bindParam(':title',$book->title);
            $stmt->bindParam(':year',$book->year);
            $stmt->bindParam(':cover',$book->cover);
            $stmt->bindParam(':createdDate',$book->createdDate);
            $stmt->bindParam(':author',$book->author);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function InsertIntoDatabaseGenreAssociatedWithBook(PDO $pdo,Book $book,Genre $genre)
    {
        try {
            echo "<br>";
            echo "Genre id is ".$genre->id;
            echo "<br>";
            echo $book->ISBN;
            echo "<br>";
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO  booksGenre (book_ISBN,genre_id) VALUES (:book_ISBN,:genre_id)");
            $stmt->bindParam(':book_ISBN',$book->ISBN);
            $stmt->bindParam(':genre_id',$genre->id);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function updateBook (PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("UPDATE  books SET title =:title,year = :year,cover =:cover,author=:author WHERE ISBN =:ISBN");
            $stmt->bindParam(':title',$book->title);
            $stmt->bindParam(':year',$book->year);
            $stmt->bindParam(':cover',$book->cover);
            $stmt->bindParam(':author',$book->author);
            $stmt->bindParam(':ISBN',$book->ISBN);
            $stmt->execute();


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function updateBookWithoutCoverImage (PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("UPDATE  books SET title =:title,year = :year,author=:author WHERE ISBN =:ISBN");
            $stmt->bindParam(':title',$book->title);
            $stmt->bindParam(':year',$book->year);
            $stmt->bindParam(':author',$book->author);
            $stmt->bindParam(':ISBN',$book->ISBN);
            $stmt->execute();


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeAllBooks (PDO $pdo)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT * FROM books");
            $stmt->execute();
            $booksCollection = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $booksCollection;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function deleteBook (PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("DELETE FROM books WHERE ISBN =:ISBN");
            $stmt->bindParam(':ISBN',$book->ISBN);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeBook (PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT * FROM books WHERE ISBN =:ISBN");
            $stmt->bindParam(':ISBN',$book->ISBN);
            $stmt->execute();
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            return $book;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeGenreNotAssociatedWithBooks(PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT id,name FROM genre WHERE id NOT IN (SELECT genre_id FROM booksGenre WHERE book_isbn=:ISBN)");
            $stmt->bindValue(':ISBN', $book->ISBN);
            $stmt->execute();
            $genreCollection = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $genreCollection;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

    public static function giveMeGenreAssociatedWithBooks(PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT id,name FROM genre INNER JOIN books INNER JOIN booksGenre
            WHERE book_isbn=ISBN AND id=genre_id AND ISBN=:ISBN");
            $stmt->bindValue(':ISBN', $book->ISBN);
            $stmt->execute();
            $genreCollection = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $genreCollection;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

    public static function DeleteGenreAssociatedWithBook(PDO $pdo,Book $book)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("DELETE FROM booksGenre WHERE book_isbn=:ISBN");
            $stmt->bindValue(':ISBN', $book->ISBN);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function checkIfBookIsAvailable(PDO $pdo,Book $book)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT count(*) as number FROM rentBook WHERE
            date_rented IS NOT NULL AND date_returned IS NULL AND book_isbn=:ISBN");
            $stmt->bindValue(':ISBN', $book->ISBN);
            $stmt->execute();
            $isBookAvailable = $stmt->fetch(PDO::FETCH_ASSOC);

            if($isBookAvailable['number']<1)
            {
                return true;
            }
            else false;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

    public static function checkIfUserRentLessOrThreeBooks(PDO $pdo,User $user)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT count(*) as number FROM rentBook WHERE
            date_rented IS NOT NULL AND date_returned IS NULL AND user_id=:user_id");
            $stmt->bindValue(':user_id', $user->id);
            $stmt->execute();
            $howManyBookUserCurrentyRented = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "User rent ".$howManyBookUserCurrentyRented['number'];

            if($howManyBookUserCurrentyRented['number']>2)
            {
                return true;
            }
            else return false;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

    public static function rentBook(PDO $pdo,User $user,Book $book)
    {
        try {
            $date_rented = date('Y-m-d');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO rentBook (book_isbn,user_id,date_rented) VALUES (:book_isbn,:user_id,:date_rented)");
            $stmt->bindValue(':book_isbn', $book->ISBN);
            $stmt->bindValue(':user_id', $user->id);
            $stmt->bindValue(':date_rented', $date_rented);
            $stmt->execute();


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

    public static function returnBook(PDO $pdo,User $user,Book $book)
    {      $date_return = date('Y-m-d');
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("UPDATE rentBook SET date_returned= :date_returned WHERE user_id = :user_id AND book_isbn =:book_isbn");
            $stmt->bindValue(':date_returned', $date_return);
            $stmt->bindValue(':book_isbn', $book->ISBN);
            $stmt->bindValue(':user_id', $user->id);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

    }

}