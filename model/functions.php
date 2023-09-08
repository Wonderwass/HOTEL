<?php
require_once "./inc/database.php";

function hotelList(){
    // se connecter à la bd  ou bd
    $db = dbConnexion();
    //prepare la requete
    $request = $db->prepare('SELECT * FROM hotels');
    //executer la requete
    try{


    $request->execute();
    //recuperer le resultat dans un tableau
    return $listHotel = $request->fetchAll(PDO::FETCH_ASSOC); // fetchAll permet de convertir en tableau et mettre plusieur elements 
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    
}
function roomList(){
    // se connecter à la bd  ou bd
    $db = dbConnexion();
    //prepare la requete
    $request = $db->prepare('SELECT * FROM rooms');
    //executer la requete
    try {


        $request->execute();
        return $listRoom = $request->fetchAll(PDO::FETCH_ASSOC); // fetchAll permet de convertir en tableau et mettre plusieur elements 
    } catch (PDOException $e) {
        echo $e->getMessage();
    }





}
function userBookList($idUser){

    // se connecter à la bd  ou bd
    $db = dbConnexion();
    //prepare la requete
    $request = $db->prepare('SELECT * FROM bookings WHERE user_id = ? AND booking_state = ?');
    // executer la requete
    try {
        $request->execute(array($idUser,'in progress'));
        return $userBookList = $request->fetchAll(PDO::FETCH_ASSOC); // fetchAll permet de convertir en tableau et mettre plusieur elements 
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}
