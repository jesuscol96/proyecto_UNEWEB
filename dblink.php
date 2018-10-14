<?php

$server="localhost";
$user="root";
$password="";
$dbfile="database.txt";

if(file_exists($dbfile)){

	//Reading DB name
	$filelink=fopen($dbfile, "r");
	$database=fread($filelink, filesize($dbfile));
	fclose($filelink);
		
	//Creating a conexion object
	$link= new mysqli($server,$user,$password,$database);

	if($link->connect_error)
		die("Error conectando con la base de datos");
}
else
	echo '<meta http-equiv="refresh"  content="0; create_tables.php">';










	
