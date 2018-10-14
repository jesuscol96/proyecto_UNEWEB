<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Contacto</title>
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

<p><h3><b>Nuestra ubicación: </b></h3></p>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251098.19804056134!2d-67.03045450842025!3d10.468361151371065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c2a58adcd824807%3A0x93dd2eae0a998483!2sCaracas%2C+Capital+District!5e0!3m2!1sen!2sve!4v1537742190071" width="600" height="450" frameborder="0" style="border:0; width: 100%;" allowfullscreen></iframe>

<?php 

	//Correo receptor

if(isset($_POST["enviar_correo"])){

	$titulo="Mensaje interno de usuario: " . $_POST["titulo"];
	$correos=receivers_mail();
	$contenido=$_POST["contenido"];

	//Enviar mensaje
	if(mail($titulo,$correos,$contenido))
		echo "<b>Mensaje enviado exitósamente.</b>";
	else
		echo "<b>Ha ocurrido un error enviando su mensaje.</b>";

}
else{

 ?>

<p><h3><b>Comuníquese con nosotros:</b></h3></p>

<form action="" method="post">
	<table>
		<tr>
			<th>Título del mensaje: </th>
			<td><input type="text" name="titulo"></td>
		</tr>
		<tr>
			<th colspan="2" align="left">Contenido: </th>
		</tr>
		<tr>			
			<td colspan="2"><textarea name="contenido"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Enviar mensaje" name="enviar_correo"></td>
		</tr>
	</table>
</form>

<?php } ?>


<br><br>

<?php include 'html/footer.html'; ?>

</body>
</html>	