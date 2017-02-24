<?php
require __DIR__.'/../../adminIncludes/header.php';
require __DIR__.'/../../adminIncludes/navigation.php';

?>
<h1>Edit User</h1>

<form action="/UserEdit" method="post">

    <input type="hidden" id="id" name="id" required value="<?php echo $user['id']; ?>">

    <label for="firstName">First Name</label>
    <input type="text" name="firstName" required id="firstName" value="<?php echo $user['firstName']; ?>">
    <br>
    <label for="lastName">Last Name</label>
    <input type="text" name="lastName" required id="lastName" value="<?php echo $user['lastName']; ?>">
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" required id="email" value="<?php echo $user['email']; ?>">
    <br>
    <label for="telNumber">Telephone Number</label>
    <input type="number" name="telNumber" required id="telNumber" value="<?php echo $user['telNumber'];?>">
    <br>
    <label for="address">Street</label>
    <input type="text" name="address" required id="street" value="<?php echo $user['address'];?>">
    <br>
    <hr>

    <label>Gender</label>
    <?php
    if($user['sex'] =='M'){
        echo $inputMale ="<input type ='radio' name ='sex' value='M' checked>Male";
        echo $inputFemale ="<input type ='radio' name ='sex' value='F' >Female";
    }
    else
    {
        echo $inputMale ="<input type ='radio' name ='sex' value='M' >Male";
        echo $inputFemale ="<input type ='radio' name ='sex' value='F' checked>Female";
    }
    ?>

    <br>
    <br>
    <input type="submit" name="editUser" value="Update">

</form>

<?php

require __DIR__.'/../../adminIncludes/footer.php';

?>
