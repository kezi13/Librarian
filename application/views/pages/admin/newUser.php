<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';
?>
<h1>New User</h1>
<form action="/newUser" method="post">
    <label for="id">ID</label>
    <input type="number" id="id" name="id" required id="id">
    <br>
    <label for="firstName">First Name</label>
    <input type="text" name="firstName" required id="firstName">
    <br>
    <label for="lastName">Last Name</label>
    <input type="text" name="lastName" required id="lastName">
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" required id="email">
    <br>
    <label for="telNumber">Telephone Number</label>
    <input type="number" name="telNumber" required id="telNumber">
    <br>
    <label for="address">Address</label>
    <input type="text" name="address" required id="address">
    <br>
    <label>Gender</label>
    <input type="radio" name="sex" value="M" checked> Male
    <input type="radio" name="sex" value="F"> Female<br>
    <br>
    <input type="submit" name="newBook" value="Add">

</form>

<?php

require __DIR__.'/../../adminIncludes/footer.php';

?>
