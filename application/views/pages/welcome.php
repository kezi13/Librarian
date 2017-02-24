<?php
require __DIR__.'/../../views/includes/header.php';

?>
<h1>LogIn</h1>
<form method="post" action="/">
    <label for="username">Username</label>
    <input type="text" id="username"  name="username" required>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <input type="submit" value="LogIn" name="LogIn">
</form>
<?php
require __DIR__.'/../../views/includes/footer.php';
?>