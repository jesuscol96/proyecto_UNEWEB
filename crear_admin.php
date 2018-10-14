<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Crear admin</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	

<?php

include 'html/header.html';
include 'funciones.php';
include_once 'signup_form.php';

include_menu();

if(isset($_SESSION["id_usuarios"]) and $_SESSION["tipo"]=='A')
	signup_form(3);	



include 'html/footer.html';


?>

</body>
</html>