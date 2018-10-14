<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Set tables</title>
</head>
<body>
	

<?php
	
if(isset($_POST["db"])){

	//Selecting DB
	$database=$_POST["db"];
	//write to file
	$dbfile="database.txt";
	$filelink=fopen($dbfile, "w");
	fwrite($filelink, $database);
	fclose($filelink);

	require_once 'dblink.php';

	//Creating tables

	//Query
	$sql="CREATE TABLE usuarios(
		  id_usuarios INT AUTO_INCREMENT,
		  nombre VARCHAR(30),
		  apellido VARCHAR(30),
		  clave CHAR(32),
		  tipo CHAR(1),
		  email VARCHAR(50),
		  username VARCHAR(30),
		  link_image VARCHAR(255),
		  universidad VARCHAR(50),
		  profesion VARCHAR(50),
		  nivel_academico VARCHAR(50),
		  descripcion BLOB,
		  PRIMARY KEY(id_usuarios))";

	if($link->query($sql))
		echo 'Tabla "usuarios" creada <br>';
	else
		echo 'Error creando base de datos "usuarios":  ' . $link->error . '<br>';



	//Query
	$sql="CREATE TABLE usuarios_fav_fav(
		  id_usuarios_fav INT AUTO_INCREMENT,	  
		  fk_usuarios INT,
		  fk_usuarios_fav INT,		  
		  PRIMARY KEY(id_usuarios_fav),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_usuarios_fav) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "usuarios_fav_fav" creada <br>';
	else
		echo 'Error creando base de datos "usuarios_fav_fav":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE foros(
		  id_foros INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  tema VARCHAR(50),
		  descripcion BLOB,
		  PRIMARY KEY(id_foros),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE);";

	if($link->query($sql))
		echo 'Tabla "foros" creada <br>';
	else
		echo 'Error creando base de datos "foros":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE foro_comentarios(
		  id_foro_comentarios INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  fk_foros INT,
		  fecha DATETIME,
		  contenido BLOB,
		  PRIMARY KEY(id_foro_comentarios),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_foros) REFERENCES foros(id_foros)
		  ON UPDATE CASCADE ON DELETE CASCADE);";

	if($link->query($sql))
		echo 'Tabla "foro_comentarios" creada <br>';
	else
		echo 'Error creando base de datos "foro_comentarios":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE chats(
		  id_chats INT AUTO_INCREMENT,
		  fk_usuarios1 INT,
		  fk_usuarios2 INT,		  		  
		  PRIMARY KEY(id_chats),
		  FOREIGN KEY(fk_usuarios1) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_usuarios2) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE);";

	if($link->query($sql))
		echo 'Tabla "chats" creada <br>';
	else
		echo 'Error creando base de datos "chats":  ' . $link->error . '<br>';

	//Query // mostrar: 1 al autor del mensaje solamente, 2 al receptor del mensaje solamente, 3 a los dos, default: ninguno de los dos.
	$sql="CREATE TABLE chats_mensajes(
		  id_chats_mensajes INT AUTO_INCREMENT,
		  mostrar INT(1),
		  fk_chats INT,
		  fk_usuarios INT,
		  fecha DATETIME,
		  contenido BLOB,
		  PRIMARY KEY(id_chats_mensajes),
		  FOREIGN KEY(fk_chats) REFERENCES chats(id_chats)
		  ON UPDATE CASCADE ON DELETE CASCADE);";

	if($link->query($sql))
		echo 'Tabla "chats_mensajes" creada <br>';
	else
		echo 'Error creando base de datos "chats_mensajes":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE categorias(
		  id_categorias INT AUTO_INCREMENT,
		  campo VARCHAR(50),
		  PRIMARY KEY(id_categorias));";

	if($link->query($sql))
		echo 'Tabla "categorias" creada <br>';
	else
		echo 'Error creando base de datos "categorias":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE ofertas(
		  id_ofertas INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  tema VARCHAR(30),			  
		  descripcion BLOB,
		  fecha DATETIME,		  
		  PRIMARY KEY(id_ofertas),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE);";

	if($link->query($sql))
		echo 'Tabla "ofertas" creada <br>';
	else
		echo 'Error creando base de datos "ofertas":  ' . $link->error . '<br>';


	//Query
	$sql="CREATE TABLE propuestas(
		  id_propuestas INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  fk_ofertas INT,
		  descripcion BLOB,				   
		  PRIMARY KEY(id_propuestas),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_ofertas) REFERENCES ofertas(id_ofertas)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "propuestas" creada <br>';
	else
		echo 'Error creando base de datos "propuestas":  ' . $link->error . '<br>';


	//Query
	$sql="CREATE TABLE media_ofertas(
		  id_media_ofertas INT AUTO_INCREMENT,
		  link VARCHAR(255),
		  descripcion VARCHAR(255),
		  type VARCHAR(15),
		  fk_ofertas INT,
		  PRIMARY KEY(id_media_ofertas),
		  FOREIGN KEY(fk_ofertas) REFERENCES ofertas(id_ofertas)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "media_ofertas" creada <br>';
	else
		echo 'Error creando base de datos "media_ofertas":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE ofertas_comentarios(
		  id_ofertas_comentarios INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  fk_ofertas INT,
		  contenido BLOB,
		  fecha DATETIME,		   
		  PRIMARY KEY(id_ofertas_comentarios),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_ofertas) REFERENCES ofertas(id_ofertas)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "ofertas_comentarios" creada <br>';
	else
		echo 'Error creando base de datos "ofertas_comentarios":  ' . $link->error . '<br>';


	//Query
	$sql="CREATE TABLE ofertas_categorias(
		  id_ofertas_categorias INT AUTO_INCREMENT,
		  fk_categorias INT,
		  fk_ofertas INT,				   
		  PRIMARY KEY(id_ofertas_categorias),
		  FOREIGN KEY(fk_categorias) REFERENCES categorias(id_categorias)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_ofertas) REFERENCES ofertas(id_ofertas)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "ofertas_categorias" creada <br>';
	else
		echo 'Error creando base de datos "ofertas_categorias":  ' . $link->error . '<br>';

		//Query
	$sql="CREATE TABLE ofertas_fav(
		  id_ofertas_fav INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  fk_ofertas INT,				   
		  PRIMARY KEY(id_ofertas_fav),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_ofertas) REFERENCES ofertas(id_ofertas)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "ofertas_fav" creada <br>';
	else
		echo 'Error creando base de datos "ofertas_fav":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE publicaciones(
		  id_publicaciones INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  tema VARCHAR(20),		  		  
		  descripcion BLOB,	
		  fecha DATETIME,	  
		  PRIMARY KEY(id_publicaciones),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE);";

	if($link->query($sql))
		echo 'Tabla "publicaciones" creada <br>';
	else
		echo 'Error creando base de datos "publicaciones":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE media_publicaciones(
		  id_media_publicaciones INT AUTO_INCREMENT,
		  link VARCHAR(255),
		  descripcion VARCHAR(255),
		  type VARCHAR(15),
		  fk_publicaciones INT,
		  PRIMARY KEY(id_media_publicaciones),
		  FOREIGN KEY(fk_publicaciones) REFERENCES publicaciones(id_publicaciones)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "media_publicaciones" creada <br>';
	else
		echo 'Error creando base de datos "media_publicaciones":  ' . $link->error . '<br>';

	//Query
	$sql="CREATE TABLE publicaciones_comentarios(
		  id_publicaciones_comentarios INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  fk_publicaciones INT,
		  contenido BLOB,
		  fecha DATETIME,		   
		  PRIMARY KEY(id_publicaciones_comentarios),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_publicaciones) REFERENCES publicaciones(id_publicaciones)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "publicaciones_comentarios" creada <br>';
	else
		echo 'Error creando base de datos "publicaciones_comentarios":  ' . $link->error . '<br>';


	//Query
	$sql="CREATE TABLE publicaciones_categorias(
		  id_publicaciones_categorias INT AUTO_INCREMENT,
		  fk_categorias INT,
		  fk_publicaciones INT,				   
		  PRIMARY KEY(id_publicaciones_categorias),
		  FOREIGN KEY(fk_categorias) REFERENCES categorias(id_categorias)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_publicaciones) REFERENCES publicaciones(id_publicaciones)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "publicaciones_categorias" creada <br>';
	else
		echo 'Error creando base de datos "publicaciones_categorias":  ' . $link->error . '<br>';

		//Query
	$sql="CREATE TABLE publicaciones_fav(
		  id_publicaciones_fav INT AUTO_INCREMENT,
		  fk_usuarios INT,
		  fk_publicaciones INT,				   
		  PRIMARY KEY(id_publicaciones_fav),
		  FOREIGN KEY(fk_usuarios) REFERENCES usuarios(id_usuarios)
		  ON UPDATE CASCADE ON DELETE CASCADE,
		  FOREIGN KEY(fk_publicaciones) REFERENCES publicaciones(id_publicaciones)
		  ON UPDATE CASCADE ON DELETE CASCADE);";


	if($link->query($sql))
		echo 'Tabla "publicaciones_fav" creada <br>';
	else
		echo 'Error creando base de datos "publicaciones_fav":  ' . $link->error . '<br>';


	$link->close();

	//Temporal session variables.
	$_SESSION["id_usuarios"]="temporal";
	$_SESSION["tipo"]='A';


	?>
	<meta http-equiv="refresh"  content="1; crear_admin.php">
	<?php
}  

else{  

	?>
	<h3>Por favor, ingrese una base de datos existente:</h3>
		<form action="" method="post">
			<input type="text" name="db">
			<input type="submit" value="Usar DB">			
		</form>
	<?php
  } 

 ?>
	
</body>
</html>
