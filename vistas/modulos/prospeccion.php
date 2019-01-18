<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Prospeccion
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Prospeccion</li>
    
    </ol>
<br>

<?php
  
  if (isset($_GET['id_e'])) {
    $datos = ControladorProspeccion::ctrEditPros($_GET['id_e']);
    # code...
  }

?>
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

      <?php
        if(isset($_GET['id_e'])){
          echo '<form id="form_prospeccion" action="index.php?ruta=prospeccion&id_c='.$_GET['id_e'].'" role="form" method="post" enctype="multipart/form-data">
              <input type="hidden" id="id_pro" name="id_pro" value="'.$_GET['id_e'].'">';
        }
        else{
          echo '<form id="form_prospeccion" role="form" method="post" enctype="multipart/form-data">';
        }
      ?>
            
          <div class="box-body">
            <div class="form-group col-sm-4 pull-right">
              <h4 class="pull-left modal-title">Ingresar Tipo Cambio</h4>
              <?php
                if(isset($_GET['id_e'])){
                  echo "<input type='text' class='pull-right modal-title' id='tipo_cambio' name='tipo_cambio' placeholder='S/.'' maxlength='4' value='".$datos[0]['tipo_cambio']."'' required>";
                }
                else{
                  echo "<input type='text' class='pull-right modal-title' id='tipo_cambio' name='tipo_cambio' placeholder='S/.'' maxlength='4' required>";    
                }
              ?>
              
            </div>
            <div class="form-group col-sm-12">
              <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Datos de Usuario</h4>
            </div>            
            <div class="form-group col-sm-6">
              <label class="checkbox-inline"><input type="checkbox" id="chkdni" value="">DNI</label>
            </div> 
            <div class="form-group col-sm-6">
              <label class="checkbox-inline"><input type="checkbox" id="chkcarnet" value="">Carnet de Extranjeria</label>
            </div> 
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <?php
                if(isset($_GET['id_e'])){
                  echo "<input type='number' class='form-control' disabled id='dni_cliente' name='dni_cliente' placeholder='Ingrese D.N.I' value='".$datos[0]["dni_cliente"]."'                   required>";    
                }
                else{
                  echo "<input type='number' class='form-control' disabled id='dni_cliente' name='dni_cliente' placeholder='Ingrese D.N.I'
                   required>";
                }
            
            ?>
                  
                </div>
             </div>
             <div class="form-group col-sm-1">
                <button type="button" id="btn_buscardni" class="btn btn-primary" formnovalidate="formnovalidate"><i class="fa fa-fw fa-search"></i></button>
             </div>
             <!-- CARNET DE EXTRANJERIA -->
             <div class="form-group col-sm-5">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="number" class="form-control" disabled id="carnet_cliente" name="carnet_cliente" placeholder="Ingrese Carnet de Extranjeria" >
                </div>
             </div>
              <div class="form-group col-sm-1">
                <button type="button" id="btn_buscar_carnet" class="btn btn-primary" formnovalidate="formnovalidate"><i class="fa fa-fw fa-search"></i></button>
             </div>

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" placeholder="Nombre del Cliente" required >
              </div>          
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" class="form-control" id="apellido_cliente" name="apellido_cliente" placeholder="Apellido del Cliente" required>
              </div>
            </div>

             <!-- ENTRADA PARA LA EMAIL -->
             <div class="form-group col-sm-6">              
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="email" class="form-control" id="email_cliente" name="email_cliente" placeholder="Ingrese Email" required>
                </div>
            </div>
             <div class="form-group col-sm-6">
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                  <input type="number" class="form-control" id="celular_cliente" name="celular_cliente" placeholder="N° Celular" required>
                </div>
             </div>
            
           
            <!-- ENTRADA PARA LA EMAIL -->

             <div class="form-group col-sm-6">
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Direccion" required>
                </div>
             </div>
             <div class="form-group col-sm-6">
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="text" class="form-control" id="distrito_cliente" name="distrito_cliente" placeholder="Distrito" required>
                </div>
             </div>
             <div class="form-group col-sm-12">
                  <button type="button" id="btn_conyuge" class="btn btn-primary">Agregar Conyuge</button>
             </div>

            <div class="form-group col-sm-6 conyu" style="display: none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" id="nombre_conyuge" autocomplete="off" name="nombre_conyuge" placeholder="Nombre del Conyuge">
              </div>          
            </div>
            <div class="form-group col-sm-6 conyu" style="display: none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" class="form-control" autocomplete="off" id="apellido_conyuge" name="apellido_conyuge" placeholder="Apellido del Cliente">
              </div>
            </div>


            <div class="form-group col-sm-6 conyu" style="display: none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" class="form-control" autocomplete="off" id="dni_conyuge" name="dni_conyuge" placeholder="DNI Conyuge">
              </div>          
            </div>
            <div class="form-group col-sm-10 conyu" style="display: none;">
              Estos Campos son Opcionales.  
            </div>

            <div class="form-row">
             <div class="form-group col-sm-4">
                  <label for="codigo" class="control-label">MEDIO CAPTACION</label>
                   <select class="form-control" id="medio_captacion" name="medio_captacion">
                   <option value="">Selecciona Medio </option>
                   <option value="Pagina web">Página Web</option>
                   <option value="Oficina atencion">Oficina Atención</option>
                   <option value="Panel">Panel</option>
                   <option value="Referido">Referido</option>
                   <option value="Feria">Feria</option>
                   <option value="Radio">Radio</option>
                   <option value="Volante">Volante</option>
                   <option value="Facebook">Facebook</option>
                   </select>
             </div>
             <div class="form-group col-sm-3">
                  <label for="codigo" class="control-label">PROYECTOS</label>
                   <select class="form-control" id="proyectos" name="proyectos" required>
              <?php
                
              
              ?>
                    <option value="">Seleccionar Proyecto </option>
                    <?php
                      $cate=ControladorProyectos::ctrCategoriaP("proyecto");
                      foreach ($cate as $key => $value) {
                        if(isset($_GET['id_e'])){
                          if($datos[0]['proyecto']==$value['proyecto'] ){
                            echo "<option value='".$value['proyecto']."' selected='selected'>".$value['proyecto']."</option>";  
                          }
                          else{
                            echo "<option value='".$value['proyecto']."'>".$value['proyecto']."</option>";
                          }
                          
                        }
                        else{
                            echo "<option value='".$value['proyecto']."'>".$value['proyecto']."</option>";
                        }
                        
                      }
                    ?>
                   </select>
             </div>
             <div class="form-group col-sm-2">
                  <label for="codigo" class="control-label">ETAPA</label>
                   <select class="form-control"  id="etapa_proyecto" disabled name="etapa_proyecto" required>
                   <option value="">Seleccionar Etapa </option>
                   <?php
                      $cate=ControladorProyectos::ctrCategoriaP("etapa");
                      foreach ($cate as $key => $value) {
                        if(isset($_GET['id_e'])){
                          if($datos[0]['etapa_proyecto']==$value['etapa'] ){
                            echo "<option value='".$value['etapa']."' selected='selected'>".$value['etapa']."</option>";  
                          }
                          else{
                            echo "<option value='".$value['etapa']."'>".$value['etapa']."</option>";
                          }
                        }
                        else{
                            echo "<option value='".$value['etapa']."'>".$value['etapa']."</option>";  
                        }
                        
                      }
                    ?>
                   </select>
             </div>

             <!--- Desactivado-->
             <div class="form-group col-sm-2">
                  <label for="codigo" class="control-label">LOTES</label>                  
                   <select class="form-control" id="lotes_proyecto" disabled  name="lotes_proyecto" required>
                    <option value="0">Seleccione</option>
                   </select>
             </div>
             <div class="form-group col-sm-1">
              <label for="codigo" class="control-label">BUSCAR</label>              
                <button id="btn_buscar_precio" class="btn btn-primary"><i class="fa fa-fw fa-search"></i></button>
             </div>
             <div class="form-group col-sm-12">
              <div id="tabla_precio_prospeccion"></div>
            </div>
          </div>
        </div>
         

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <div class="errorTxt pull-left">
            
          </div>
          <button type="submit" class="btn btn-success pull-rigth" id="btn_guar_edit">Guardar</button>

        </div>
        <script src="vistas/js/prospeccion.js"></script>
        <script type="text/javascript">
                edit_prospeccion();
                    
        </script>   
        <?php
          if(isset($_GET['id_c'])){
            $editarProspeccion = new ControladorProspeccion();


            echo "<p>AQUI</p>";
            $editarProspeccion -> ctrEditarProspeccion();
          }
          else{
            $crearCliente = new ControladorClientes();
            $crearCliente -> ctrCrearCliente();
  
          }
          
        ?>

      </form>

    </div>

    </div>

  </section>
 


</div>

<!--=====================================
MODAL AGREGAR USUARIO
======================================-->



<?php

  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();

?> 


