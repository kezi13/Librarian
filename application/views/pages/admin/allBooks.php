<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';

?>
<h1>All Books</h1>

<table>
    <thead>
    <tr>
        <th>ISBN</th><th>Title</th><th>Year</th><th>Cover</th><th>Created Date</th>
        <th>Author</th><th>Genres</th>
        <th>Edit</th><th>Delete</th>
    </tr>
    </thead>
    <tbody>
    
    <?php
    foreach ($collectionOfBooks as $book)
    {

        echo '<tr>';
        echo '<td>'.$book->ISBN.'</td>';
        echo '<td>'.$book->title.'</td>';
        echo '<td>'.$book->year.'</td>';
        ?>
        <td><img src="/application/uploads/<?php echo $book->cover;?> " width=64 height=64"></td>
    <?php

        echo '<td>'.$book->createdDate.'</td>';
        echo '<td>'.$book->author.'</td>';

        echo "<td>";
        foreach ($book->genres as $genre)
        {
            echo $genre['name'].',';
        }
        echo "</td>";

        echo "<td><a href=/bookEdit/$book->ISBN>Edit</a></td>";
        echo "<td><a href=/bookDelete/$book->ISBN>Delete</a></td>";

        echo "</tr>";
    }
    ?>
    </tbody>
    <table>
        <?php

        require __DIR__.'/../../adminIncludes/footer.php';

        ?>
