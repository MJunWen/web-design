<?php
include 'connection.php';

    if(isset($_POST['submit'])){
        $search = mysqli_real_escape_string($db, $_POST['search']);
        //check product name if got any kind of keyword typed in searchfield
        $sql = "SELECT * FROM products WHERE product_name LIKE '%$search%' OR product_price LIKE '%$search%'"; 
        $result = mysqli_query($db, $sql);
        $queryResult = mysqli_num_rows($result);

        if($queryResult > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo $row['product_name'];
                    
            }
        }
        else {
            echo "There are no results matching your search!";
        }
    }
?>