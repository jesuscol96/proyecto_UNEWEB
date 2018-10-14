<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ver oferta</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/ver_oferta_js.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

//Muestra oferta seleccionada.
ver_oferta();

if(isset($_POST["id_oferta"])){

	if(isset($_SESSION["id_usuarios"]))
		form_post($_POST["id_oferta"],"ofertas",10);
	else
		echo "<p>Inicia sesión para comentar.</p>";

?>



<div id="form_propuesta" style="display: none;">
	<table>
		<tr>
			<th>Escribir una propuesta a esta oferta: </th>
			<td><textarea  id="propuesta"></textarea></td>
			<td>
				<button id="enviar_propuesta"  
				<?php echo 'onclick="enviar_propuesta(' .$_SESSION["id_usuarios"] .','. $_POST["id_oferta"] . ')"';	?>>
					Enviar propuesta
				</button>
			</td>
		</tr>
	</table>	
</div>
<div id="resultado_oferta"></div>	

<div id="ofertas_comentarios">
	<?php
		mostrar_comentarios($_POST["id_oferta"],"ofertas");

		include 'html/footer.html';
	?>
</div>

<?php } ?>



</body>
</html>	




