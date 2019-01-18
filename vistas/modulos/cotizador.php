<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Cotizador      
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Cotizador</li>
    
    </ol>
<br>
<section class="content">

    <!-- Default box -->
    <div class="box">
     <div class="modal-header" style="background:#3c8dbc">          
          <div class="form-group col-sm-8">
            <h4 class="pull-left modal-title" style="color:white">Ingresar Datos</h4>
            </div>          
      </div>
      <br>
    <div class="modal-content">

      <form role="form" id="form_cotizador" method="post" enctype="multipart/form-data">     
          <div class="box-body">
          <div class="form-group col-sm-4 pull-right">
              <h4 class="pull-left modal-title">Ingresar Tipo Cambio</h4>
              <input type="text" class="pull-right modal-title" id="tipo_cambio" name="tipo_cambio" placeholder="S/." maxlength="4" required>
            </div>
            <div class="form-group col-sm-12">
              <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Datos de Usuario</h4>
            </div>             
            <!-- ENTRADA PARA EL NOMBRE -->            
            <?php

            $editarUsuario = new ControladorCotizador();
            $editarUsuario -> ctrMostrarCotizadorUrl();

            ?>            
          </div>

      

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="submit" class="btn btn-success pull-rigth">Guardar</button>        

        </div>

        <?php

          $crearCotizacion = new ControladorCotizador();
          $crearCotizacion -> ctrCrearCotizador();

        ?>

      </form>

    </div>

    </div>

  </section>
 


</div>

