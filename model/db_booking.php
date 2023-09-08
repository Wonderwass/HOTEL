<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/HOTEL/inc/database.php";
if (isset($_POST['book'])) {
    //recuperer les informations
    $idRoom = htmlspecialchars($_POST['id_room']);
    $startDate = htmlspecialchars($_POST['start_date']);
    $endDate = htmlspecialchars($_POST['end_date']);
    $price = htmlspecialchars($_POST['price']);
    // convertir en date
    $dateStart = strtotime($startDate);
    $dateEnd = strtotime($endDate);
    $duration = $dateEnd - $dateStart;
    $nbDays = $duration / 86400;
    $today = date("j-m-y");//la date d'aujourd'hui
    //si $today est supérieur a la date de debut de reservation ou $today est superieur a la date  de fin de reservation
    if(strtotime($today)> strtotime($startDate) || strtotime($today) > strtotime($endDate)){
        echo "<script>alert (votre date de debut ou de fin de reservation ne peut pas etre inferieur a la date d'aujourd'hui)</script>";
     echo '<script>window.location.href = "http://localhost/HOTEL/booking.php?room='.$idRoom.'&price='.$price.'";</script>';

    }else{
        $db = dbConnexion();
        //preparer la requete pour verifier si la chambre est dispo entre la date de depart et la date de fin 
        $request = $db->prepare("SELECT * FROM bookings WHERE room_id = ? AND ((booking_start_date <= ? AND booking_end_date >= ?) OR (booking_start_date <= ? AND booking_end_date >= ?))");
        // éxécuter la requette
        try {
            $request->execute(array($idRoom, $startDate, $startDate, $endDate, $endDate));

            // récupérer le resultat
            $books = $request->fetch();
            if (empty($books)) {
                if ($startDate < $endDate) {
                    //preparer la requete pour reserver la chambre
                    $request = $db->prepare('INSERT INTO `bookings`(`booking_start_date`,`booking_end_date`,`user_id`,`room_id`,`booking_price`,`booking_state`)VALUES(?,?,?,?,?,?)');
                    try {
                        $request->execute(array($startDate, $endDate, $_SESSION['id_user'], $idRoom, $price * $nbDays, 'in progress'));
                        //redirriger ver user_home.php
                        header('Location:http://locathost/user_home.php/');

                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            } else {
                echo "This room is unavailable for these dates";
            }
            // print_r($books);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
 

    echo "le nombre de jour est: $nbDays ";
    //se connecter a la bd
    $db = dbConnexion();
    //preparer la requete pour verifier si la chambre est dispo entre la date de depart et la date de fin 
    $request = $db->prepare("SELECT * FROM bookings WHERE room_id = ? AND ((booking_start_date <= ? AND booking_end_date >= ?) OR (booking_start_date <= ? AND booking_end_date >= ?))");
    // éxécuter la requette
    try {
        $request->execute(array($idRoom, $startDate, $startDate, $endDate, $endDate));

        // récupérer le resultat
        $books = $request->fetch();
        if (empty($books)) {
            if ($startDate < $endDate) {
                //preparer la requete pour reserver la chambre
                $request = $db->prepare('INSERT INTO `bookings`(`booking_start_date`,`booking_end_date`,`user_id`,`room_id`,`booking_price`,`booking_state`)VALUES(?,?,?,?,?,?)');
                try {
                    $request->execute(array($startDate, $endDate, $_SESSION['id_user'], $idRoom, $price * $nbDays, 'in progress'));

                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        } else {
            echo "This room is unavailable for these dates";
        }
        // print_r($books);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
if(isset($_GET['id_book'])){

    // se connecter a la base de données 
    $db = dbConnexion();
    //préparer la requete pour annuler la réservation
    $request = $db->prepare(('UPDATE bookings SET booking_state = ? WHERE id_booking =?'));
    //executer la requete
    try{
        $request->execute(array('cancel', $_GET['id_book']));
        //redirection vers user_home.php
        header('Location: http://user_home.php');
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}