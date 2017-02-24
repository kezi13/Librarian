<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';
?>
<h1>Edit Book</h1>
<form action="/bookEdit" enctype="multipart/form-data" method="post">

    <input type="hidden" id="isbn" name="isbn" required id="isbn" value="<?php echo $book->ISBN; ?>">
    <br>
    <label for="title">Title</label>
    <input type="text" name="title" required id="title"  value="<?php echo $book->title; ?>">
    <br>
    <label for="author">Author</label>
    <input type="text" name="author" required id="author" value="<?php echo $book->author; ?>">
    <br>

    <select name="genre[]" multiple>
        <?php
        foreach ($book->genres as $genre)
        {
            echo "<option value=".$genre['id'] . " selected>".$genre['name']."</option>";
        }

        foreach ($notSelectedGenreList as $genre)
        {
            echo "<option value=".$genre['id'] . ">".$genre['name']."</option>";
        }
        ?>
    </select>
    <br>
    <label for="year">Year</label>
    <input type="number" name="year" required id="year" value="<?php echo $book->year; ?>">
    <br>
    Select cover to upload:
    <input type="file" name="cover" id="cover">
    <input type="submit" name="updateBook" value="Update" >


    <hr>

</form>

<?php

require __DIR__.'/../../adminIncludes/footer.php';

?>
