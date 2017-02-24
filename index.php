<?php
    session_start();
require __DIR__."/application/controllers/Controller.php";
require __DIR__."/application/database/Connection.php";
require __DIR__."/application/database/AdminQuery.php";
require __DIR__."/application/database/UserQuery.php";
require __DIR__."/application/database/BookQuery.php";
require __DIR__."/application/database/GenreQuery.php";
require __DIR__."/application/database/RentQuery.php";
require __DIR__."/application/models/Genres.php";
require __DIR__."/application/models/Book.php";
require __DIR__."/application/models/User.php";
require __DIR__."/application/models/Admin.php";
require __DIR__."/application/helperClass/Mail.php";


/**
 * Save database configuration data array into variable config
 */
$config = require __DIR__.'/application/configs/config.php';

$routes = require __DIR__.'/application/routers/route.php';

$pdo = new Connection($config);

$controller = new Controller($routes,$pdo->getPDO());

$controller->redirect(strtolower($_SERVER['REQUEST_METHOD']).trim($_SERVER['REQUEST_URI'],'/\\'));


?>
