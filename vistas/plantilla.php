<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>ERP ALMAPOLIS</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

   <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DateTimePicker -->
  <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
   <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->
  <!-- jQuery 3 -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

 <!-- DataTimePicker -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <!--Librerias para descargar XLS PDF --->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

  <script src="vistas/bower_components/chart.js/Chart.js"></script>
  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="vistas/css/prospeccion.css">
</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
 
  <?php

  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

   echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "modulos/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "modulos/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    if(isset($_GET["ruta"])){

      if($_GET["ruta"] == "inicio" ||
         $_GET["ruta"] == "usuarios" ||
         $_GET["ruta"] == "proyectos" ||
         $_GET["ruta"] == "prospeccion" ||
         $_GET["ruta"] == "clientes" ||
         $_GET["ruta"] == "cotizador" ||
         $_GET["ruta"] == "reserva" ||         
         $_GET["ruta"] == "simulador" ||
         $_GET["ruta"] == "reportes" ||
         $_GET["ruta"] == "proforma" ||
         $_GET["ruta"] == "rep-reserva" ||
         $_GET["ruta"] == "rep-prospeccion" ||
         $_GET["ruta"] == "rep-cotizador" ||
         $_GET["ruta"] == "rep-simulador" ||
         $_GET["ruta"] == "rep-proforma" ||
         $_GET["ruta"] == "ventas-p" ||
         $_GET["ruta"] == "salir"){

        include "modulos/".$_GET["ruta"].".php";

      }else{

        include "modulos/404.php";

      }

    }else{

      include "modulos/inicio.php";

    }

    /*=============================================
    FOOTER
    =============================================*/

    include "modulos/footer.php";

    echo '</div>';

  }else{

    include "modulos/login.php";

  }

  ?>
  <script>
   //Asignando validaciones
  $('a').tooltip();
  $( "#Prospeccion" ).click(function() {
    
    window.open('prospeccion','_blank');    
  });
  //**CAMBIOS EN EL COTIZADOR//
  $('#chkdni').change(function() {
        $("#dni_cliente").prop('disabled', false);
        $("#carnet_cliente").prop('disabled', true);        
        if (!$(this).is(':checked')) {
             $("#carnet_cliente").prop('disabled', true);
             $("#dni_cliente").prop('disabled', true);
        }
    });
  $('#chkcarnet').change(function() {
        $("#dni_cliente").prop('disabled', true);
        $("#carnet_cliente").prop('disabled', false);
        if (!$(this).is(':checked')) {
             $("#dni_cliente").prop('disabled', true);
             $("#carnet_cliente").prop('disabled', true);
        }
    });
  $('#proyectos').change(function() {
        $("#proyectos").prop('disabled', true);
        $("#etapa_proyecto").prop('disabled',false);
    });
  $('#etapa_proyecto').change(function() {
        $("#etapa_proyecto").prop('disabled',true);
        $("#lotes_proyecto").prop('disabled',false);
        var proyecto = document.getElementById('proyectos').value;
        var etapa = document.getElementById('etapa_proyecto').value;
        $.post( 'extensiones/getLotes.php', { proyecto: proyecto , etapa: etapa} ).done( function(respuesta)
        {
          $( '#lotes_proyecto' ).html( respuesta );
        });        
    });
  $( "#btn_buscar_precio" ).click(function() {
    var proyecto=document.getElementById('proyectos').value;
    var etapa=document.getElementById('etapa_proyecto').value;
    var lotes=document.getElementById('lotes_proyecto').value;

    $.post( 'extensiones/consultar_precio_prospeccion.php', { proyecto: proyecto , etapa: etapa , lotes:lotes} ).done( function(respuesta)
        {
          $( '#tabla_precio_prospeccion' ).html( respuesta );
        });
    return false; 
      
  });
  $( "#btn_simulacion" ).click(function() {
    var sim_cot_pfd=document.getElementById('sim_cot_pfd').value;
    var sim_cot_mfd=document.getElementById('sim_cot_mfd').value;
    var sim_periocidad=document.getElementById('sim_periocidad').value;
    var sim_cot_tcea=document.getElementById('sim_cot_tcea').value;
    var sim_per_gracia = document.getElementById('sim_per_gracia').value;
    var calculo_tasa =parseFloat(Math.pow((1+(sim_cot_tcea/100)),(sim_periocidad/12))-1).toFixed(4);
    if(($("#sim_periocidad").val().length > 0 && $("#sim_cot_tcea").val().length > 0 && $("#sim_per_gracia").val().length > 0  && $("#sim_cot_pfd").val().length > 0 ))
    {
      $.post( 'extensiones/consultar_precio_simulacion.php', { sim_cot_pfd: sim_cot_pfd , sim_cot_mfd: sim_cot_mfd , sim_periocidad: sim_periocidad,sim_cot_tcea:sim_cot_tcea ,sim_per_gracia:sim_per_gracia} ).done( function(respuesta)
        {
          $( '#tabla_precio_simulacion' ).html( respuesta );
          $("#sim_cot_tasa").val(calculo_tasa +'%');
        });
    }
    else
    {
      swal({
              title: "Error!",
              text: "Datos Incompletos",
              type: 'error',
              confirmButtonText: "Cerrar"
              });
    }    
    return false;       
  });
  //Date picker
    $.fn.datepicker.dates['es'] = {
        days: ["Domingp", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
        daysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Today",
        clear: "Clear",
        format: "mm/dd/yyyy",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };
    $('#fecha_dos').datepicker({
      format: "dd/mm/yyyy",
      startDate: $('#fecha_uno').val(),
      language: "es",
      today: "Today",
      clear: "Borrar",
      autoclose: true
    }).on('changeDate', function(selected){
      var minDate = new Date(selected.date.valueOf());
      $('#fecha_tres').datepicker('setStartDate', minDate);
    });


    $('#fecha_tres').datepicker({
      language: "es",
      format: "dd/mm/yyyy",
      today: "Today",
      clear: "Borrar",
      autoclose: true
    });
    $('#fecha_deposito').datepicker({
      todayHighlight: true,
      format: "dd/mm/yyyy",
      language: "es",
      autoclose: true,
    });

  $('#btn_conyuge').click(function(){
    var isVisible = $('.conyu').is(':visible');
    if(isVisible === true){
      $('.conyu').hide();
    }
    else{
      $('.conyu').show(); 
    }

  });

  $('#btn_nproyect').click(function(){
    var isVisible = $('.npro').is(':visible');
    if(isVisible === true){
      $('.npro').hide();
      $('.lpro').show();
    }
    else{
      $('.npro').show();
      $('.lpro').hide(); 
    }

  });

  $('#btn_netapa').click(function(){
    var isVisible = $('.neta').is(':visible');
    if(isVisible === true){
      $('.neta').hide();
      $('.aeta').show();
    }
    else{
      $('.neta').show();
      $('.aeta').hide(); 
    }

  });

  $( "#btn_proforma" ).click(function() {
    var cot_sci_usd = document.getElementById('cot_sci_usd').value;    
    var proforma_pc=document.getElementById('proforma_pc').value;
    var fecha_uno=document.getElementById('fecha_uno').value;
    var fecha_dos=document.getElementById('fecha_dos').value;
    var fecha_tres=document.getElementById('fecha_tres').value;
    var amortizacion_uno=document.getElementById('amortizacion_uno').value;
    var amortizacion_dos=document.getElementById('amortizacion_dos').value;
    var sim_cot_pfd=document.getElementById('sim_cot_pfd').value;
    var sim_cot_mfd=document.getElementById('sim_cot_mfd').value;
    var sim_periocidad=document.getElementById('sim_periocidad').value;
    var sim_cot_tcea=document.getElementById('sim_cot_tcea').value;
    var sim_per_gracia=document.getElementById('sim_per_gracia').value;
    var fecha_jalada = $('#fecha_uno').val();
    var fecha_inicial = $('#fecha_dos').val();
    var fecha_primerpago = $('#fecha_tres').val();

    if( $("#amortizacion_dos").val().length > 0 && fecha_inicial!="" && fecha_primerpago!="")
    {
          $.post( 'extensiones/consultar_precio_proforma.php', { cot_sci_usd:cot_sci_usd,proforma_pc:proforma_pc, fecha_uno: fecha_uno,fecha_dos: fecha_dos,fecha_tres:fecha_tres,amortizacion_uno:amortizacion_uno,amortizacion_dos,amortizacion_dos,sim_cot_pfd:sim_cot_pfd,sim_cot_mfd:sim_cot_mfd,sim_periocidad:sim_periocidad,sim_cot_tcea:sim_cot_tcea,sim_per_gracia:sim_per_gracia
} ).done( function(respuesta)
        {
          $( '#tabla_precio_proforma' ).html( respuesta );
          $('#cot_pvi').val( $('#sum_i').text() );
        });
    }
    else
    {
      if(fecha_inicial=="" || fecha_primerpago==""){
          swal({
              title: "Error!",
              text: "Complete las Fechas!",
              type: 'error',
              confirmButtonText: "Cerrar"
              });  
      }
      else{
          swal({
              title: "Error!",
              text: "Datos Incorrectos!",
              type: 'error',
              confirmButtonText: "Cerrar"
              });  
      }
      
    }    

    return false;       
  });

  $('#btn_buscardni').click(function() {
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
            if(data==false)
            {
              $('#btn_conyuge').show();              
              swal({
              title: "Sin Registrar!",
              text: "Cliente no encontrado!",
              icon: "warning",
              button: "Registrar!",
              });
              $("#nombre_cliente").val('');
              $("#apellido_cliente").val('');
              $("#email_cliente").val('');
              $("#celular_cliente").val('');
              $("#direccion_cliente").val('');
              $("#distrito_cliente").val('');
              $("#medio_captacion").val('');
            /*DESBloqueamos los inputs si no encontramos resultados*/
              $("#nombre_cliente").prop('disabled', false);
              $("#apellido_cliente").prop('disabled', false);
              $("#email_cliente").prop('disabled', false);
              $("#celular_cliente").prop('disabled', false);
              $("#direccion_cliente").prop('disabled', false);
              $("#distrito_cliente").prop('disabled', false);
              $("#medio_captacion").prop('disabled',false);
            }
            else
            {
              var sessPerfil = '<?php echo $_SESSION['perfil']?>';
              var sessUser = '<?php echo $_SESSION['usuario']?>';
              if(sessPerfil=='Administrador' || (sessPerfil=='Vendedor' && sessUser == data['asesor']) ){
                  $('#btn_conyuge').hide();
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
              else{
                  swal({
                    title: "Error!",
                    text: "Este Usuario fue registrado con otro Vendedor",
                    type: 'error',
                    confirmButtonText: "Cerrar"
                    });
              }
            }            
        }        
      });    
      }
      else
      {
        swal({
              title: "Error!",
              text: "No es DNI correcto!",
              type: 'error',
              confirmButtonText: "Cerrar"
              });
      }  
      return false;
    });
  $( "#btn_buscar_carnet" ).click(function() {
      
        var carnet_cliente=document.getElementById('carnet_cliente').value;        
        if(($("#carnet_cliente").val().length > 5 && $("#carnet_cliente").val().length < 10 ))
        {
      $.ajax({
      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: "dni_cliente="+carnet_cliente,
      dataType: "json",
      success: function(data)
        {    
            if(data==false)
            {              
              swal({
              title: "Sin Registrar!",
              text: "Cliente no encontrado!",
              icon: "warning",
              button: "Registrar!",
              });
              $("#nombre_cliente").val('');
              $("#apellido_cliente").val('');
              $("#email_cliente").val('');
              $("#celular_cliente").val('');
              $("#direccion_cliente").val('');
              $("#distrito_cliente").val('');
              $("#medio_captacion").val('');
            /*DESBloqueamos los inputs si encontramos resultados*/
              $("#nombre_cliente").prop('disabled', false);
              $("#apellido_cliente").prop('disabled', false);
              $("#email_cliente").prop('disabled', false);
              $("#celular_cliente").prop('disabled', false);
              $("#direccion_cliente").prop('disabled', false);
              $("#distrito_cliente").prop('disabled', false);
              $("#medio_captacion").prop('disabled',false);
            }
            else
            {    
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
        }        
      });
            
      }
          else
      {
        swal({
              title: "Error!",
              text: "No es DNI correcto!",
              type: 'error',
              confirmButtonText: "Cerrar"
              });
      } 
      return false; 
    });
  </script>

<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/cotizador.js"></script>
<script src="vistas/js/proyectos.js"></script>
<script src="vistas/js/validar_prospeccion.js"></script>
<script src="vistas/js/validar_cotizador.js"></script>
<script src="vistas/js/validar_reserva.js"></script>
<script src="vistas/js/validar_simulador.js"></script>
<script src="vistas/js/validar_proforma.js"></script>
<script src="vistas/js/validar_proyecto.js"></script>
<script src="vistas/js/estadistica.js"></script>



</body>
</html>
