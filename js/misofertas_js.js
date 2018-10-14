/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for misofertas.php file 
*
* */

doc=document;
var selected_foro=1; //Foro Id
$(document).ready(function(){

	$("#modificar_oferta").hide("fast");	


});


function modificar_oferta(id_ofertas){

	$("[name='id_ofertas']").eq(0).attr("value",id_ofertas);
	$("[name='id_ofertas']").eq(1).attr("value",id_ofertas);
	$("[name='id_ofertas']").eq(2).attr("value",id_ofertas);
	$("[name='id_type']").eq(0).attr("value",id_ofertas);

	//Obtiene los valores de la oferta a modificar
	var tema=$("[name='" + id_ofertas + "']").find("th").eq(0).text();
	var descripcion=$("[name='" + id_ofertas + "']").find("td").eq(0).text();

	//Pone esos valores en el formulario
	$("[name='tema']").eq(1).attr("value",tema);
	$("#modificar_oferta").find("textarea").text(descripcion);

	//Show form
	$("#modificar_oferta").show("slow");

}