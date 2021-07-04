<?php

session_start();

$fromdate = $_POST['fromdate'];
$todate = $_POST['todate'];
$message = $_POST['message'];
$answer = $_POST['answer'];
$address = $_POST['address'];
$location = $_POST['location'];

$date1 = new DateTime($fromdate);
$date2 = new DateTime($todate);

$interval = $date1->diff($date2);

$days = $interval->format('%d');

$price = $_SESSION['price'];

$locationPrice = 0;

if($location == 'yes') {
    $locationPrice += 50;
}

if($days > 7) {
    $discountPercentage = 0.1;
    $discount = ($price * $days) * $discountPercentage;
    $driver = 0;

    if($answer == 'yes') {
        $driver = $days * 15;
    }
    $totalPrice = ($price * $days) - $discount + $driver + $locationPrice;
    echo $totalPrice;
} else {
    $totalPrice = $price * $days + $locationPrice;
    echo $totalPrice;
}

$sql="INSERT INTO tblbooking(userEmail, VehicleId, FromDate, ToDate, message, Status, driver, address, addressInfo, totalPrice) VALUES(:userEmail,:VehicleId,:fromdate,:todate,:message,:driver,:address,:location,:totalPrice";

$query = $dbh->prepare($sql);
$query->bindParam(':userEmail',$userEmail,PDO::PARAM_STR);
$query->bindParam(':VehicleId',$VehicleId,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':driver',$answer,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':location',$location,PDO::PARAM_STR);
$query->bindParam(':totalPrice',$totalPrice,PDO::PARAM_STR);
$query->execute();

echo "<script>alert('Registration successfull. Now you can login');</script>";

//echo $interval->format('%d days');

?>