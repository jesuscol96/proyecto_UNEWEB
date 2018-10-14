/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for profile.php file 
*
* */

doc=document;
$(document).ready(function(){

	$("#modificar_boton").click(modificar_profile);

	



});

function modificar_profile(){

	$("#modificar_tabla").show("slow");


	var data = $(".user_data");
	var target=$("#modificar_tabla").find("[name]");
	var i;

	for (i = 0; i < data.length-1; i++){
		var contenido=data.eq(i).text();
		target.eq(i).attr("value",contenido);
	}

	target.eq(i).text(data.eq(i).text());

}
