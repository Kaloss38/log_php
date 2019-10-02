<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="style/default.css">
	<link rel="icon" type="image/pngn" href="img/favicon.png">
</head>
<body>

	<?php require('src/header.php'); ?>
	
	<!-- If user is auth, switch content -->
	<?php if(isset($_SESSION['connect'])){ ?>
		<p> Bienvenue </p>
		<?php 
			
			
			echo'<p>Votre adresse mail est '.$_SESSION['email'].'</p>';
			//Logout
			echo'<small><a href="logout.php">Déconnexion</a></small>';
		?>
	<?php }else{ ?>
		<section class="container">
			<?php require('src/form_inscription.php') ?>
		</section>
	<?php } ?>

	<iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2804.3045230090506!2d5.304858315816687!3d45.342664749565294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDXCsDIwJzMzLjYiTiA1wrAxOCcyNS40IkU!5e0!3m2!1sfr!2sfr!4v1569918176055!5m2!1sfr!2sfr" width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
	

	<?php require('src/footer.php'); ?>
</body>
</html>