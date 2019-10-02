<?php
    session_start();

    require("src/log.php");

    //Login
    if(!empty($_POST['email_log']) && !empty($_POST['password_log'])){

      require('src/connect.php');

      $email_log = htmlspecialchars($_POST['email_log']);
      $password_log = htmlspecialchars($_POST['password_log']);

      //Validate email
      if(!filter_var($email_log, FILTER_VALIDATE_EMAIL)){
        header('location: index.php?error=1&message=Impossible de vous authentifier');
        exit();
      }

      //Chiffrage mot de passe
      $password_log = "aq1".sha1($password_log."123")."684";

      //Email already use
      $req = $db->prepare("SELECT count(*) as numberEmail FROM users WHERE email= ?");
      $req->execute(array($email_log));

      while($email_verification = $req->fetch()){
          if($email_verification['numberEmail'] != 1){
            header('location: index.php?error=1&message=Impossible de vous authentifier');
            exit();
          }
      }

      //connexion
      $req = $db->prepare("SELECT * FROM users WHERE email= ?");
      $req->execute(array($email_log));

      while($user = $req->fetch()){
        if($password_log == $user['password'] && $user['blocked'] == 0){
          $_SESSION['connect'] = 1;
          $_SESSION['email'] = $user['email'];

          //Remember me
          if(isset($_POST['auto_log'])){
              setcookie('auth', $user['secret'], time()+365*24*3600, null, null, false, true);
          }

          header('location: index.php?success=1');
          exit();
        
        }else{
          header('location: index.php?error=1&message=Impossible de vous authentifier');
          exit();
        }
      }
    }

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    <form method="post" action="index.php" class="form-inline my-2 my-lg-0">
        <div class="form-group mb-2">
            <label for="staticEmail2" class="sr-only">Email</label>
            <input name="email_log"type="email" value="email@example.com">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">Password</label>
            <input name="password_log" type="password" class="form-control" id="inputPassword2" placeholder="Password">
        </div>
        <div class="form-group mb-2">
            <input name="auto_log" type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Se connecter</button>

    </form>
    <?php 
      if(isset($_GET['error'])){
        if(isset($_GET['message'])){
          echo'<p>'. htmlspecialchars($_GET['message']).'</p>';
        }
      }elseif(isset($_GET['success'])){
        echo'<p>Vous êtes maintenant connecté(e)</p>';
      }
    ?>
  </div>
</nav>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Fluid jumbotron</h1>
    <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
  </div>
</div>