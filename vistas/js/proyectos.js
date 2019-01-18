/*=============================================
EDITAR Proyecto
=============================================*/
$(".tablas").on("click", ".btnEditarProyecto", function(){

	var idProyecto = $(this).attr("idProyecto");

	var datos = new FormData();
	datos.append("idProyecto", idProyecto);

	$.ajax({
		url: "ajax/proyectos.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

     		$("#editarProyecto").val(respuesta["proyecto"]);
     		$("#idProyecto").val(respuesta["id_proyecto"]);

     	}

	})


})
$(".btnEditarProyecto").click(function(){
	console.log("Entro");

	var idProyecto = $(this).attr("idProyecto");
	
	var datos = new FormData();
	datos.append("idProyecto", idProyecto);

	$.ajax({

		url:"ajax/proyectos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarProyecto").val(respuesta["proyecto"]);
			$("#editarEtapa").val(respuesta["etapa"]);
			$("#editarTerreno").val(respuesta["terreno"]);
			$("#editarPrecio").val(respuesta["precio_lista"]);
			$("#editarArea").val(respuesta["area"]);
			$("#editarMetro").val(respuesta["precio_metro"]);


		}

	});
})
/*=============================================
ACTIVAR USUARIO
=============================================*/
$(document).on("click", ".btnLiberar", function(){

	var idProyecto = $(this).attr("idProyecto");
	var estadoProyecto = $(this).attr("estadoProyecto");

	var datos = new FormData();
 	datos.append("activarId", idProyecto);
  	datos.append("activarProyecto", estadoProyecto);

  	$.ajax({

	  url:"ajax/proyectos.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
		
      		 swal({
		      	title: "El proyecto ha sido liberado",
		      	type: "success",
		      	confirmButtonText: "¡Cerrar!"
		    	}).then(function(result) {
		        
		        	if (result.value) {

		        }

		      });

      }

  	})
  	if(estadoProyecto == 0){

  		$(this).removeClass('btn-danger');
  		$(this).addClass('btn-success');
  		$(this).html('Libre');
  		$(this).attr('estadoProyecto',0);

  	}


})
/*=============================================
ELIMINAR Proyecto
=============================================*/
$(".tablas").on("click", ".btnEliminarProyecto", function(){

	 var idProyecto = $(this).attr("idProyecto");

	 swal({
	 	title: '¿Está seguro de borrar el proyecto?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar proyecto!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=proyectos&idProyecto="+idProyecto;

	 	}

	 })

})