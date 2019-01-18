function edit_prospeccion() {



	var url = new URL(window.location.href);
    var id_e = url.searchParams.get("id_e");
    console.log(id_e);
    if(id_e.length > 0){
      	console.log("ENTRO");
      	var dni_cliente=document.getElementById('dni_cliente').value;  
		if(($("#dni_cliente").val().length > 7 && $("#dni_cliente").val().length < 9 ))
		{
		      $.ajax({
		      url:"ajax/clientes.ajax.php",
		      method: "POST",
		      data: "dni_cliente="+dni_cliente,
		      dataType: "json",
		      success: function(data)
		      {      
		              $('#btn_conyuge').hide();
		              $('#chkdni').hide();
		              $("#nombre_cliente").val(data["nombre"]);
		              $("#apellido_cliente").val(data["apellido"]);
		              $("#email_cliente").val(data["email"]);
		              $("#celular_cliente").val(data["celular"]);
		              $("#direccion_cliente").val(data["direccion"]);
		              $("#distrito_cliente").val(data["distrito"]);
		              $("#medio_captacion").val(data["medio_captacion"]);
		              /*Bloqueamos los inputs si encontramos resultados*/
		              $("#nombre_cliente").prop('disabled', true);
		              $("#apellido_cliente").prop('disabled', true);
		              $("#email_cliente").prop('disabled', true);
		              $("#celular_cliente").prop('disabled', true);
		              $("#direccion_cliente").prop('disabled', true);
		              $("#distrito_cliente").prop('disabled', true);
		              $("#medio_captacion").prop('disabled',true);    
		        }                    
		      });    
		}
		$("#etapa_proyecto").prop('disabled',false);

		$("#proyectos").prop('disabled',false);

		$("#lotes_proyecto").prop('disabled',false);
      	var proyecto = document.getElementById('proyectos').value;
      	var etapa = document.getElementById('etapa_proyecto').value;
      	$.post( 'extensiones/getLotes.php', { proyecto: proyecto , etapa: etapa, id_e: id_e} ).done( function(respuesta)
      	{
      	  $( '#lotes_proyecto' ).html( respuesta );
      	});  
    }
	// body...
}
$('#btn_guar_edit').click( function(){
	$("#etapa_proyecto").prop('disabled',false);

	$("#proyectos").prop('disabled',false);

	$("#lotes_proyecto").prop('disabled',false);
})

