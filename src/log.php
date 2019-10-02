<?php 
    if(isset($_COOKIE['auth']) && !isset($_SESSION['connect'])){
        $secret = htmlspecialchars($_COOKIE['auth']);

        require("src/connect.php");
        $req= $db->prepare("SELECT count(*) as numberAccount FROM users WHERE secret= ?");
        $req->execute(array($secret));

        while($user_secret = $req->fetch()){
            if($user_secret['numberAccount'] == 1){
                $reqUser = $db->prepare("SELECT * FROM users WHERE secret= ?");
                $reqUser->execute(array($secret));

                while($userAccount = $reqUser->fetch()){
                    $_SESSION['connect'] = 1;
                    $_SESSION['email'] = $userAccount['email'];
                }
            }
        }
    }


    //Member blocked
    if(isset($_SESSION['connect'])){

        require("src/connect.php");
        $reqUser = $db->prepare("SELECT * FROM users WHERE email= ?");
        $reqUser->execute(array($_SESSION['email']));

        while($userAccount = $reqUser->fetch()){

            if($userAccount['blocked'] == 1){
                header('location: logout.php');
                exit();
            }
            $_SESSION['connect'] = 1;
            $_SESSION['email'] = $userAccount['email'];
        }
    }
?>