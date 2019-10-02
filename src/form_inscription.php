<?php 
  
  if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])){

    require('src/connect.php');
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);

    //Password = password_two
    if($password != $password_confirm){
      header('location: index.php?error=1&message=Vos mots de passe ne correspondent pas.');
      exit();
    }

    //Validate email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      header('location: index.php?error=1&message=Votre adresse mail est invalide.');
      exit();
    }

    //Email already use
    $req = $db->prepare("SELECT count(*) as numberEmail FROM user WHERE email = ?");
    $req->execute(array($email));

    while($email_verification = $req->fetch()){
      if($email_verification['numberEmail'] != 1){
        header('location: index.php?error=1&message=Votre adresse mail est invalide.');
        exit();
      }
    }

    //Hash
    $secret = sha1($email).time();
    $secret = sha1($secret).time();
    
    //chiffrage mdp
    $password = "aq1".sha1($password."123")."684";

    //Sending
    $req = $db->prepare("INSERT INTO users(email, password, secret) VALUE(?,?,?)");
    $req->execute(array($email, $password, $secret));
    header('location: index.php?success=1');
    exit();
  }
?>

<form method="post" action="index.php">
<?php 
    if(isset($_GET['error'])){
        if(isset($_GET['message'])){
          echo'<div class="alert alert-danger">'.htmlspecialchars($_GET['message']).'</div>';
        }
        
    }elseif(isset($_GET['success'])){
      echo'<div class="alert alert-success">Vous êtes désormais inscrit(e)</div>';
    }
  ?>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirmez votre mot de passe</label>
    <input name="password_confirm" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>