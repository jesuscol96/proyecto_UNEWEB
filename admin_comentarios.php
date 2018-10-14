<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrar comentarios</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/misforos_js.js"></script>
	<script src="js/funciones.js"></script>
</head>
<body>	
<?php

require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();
eliminar_admin_comentarios("ofertas");
eliminar_admin_comentarios("publicaciones");
if(isset($_SESSION["id_usuarios"]) and $_SESSION["tipo"]=='A'){
?>


<div id="admin_comentarios_container">

	<div id="coment_ofertas">
		<p><b>Comentarios de ofertas: </b></p>
		<?php admin_comentarios("ofertas"); ?>

		
		
	</div>

	<div id="coment_pub">
		<p><b>Comentarios de publicaciones: </b></p>
		<?php admin_comentarios("publicaciones"); ?>
		
	</div>	

</div>






<?php
}


?>
</body>
</html>