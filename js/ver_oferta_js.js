/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for veroferta.php file 
*
* */



doc=document;

$(document).ready(function(){

	img=$(".image_oferta");
	descripcion_img=$(".image_descripcion");

	//Mostrar primera imagen
	img.eq(0).show();
	//Mostrar descripcion de la primera imagen.
	descripcion_img.eq(0).show();

	//Fija la cantidad de imagenes
	cambiar_imagen.cantidad= img.length;

	//Cambia las imagenes
	$("#siguiente").click(function(){
		cambiar_imagen.cambiar(1,img,descripcion_img);
	})

	$("#anterior").click(function(){
		cambiar_imagen.cambiar(0,img,descripcion_img);
	})

	$("#hacer_propuesta").click(function(){
		$("#resultado_oferta").text("");
		$("#form_propuesta").show("slow");		
	})



});








