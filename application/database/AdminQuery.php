<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 21.2.2017.
 * Time: 21:54
 */
class AdminQuery
{
    public static function isAdmin(PDO $pdo,$username,$password)
    {

        $stmt = $pdo->prepare('SELECT username,password FROM admin WHERE username = ?');

        $stmt->execute([$username]);

        $admin = $stmt->fetchObject('Admin');

        if (!empty($admin) && password_verify($password, $admin->password)) {

            $_SESSION['admin'] = $admin->username;

            return true;

        } else {

            return false;
        }
/*
        if(!empty($admin) && $admin->password==$password && $admin->username==$username)
        {
            $_SESSION['admin'] = $admin->username;

            return true;

        }
        else
            return false;*/

    }
}