<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 23.2.2017.
 * Time: 0:46
 */
class UserQuery
{
    public static function checkIfUserExistsInTable(PDO $pdo,User $user)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT COUNT(*) as number FROM users WHERE id=?");
            $stmt->execute([$user->id]);
            $userExistence = $stmt->fetch(PDO::FETCH_ASSOC);

            if($userExistence['number']>0)
            {
                return true;
            }
            else return false;


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }



    public static function insertUserIntoDatabase(PDO $pdo,User $user)
    {

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("
          INSERT INTO users (id,firstName,lastName,email,telNumber,address,sex,registrationDate,activeUntil)
            VALUES (:id,:firstName,:lastName,:email,:telNumber,:address,:sex,:registrationDate,:activeUntil)");
            $stmt->bindParam(':id',$user->id);
            $stmt->bindParam(':firstName',$user->firstName);
            $stmt->bindParam(':lastName',$user->lastName);
            $stmt->bindParam(':email',$user->email);
            $stmt->bindParam(':telNumber',$user->telNumber);
            $stmt->bindParam(':address',$user->address);
            $stmt->bindParam(':sex',$user->sex);
            $stmt->bindParam(':registrationDate',$user->registrationDate);
            $stmt->bindParam(':activeUntil',$user->activeUntil);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function updateUser (PDO $pdo,User $user)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("UPDATE users SET firstName = :firstName ,lastName = :lastName,email =:email,telNumber =:telNumber,
             sex = :sex,address = :address WHERE id =:id");
            $stmt->bindValue(':firstName', $user->firstName);
            $stmt->bindValue(':lastName', $user->lastName);
            $stmt->bindValue(':email', $user->email);
            $stmt->bindValue(':telNumber', $user->telNumber);
            $stmt->bindValue(':sex', $user->sex);
            $stmt->bindValue(':address', $user->address);
            $stmt->bindValue(':id', $user->id);
            $stmt->execute();


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeUser(PDO $pdo,$id)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id =:id");
                    $stmt->bindValue(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);


            return $user;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function deleteUser(PDO $pdo,User $user)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("DELETE FROM users WHERE id =:id");
            $stmt->bindValue(':id', $user->id);
            $stmt->execute();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeAllUsers(PDO $pdo)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT * FROM users");
            $stmt->execute();
            $collectionOfUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $collectionOfUser;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function checkIfUserIsAvailable(PDO $pdo,User $user)
    {
        try {
            echo "User id is ".$user->id;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT activeUntil FROM users WHERE id =:id");
            $stmt->bindValue(':id', $user->id);
            $stmt->execute();
            $useAvailable = $stmt->fetch(PDO::FETCH_ASSOC);

            $todayDate = date('Y-m-d');

            $dateDifference= $useAvailable['activeUntil']-$todayDate;


            if($dateDifference>0) return true;
            else false;


        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public static function giveMeAllUsersIdWhoDidntReturnBook(PDO $pdo)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT DISTINCT user_id FROM rentBook WHERE date_returned IS NULL");
            $stmt->execute();
            $userIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userIds;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }



}