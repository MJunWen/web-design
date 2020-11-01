<?php

//$db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee'); this line for lab computer
@$db = new mysqli('localhost', 'root', null, 'f37ee', '3306');

if (!$db) {
   die('Please check your connection'.mysqli_error($db));
}

?>
