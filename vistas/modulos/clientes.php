<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Clientes
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Clientes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive <?php if($_SESSION["perfil"] == "Administrador")
                  {
                    echo 'clientes_adm';
                  }
                  if($_SESSION["perfil"] != "Administrador")
                  {
                    echo 'clientes';
                  }
            ?>   " width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombres Completos</th>
           <th>Dni</th>
           <th>Celular</th>
           <th>Email</th>
           <th>Direccion</th>
           <th>Distrito</th>
           <?php if($_SESSION["perfil"] == "Administrador")
                  {
                    echo '<th>Accion</th>';
                  }
            ?>           

         </tr> 

        </thead>

        <tbody>

        <?php
        if($_SESSION["perfil"] == "Administrador")
          {
          $item = null;
          $valor = null;
          $orden = "id_cliente";
          }
        else
          {
          $item = "asesor";
          $valor = $_SESSION["usuario"];
          $orden = "id_cliente";
          }        
        $clientes = ControladorClientes::ctrMostrarClientes($item, $valor, $orden); 

       foreach ($clientes as $key => $value){
         
          echo ' <tr>
                  <td>'.$value["id_cliente"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["asesor"].' "><i class="fa fa-info-circle"></i></a>'.$value["nombre"].' '.$value["apellido"].'</td>
                  <td>'.$value["dni"].'</td>
                  <td>'.$value["celular"].'</td>
                  <td><a href="mailto:'.$value["email"].'" target="_top"> '.$value["email"].'</td>
                  <td>'.$value["direccion"].'</td>
                  <td>'.$value["distrito"].'</td>';      

                  if($_SESSION["perfil"] == "Administrador")
                  {
                    echo '  <td>

                    <div class="btn-group">

                      <button class="btn btn-danger btnEliminarCliente" idUsuario="'.$value["id_cliente"].'"><i class="fa fa-times"></i></button>

                    </div>  

                  </td>';
                  }      

          echo '</tr>';
        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL EDITAR USUARIO
======================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar usuario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario" value="" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-lock"></i></span> 

                <input type="password" class="form-control input-lg" name="editarPassword" placeholder="Escriba la nueva contraseña">

                <input type="hidden" id="passwordActual" name="passwordActual">

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="editarPerfil">
                  
                  <option value="" id="editarPerfil"></option>

                  <option value="Administrador">Administrador</option>

                  <option value="Especial">Especial</option>

                  <option value="Vendedor">Vendedor</option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFoto" name="editarFoto">

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="fotoActual" id="fotoActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Modificar usuario</button>

        </div>

     <?php

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarCliente = new ControladorClientes();
  $borrarCliente -> ctrBorrarCliente();

?> 


