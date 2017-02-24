<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';

?>
<h1>All Rented Books</h1>


    <?php
    foreach ($collectionOfUsersWhoDidntReturnBook as $user)
    {   echo "
        <h4>User Info</h4>
        <table>
        <tr><td>User Id</td><td>First Name</td><td>Last Name</td></tr>
        <tr><td>$user->id</td><td>$user->firstName</td><td>$user->lastName</td></tr>
        </table>
        <h6>List of Rented Books</h6> 
        <table><tr><td>ISBN</td><td>Title</td><td>Author</td><td>Date Rented</td><td>Email Notified</td><td>Book Late</td></tr>";
    foreach ($user->books as $books)
    {
        echo "<tr><td>".$books['ISBN']."</td><td>".$books['title']."</td><td>".$books['author']."</td>
        <td>".$books['date_rented']."</td><td>".$books['email_notified']."</td><td>
        ";
        //Check if book late more than allowed 15 days
        if( $today->diff(new DateTime($books['date_rented']))->d >15) { echo "YES </td></tr>";}
            else echo "NO </td></tr>";

    }
    echo "</table>";
    echo "<hr>";




    }
    ?>


        <?php

        require __DIR__.'/../../adminIncludes/footer.php';

        ?>
