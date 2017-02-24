<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';
?>
<h1>New Book</h1>
<form action="/newBook" enctype="multipart/form-data" method="post">
    <label for="isbn">ISBN</label>
    <input type="number" id="isbn" name="isbn" required id="isbn">
    <br>
    <label for="title">Title</label>
    <input type="text" name="title" required id="title">
    <br>
    <label for="author">Author</label>
    <input type="text" name="author" required id="author">
    <br>

    <select name="genre[]" multiple>
        <?php
        foreach ($collections as $genre)
        {
            echo "<option value=".$genre['id'].">".$genre['name']."</option>";
        }
        ?>
    </select>
    <br>
    <label for="year">Year</label>
    <input type="number" name="year" required id="year">
    <br>
    Select cover to upload:
    <input type="file" name="cover" id="cover" required>
    <input type="submit" name="newBook" value="newBook" >


    <hr>

</form>

<?php

require __DIR__.'/../../adminIncludes/footer.php';

?>
