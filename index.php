<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Index</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/index_js.js"></script>
</head>
<body>


<?php

require_once 'dblink.php';
require_once 'funciones.php';
include_once 'signup_form.php';
include 'html/header.html';

include_menu();



?>

<div id="index1">

	<?php 

	if(isset($_SESSION["id_usuarios"]))
		echo "<div id='greet_index'>¡Hola ". $_SESSION["nombre"] . "!</div>";

	else{ 
		 ?>
	
			<button id="login_boton">¡Inicia sesión!</button>
			<br>
			<button id="signup_boton">¡Crea tu usuario!</button>

		<?php
	}
 ?>
		
	
	
</div>

<?php 

	if(!isset($_SESSION["id_usuarios"])){

	echo "<div id='index_login' style='display: none;'>";
	echo "<h4><p>Inicia sesión: </p></h4>";
	include 'html/login.html';
	echo "</div>";

	echo "<div id='index_signup' style='display: none;'>";
	echo "<h4></p>Crea tu usuario: </p></h4>";
	signup_form(1);
	echo "</div>";
}

	include 'html/footer.html';


 ?>
	
</body>
</html>