<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';
?>
<h1>All Users</h1>
<table>
    <thead>
    <tr>
        <th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Telephone Number</th><th>SEX</th><th>Address</th>
        <th>Registration Date</th><th>Active Until</th><th>Edit</th><th>Delete</th>
    </tr>
    </thead>
    <tbody>
<?php

foreach ($collection as $user)
{   echo '<tr>';
    echo '<td>'.$user['id'].'</td>';
    echo '<td>'.$user['firstName'].'</td>';
    echo '<td>'.$user['lastName'].'</td>';
    echo '<td>'.$user['email'].'</td>';
    echo '<td>'.$user['telNumber'].'</td>';
    echo '<td>'.$user['sex'].'</td>';
    echo '<td>'.$user['address'].'</td>';
    echo '<td>'.$user['registrationDate'].'</td>';
    echo '<td>'.$user['activeUntil'].'</td>';

    echo "<td><a href=/UserEdit/".$user['id'].">Edit</a></td>";
    echo "<td><a href=/UserDelete/".$user['id'].">Delete</a></td>";
    echo "</tr>";
}
?>
    </tbody>
    <table>
<?php

require __DIR__.'/../../adminIncludes/footer.php';

?>
