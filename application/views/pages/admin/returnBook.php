<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';
?>
<h1>Return Book</h1>
<form action="/returnBook" method="post">
    <label for="id">User id</label>
    <input type="number" name="id" id="id"required>
    <label for="ISBN">ISBN</label>
    <input type="number" name="ISBN" id="ISBN" required>
    <input type="submit" value="Rent Book">
</form>

<?php

require __DIR__.'/../../adminIncludes/footer.php';

?>
