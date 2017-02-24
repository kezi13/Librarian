<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 23.2.2017.
 * Time: 10:20
 */
class GenreQuery
{
    public static function giveMeAllGenres(PDO $pdo)
    {
        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT * FROM genre");
            $stmt->execute();

            $allGenres = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $allGenres;

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}