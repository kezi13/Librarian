<?php

class Controller
{
    private $routes;
    private $pdo;

    public function __construct($routes, PDO $pdo)
    {
        $this->routes = $routes;
        $this->pdo = $pdo;

    }

    //This method decide
    public function redirect($methodName)
    {
        $method = explode("/", $methodName);
        $argument = NULL;

        // If user is logged In
        if (isset($_SESSION['admin'])) {

/*            //When is logged as admin check if any of user late 15 days and is not notified by email
            $collection = RentQuery::giveMeUsersWhichLate($this->pdo);

            //Notify that users about delay
            foreach ($collection as $users)
                Mail::send($users);*/


            //Check if any argument exists
            if (sizeof($method) > 1) {


                $methodName = $method[0];
                $argument = $method[1];

                //If method exists call that method with arguments
                if (method_exists($this, $methodName)) {
                    $this->$methodName($argument);

                }
                else $this->getDashboard();

            } else {

                //If number of argument dosent exists
                if (method_exists($this, $methodName))  $this->$methodName($argument);
                else $this->getDashboard();
            }

        }

        // If user try to log in
         else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['username']) && isset($_POST['password']))
        {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);

            // If username and password is valid
            if(AdminQuery::isAdmin($this->pdo,$username,$password))
            {
                $this->getDashboard();
            }
            else  require __DIR__."/../views/pages/welcome.php";

        }

        else require __DIR__."/../views/pages/welcome.php";

    }

    private function getUserEdit($id)
        {

            $user = UserQuery::giveMeUser($this->pdo,$id);

            return require __DIR__.'/../views/pages/admin/'.$this->routes[substr(__FUNCTION__,3)];

    }

    private function getUserDelete($id)
    {
        UserQuery::deleteUser($this->pdo,$id);

        return $this->getAllUsers();
    }

    private function postNewUser()
    {
        $user = new User();
        $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
        $user->id = $id;

        if(!UserQuery::checkIfUserExistsInTable($this->pdo,$user))
        {
        //Sanitize input
        $firstName = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
        $lastName = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $telNumber = filter_var($_POST['telNumber'],FILTER_SANITIZE_NUMBER_INT);
        $address = ($_POST['address']);
        $sex = filter_var($_POST['sex'],FILTER_SANITIZE_STRING);
        $registrationDate = date('Y-m-d');
        //Convert time into UNIX timestamp
        $time = strtotime($registrationDate);
        //User is active 1 year.
        $activeUntil = date('Y-m-d',strtotime('+1 year',$time));

        // Check if any empty input terminate script
        if(empty($id) || empty($firstName) || empty($lastName) || empty($email) || empty($telNumber)
        ||empty($address) || empty($sex) || empty($registrationDate) || empty($activeUntil))  {
            exit ("Invalid inputs");
        }

        $user->address = $address;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->email = $email;
        $user->telNumber = $telNumber;
        $user->sex = $sex;
        $user->registrationDate = $registrationDate;
        $user->activeUntil = $activeUntil;

        UserQuery::insertUserIntoDatabase($this->pdo,$user);

        return $this->getAllUsers();

        }

        else exit ('User Already Exists in Table');

    }

    private function postUserEdit($id)
    {
        $user = new User();
        $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
        $user->id = $id;

        if(UserQuery::checkIfUserExistsInTable($this->pdo,$user))
        {
            //Sanitize input
            $firstName = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
            $lastName = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $telNumber = filter_var($_POST['telNumber'],FILTER_SANITIZE_NUMBER_INT);
            $address = ($_POST['address']);
            $sex = filter_var($_POST['sex'],FILTER_SANITIZE_STRING);

            //Enter into user object
            $user->address = $address;
            $user->firstName = $firstName;
            $user->lastName = $lastName;
            $user->email = $email;
            $user->telNumber = $telNumber;
            $user->sex = $sex;

            UserQuery::updateUser($this->pdo, $user);

            return $this->getAllUsers();
        }
        else exit ('There isnt user in database');
    }

