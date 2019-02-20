<?php
session_start();

// [$productID,$product_description,$price,$quantity,$conditionname,$categoryname,$sellerID,$auctionable,$enddate]=include "listing.php";

if (isset($_SESSION["listing"])) {

    //connect to database
    include 'database.php';

    //set the variables with session values and escape mysql characters

    $productID=mysqli_real_escape_string($connection,$_SESSION["listing"]["productID"]);
    $product_description=mysqli_real_escape_string($connection,$_SESSION["listing"]["product_description"]);
    $price=mysqli_real_escape_string($connection,$_SESSION["listing"]["price"]);
    $quantity=mysqli_real_escape_string($connection,$_SESSION["listing"]["quantity"]);
    $conditionname=mysqli_real_escape_string($connection,$_SESSION["listing"]["conditionname"]);
    $categoryname=mysqli_real_escape_string($connection,$_SESSION["listing"]["categoryname"]);
    $sellerID=mysqli_real_escape_string($connection,$_SESSION["listing"]["sellerID"]);
    $auctionable=mysqli_real_escape_string($connection,$_SESSION["listing"]["auctionable"]);
    $enddate=mysqli_real_escape_string($connection,$_SESSION["listing"]["enddate"]);


    //look up the categoryID and conditionID based on user input
    $sql="SELECT categoryID FROM Category WHERE categoryname='$categoryname'";
        $result=$connection->query($sql);
        if ($result==TRUE){
            $row=$result->fetch_assoc();
            $categoryID=$row['categoryID'];
        } else {
        echo "Error: ". $sql . "<br>" . $connection->error;
        }

    $sql="SELECT conditionID FROM ConditionIndex WHERE conditionname='$conditionname'";
        $result=$connection->query($sql);
        if ($result==TRUE){
            $row=$result->fetch_assoc();
            $conditionID=$row['conditionID'];
        } else {
        echo "Error: ". $sql . "<br>" . $connection->error;
        }


    if ($productID=="new"){
        //insert new row into product database with new productID
        $sql="INSERT INTO Product (product_description,price,quantity,categoryID,conditionID,sellerID,auctionable,enddate) 
            VALUES('$product_description','$price','$quantity','$categoryID','$conditionID','$sellerID','$auctionable','$enddate')";
        if ($connection->query($sql)==TRUE){
        echo "New record successfully created for product";
        } else {
        echo "Error: ". $sql . "<br>" . $connection->error;
        }
    }else{

        //fetch the existing product
        $sql="SELECT productID,product_description FROM Product WHERE productID='$productID'";
        $result=$connection->query($sql);
        if ($result==TRUE){
            $row=$result->fetch_assoc();
            echo $row['productID'].$row['product_description'];
        } else {
        echo "Error: ". $sql . "<br>" . $connection->error;
        }
        
    }

    //add item to auction table if it is auctionable
    if ($auctionable==1){
        // call the query file to insert item into auction table
    }

    $connection->close();
}
//empty the session element and destroy session
unset($_SESSION["listing"]);
session_destroy();
?>
