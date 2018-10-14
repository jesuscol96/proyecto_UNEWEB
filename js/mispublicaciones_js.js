/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for mispublicaciones.php file 
*
* */

doc=document;
$(document).ready(function(){

	$("#modificar_publicacion").hide("fast");	


});


function modificar_publicacion(id_publicaciones){

	var ids=$("[name='id_publicaciones']");

	for (var i = 0; i < ids.length ; i++)		
		ids.eq(i).attr("value",id_publicaciones);

	$("[name='id_type']").eq(0).attr("value",id_publicaciones);


	//Obtiene los valores de la oferta a modificar
	var tema=$("[name='" + id_publicaciones + "']").find("th").eq(0).text();
	var descripcion=$("[name='" + id_publicaciones + "']").find("td").eq(0).text();

	//Pone esos valores en el formulario
	$("[name='tema']").eq(1).attr("value",tema);
	$("#modificar_publicacion").find("textarea").text(descripcion);

	//Show form
	$("#modificar_publicacion").show("slow");

}