/*    private function postLogIn($uri)
    {

        if ($this->isAdmin()) $this->getDashboard();
        else $this->getLogIn('/');
    }*/

    private function getDashboard()
    {

       return require __DIR__.'/../views/pages/admin/'.$this->routes[substr(__FUNCTION__,3)];

    }


    private function getlogOut()
    {
        unset($_SESSION['admin']);

        return  require __DIR__."/../views/pages/welcome.php";
    }

    private function getAllBooks()
    {
        $collection = BookQuery::giveMeAllBooks($this->pdo);

        $collectionOfBooks = new ArrayObject();

        foreach ($collection as $bookItem)
        {
            $book = new Book();

            $book->ISBN = $bookItem["ISBN"];
            $book->title = $bookItem["title"];
            $book->year = $bookItem["year"];
            $book->author = $bookItem["author"];
            $book->cover = $bookItem["cover"];
            $book->createdDate = $bookItem["createdDate"];
            $book->genres = BookQuery::giveMeGenreAssociatedWithBooks($this->pdo,$book);


            $collectionOfBooks->append($book);
        }

        return require __DIR__.'/../views/pages/admin/'.$this->routes[substr(__FUNCTION__,3)];
    }

    private function getNewBook()
    {

        $collections = GenreQuery::giveMeAllGenres($this->pdo);

         return require __DIR__."/../views/pages/admin/".$this->routes[substr(__FUNCTION__,3)];
    }

    private function postNewBook()
    {
        $book = new Book();
        $isbn =filter_var($_POST['isbn'],FILTER_SANITIZE_NUMBER_INT);
        $book->ISBN = $isbn;

        if(!BookQuery::checkIfBookExistsInTable($this->pdo,$book))
        {
            $author = filter_var($_POST['author'],FILTER_SANITIZE_STRING);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $year = filter_var($_POST['year'], FILTER_SANITIZE_STRING);
            $genres = $_POST['genre'];
            $cover = filter_var($_FILES["cover"]["name"]);
            $createdDate = date('Y-m-d');

            // Check if any empty input terminate script
            if(empty($isbn) || empty($author) || empty($title) || empty($year) || empty($genres)
                ||empty($cover) || empty($createdDate) )  {
                exit ("Invalid inputs");
            }
            $book->author =$author;
            $book->title = $title;
            $book->year = $year;
            $book->createdDate = $createdDate;


            // Check file extension
            $allowed =  array('gif','png' ,'jpg');
            $ext = pathinfo($cover, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                exit('Invalid file format. File must be gif or png or jpg');
            }

            $book->cover = $cover;

            // Place where we want to store file
            $targetDirectory =__DIR__."/../uploads/".$cover;

            //

            //Upload file into server
            if(!move_uploaded_file($_FILES['cover']['tmp_name'],$targetDirectory)){
                exit('Cannot upload file');
            }



            // Insert Book Into Database
            BookQuery::insertBookIntoDatabase($this->pdo,$book);

            $genreCollection =new ArrayObject();


            // List All genres associated with this book. Create new Genre object and store that object into genreCollection array
            foreach ($genres as $genreId)
            {
                $genre = new Genre();
                $genre->id = $genreId;
                $genreCollection->append($genre);
            }

            // Associate book with genre
            foreach ($genreCollection as $genre)
            {
                BookQuery::InsertIntoDatabaseGenreAssociatedWithBook($this->pdo,$book,$genre);
            }

            return $this->getAllBooks();

        }

        else exit('Book already exists in table');

    }

    private function getNewUser()
    {
        return require __DIR__."/../views/pages/admin/".$this->routes[substr(__FUNCTION__,3)];
    }

    private function getAllUsers()
    {
        //Collection contain collection of User Object
        $collection = UserQuery::giveMeAllUsers($this->pdo);

        return require __DIR__."/../views/pages/admin/".$this->routes[substr(__FUNCTION__,3)];
    }

    private function getBookEdit($ISBN)
    {
        $book = new Book();
        $book->ISBN = $ISBN;

        $bookCollection = BookQuery::giveMeBook($this->pdo,$book);

            $book->author = $bookCollection['author'];
            $book->title = $bookCollection['title'];
            $book->year = $bookCollection['year'];
            $book->cover = $bookCollection['cover'];

            $selectedGenreList = BookQuery::giveMeGenreAssociatedWithBooks($this->pdo,$book);
            $book->genres =$selectedGenreList;

            $notSelectedGenreList = BookQuery::giveMeGenreNotAssociatedWithBooks($this->pdo,$book);

           return require __DIR__."/../views/pages/admin/".$this->routes[substr(__FUNCTION__,3)];
    }

    private function postBookEdit()
    {
        $book = new Book();

        $isbn = filter_var($_POST['isbn'],FILTER_SANITIZE_NUMBER_INT);
        $author = filter_var($_POST['author'],FILTER_SANITIZE_STRING);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $genres = $_POST['genre'];
        $cover = filter_var($_FILES["cover"]["name"]);
        $year = filter_var($_POST['year'], FILTER_SANITIZE_STRING);


        // Check if any empty input terminate script
        if(empty($isbn) || empty($author) || empty($title) || empty($genres) || empty($year))  {
            exit ("Invalid inputs");
        }

        echo 'PostBookEdit';

        $book->author =$author;
        $book->title = $title;
        $book->ISBN = $isbn;
        $book->year = $year;

        //Check if is user try to update cover image
        if(empty($cover))
        {
            BookQuery::updateBookWithoutCoverImage($this->pdo,$book);

            $genreCollection =new ArrayObject();


            // List All genres associated with this book. Create new Genre object and store that object into genreCollection array
            foreach ($genres as $genreId)
            {
                $genre = new Genre();
                $genre->id = $genreId;
                $genreCollection->append($genre);
            }

            BookQuery::DeleteGenreAssociatedWithBook($this->pdo,$book);

            // Associate book with genre
            foreach ($genreCollection as $genre)
            {
                BookQuery::InsertIntoDatabaseGenreAssociatedWithBook($this->pdo,$book,$genre);
            }


        }

        else
            {
                $allowed =  array('gif','png' ,'jpg');
                $ext = pathinfo($cover, PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    exit('Invalid file format. File must be gif or png or jpg');
                }

                $book->cover = $cover;

                // Place where we want to store file
                $targetDirectory =__DIR__."/../uploads/".$cover;

                //Upload file into server
                if(!move_uploaded_file($_FILES['cover']['tmp_name'],$targetDirectory)){
                    exit('Cannot upload file');
                }

                BookQuery::updateBook($this->pdo,$book);

                $genreCollection =new ArrayObject();

                // List All genres associated with this book. Create new Genre object and store that object into genreCollection array
                foreach ($genres as $genreId)
                {
                    $genre = new Genre();
                    $genre->id = $genreId;
                    $genreCollection->append($genre);
                }

                BookQuery::DeleteGenreAssociatedWithBook($this->pdo,$book);

                // Associate book with genre
                foreach ($genreCollection as $genre)
                {
                    BookQuery::InsertIntoDatabaseGenreAssociatedWithBook($this->pdo,$book,$genre);
                }


            }

            return $this->getAllBooks();


    }

    private function getBookDelete($ISBN)
    {
        $book = new Book();
        $book->ISBN = $ISBN;

      BookQuery::deleteBook($this->pdo,$book);

        return $this->getAllBooks();


    }

    private function getnewRent()
    {
        return require __DIR__."/../views/pages/admin/".$this->routes[substr(__FUNCTION__,3)];


    }

    private function postnewRent()
    {

        $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
        $ISBN = filter_var($_POST['ISBN'],FILTER_SANITIZE_NUMBER_INT);

        $user = new User();
        $user->id =$id;

        $book = new Book();
        $book->ISBN = $ISBN;

        if(UserQuery::checkIfUserExistsInTable($this->pdo,$user) && BookQuery::checkIfBookExistsInTable($this->pdo,$book))
        {
            echo $book->ISBN;
            echo $user->id;

            //Check if book is available
            if(!BookQuery::checkIfBookIsAvailable($this->pdo,$book))
            {
               exit("Book is not Available");
            }

            //Check if user rent more than 3 books
           if(BookQuery::checkIfUserRentLessOrThreeBooks($this->pdo,$user))
            {
                exit('User rent more than 3 books');
            }

          if(!UserQuery::checkIfUserIsAvailable($this->pdo,$user))
            {
                exit("User is not active ");
            }

            //After that rent book
            BookQuery::rentBook($this->pdo,$user,$book);
        }
        else exit("User or book dosen't exists");

        return $this->getNotAvailableBook();

    }

    private function getreturnBook()
    {
        return require __DIR__."/../views/pages/admin/".$this->routes[substr(__FUNCTION__,3)];
    }


    private function postreturnBook()
    {

        $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
        $ISBN = filter_var($_POST['ISBN'],FILTER_SANITIZE_NUMBER_INT);

        $user = new User();
        $user->id =$id;

        $book = new Book();
        $book->ISBN = $ISBN;

        echo $book->ISBN;
        echo $user->id;

        BookQuery::returnBook($this->pdo,$user,$book);

        return $this->getNotAvailableBook();
    }

    private function getNotAvailableBook()
    {
        $userIdCollection =  UserQuery::giveMeAllUsersIdWhoDidntReturnBook($this->pdo);

        // This variable contain collection of user object who didnt return books
        $collectionOfUsersWhoDidntReturnBook = new ArrayObject();

            foreach ($userIdCollection as $userId)
            {
                $user = new User();
                $user->id =$userId['user_id'];

                $collectionOfUsersWhoDidntReturnBook->append($user);
            }

            //Find out user first,last,name and id
        foreach ($collectionOfUsersWhoDidntReturnBook as $user)
        {
            $userInfo = UserQuery::giveMeUser($this->pdo,$user->id);
            $user->id = $userInfo['id'];
            $user->lastName = $userInfo['lastName'];
            $user->firstName = $userInfo['firstName'];
        }

        //Find which book user has rented
        foreach ($collectionOfUsersWhoDidntReturnBook as $user)
        {

            $user->books = RentQuery::giveMeBookWhichUserRent($this->pdo,$user);

        }

        // This variable help me to calculate days that passed since user rent book
        $today = new DateTime(date('Y-m-d'));

        return require __DIR__."/../views/pages/admin/notAvailableBook.php";

    }


}