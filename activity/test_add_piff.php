<?php

include "../database.php";
include "probability_diff_interface.php"; 
$sql="SELECT * FROM archive";
$result = $connection->query($sql);

if ($result->num_rows>0) {
    while ($row=$result->fetch_assoc()) {
        $productID = $row["productID"];
        $userID = $row["buyerID"];

        echo "<br>";
        echo $productID;
        echo "<br>";

        $array = [];
        $array["productID"] = $productID;
        $array["userID"] = $userID; 
        set_popularity_diff($array, "insert");
    }
}
?>