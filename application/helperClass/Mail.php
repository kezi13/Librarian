<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 24.2.2017.
 * Time: 11:20
 */
class Mail
{
    public static function send($user)
    {

          $messeage = 'Please retrun this book '.$user['ISBN'].' '.$user['title'].' '.$user['author'];
          $subject ='15 days';

          mail($user['email'],$subject,$messeage,"From: librarypoliceman@iowa.com");

    }
}