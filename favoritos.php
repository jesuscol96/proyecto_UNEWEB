<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Favoritos</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>	
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

?>


<div id="favoritos">
	<div id="perfiles_fav">
		<p><b>Perfiles favoritos</b></p>
		<?php ver_perfiles_fav(); ?>
		
	</div>

	<div id="ofertas_fav">
		<p><b>Ofertas favoritas</b></p>
		<?php ver_ofertas_fav(); ?>

		
		
	</div>

	<div id="pub_fav">
		<p><b>Publicaciones favoritas</b></p>
		<?php ver_publicaciones_fav(); ?>
		
	</div>
</div>


<?php include 'html/footer.html'; ?>

</body>
</html>	