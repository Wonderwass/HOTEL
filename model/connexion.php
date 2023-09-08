<?php
session_start();
require_once "../inc/database.php";

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    //etablir la connexion avec la base de données 
    $db = dbConnexion();
    //preparer la requete
    $request = $db->prepare("SELECT * FROM users WHERE email = ? ");
    //on execute la requete
    try {
        $request->execute(array($email));
        //recuperer le resultat de la requete
        $userInfo = $request->fetch(PDO::FETCH_ASSOC);
        if (empty($userInfo)) {
            echo "utilisateur inconnue";
        } else {
            //verifier si le mot de passe est correct
            if (password_verify($password, $userInfo["password"])) {
                if($userInfo['role']=="admin"){
                    $_SESSION['role']= $userInfo['role'];
                    header("Location:https://hotelwss.000webhostapp.com/admin/admin.php");
                }else{
                    $_SESSION['role'] = $userInfo['role'];
                    $_SESSION['id_user'] = $userInfo['id_user'];
                    header("Location: https://hotelwss.000webhostapp.com/user_home.php");
                }
            } else {
                echo "Ah tu fais le malin";
            }
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}