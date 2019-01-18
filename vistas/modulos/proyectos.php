<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar proyectos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar proyectos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <?php 

          if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProyecto">
          
          Agregar proyecto

        </button>';

                        }

        ?>
  
        

      </div>

      <div class="box-body">
        
       <table id="tabla_proyectos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Proyecto</th>           
           <th style="width:10px">Etapa</th>
           <th>Estado</th>
           <th>Terreno</th>
           <th>Precio Lista($)</th>
           <th>Area(m2)</th>
           <th>Fecha Separacion</th>
           <?php if($_SESSION["perfil"] == "Administrador")
            {
            echo '<th style="width:10px">Acciones</th>';
            }
           ?>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;
          $proyectos = ControladorProyectos::ctrMostrarProyectos($item, $valor);

          foreach ($proyectos as $key => $value) {
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase">'.$value["proyecto"].'</td>

                    <td class="text-uppercase">'.$value["etapa"].'</td>';
                    if($_SESSION["perfil"] == "Administrador")
                    {
            if($value["estado"] == 1)
                    {
            echo '    <td><button class="btn btn-danger btn-xs btnLiberar" idProyecto="'.$value["id_proyecto"].'" estadoProyecto="0">Reservado</button><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Reservado : '.$value["vendedor"].' "><i class="fa fa-info-circle"></i></a></td>';
                    }
            else if($value["estado"] == 2)
                    {
            echo '    <td><button class="btn btn-danger btn-xs btnLiberar" idProyecto="'.$value["id_proyecto"].'" estadoProyecto="0">Vendido</button><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Vendedor : '.$value["vendedor"].' "><i class="fa fa-info-circle"></i></a></td>';
                    }
                    else
                    {

            echo '     <td><button class="btn btn-success btn-xs">Libre</button></td>';

                    }
                    }
                    else
                    {
                    if($value["estado"] == 1)
                      {
            echo '    <td><button class="btn btn-danger btn-xs">Reservado</button></td>';
                    }
                    else if($value["estado"] == 2)
                    {
            echo '    <td><button class="btn btn-danger btn-xs">Vendido</button></td>';
                    }
                    else
                    {

            echo '     <td><button class="btn btn-success btn-xs">Libre</button></td>';

                  }
                    }
            echo '          <td class="text-uppercase">'.$value["terreno"].'</td>

                    <td class="text-uppercase">$ '.$value["precio_lista"].'</td>
                    <td class="text-uppercase"><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["precio_metro"].' "><i class="fa fa-info-circle"></i></a>'.$value["area"].'</td>
                    <td class="text-uppercase">'.$value["fecha_separacion"].'</td>';
                    if($_SESSION["perfil"] == "Administrador"){
                          echo '<td>
                                <div class="btn-group">
                                <button class="btn btn-warning btnEditarProyecto" idProyecto="'.$value["id_proyecto"].'" data-toggle="modal" data-target="#modalEditarProyecto"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btnEliminarProyecto" idProyecto="'.$value["id_proyecto"].'"><i class="fa fa-times"></i></button>
                                  </div>
                              </td>';

                        }


          echo '    </tr>';
          }

        ?>

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>
<!--=====================================
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarProyecto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="form_proyecto_c" novalidate>

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar proyecto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group col-sm-6">
              
              
                <div class="form-group col-sm-6">
                  <button type="button" id="btn_nproyect" class="btn btn-primary">Nuevo Proyecto</button>
                </div>
            </div>
            <div class="form-group col-sm-6">
              
              
                <div class="form-group col-sm-6">
                  <button type="button" id="btn_netapa" class="btn btn-primary">Nueva Etapa</button>
                </div>
            </div>
            <div class="form-group npro" style="display: none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" class="form-control" id="nuevo_pro" autocomplete="off" name="nuevo_pro" placeholder="Nuevo Proyecto">
              </div>          
            </div>
            <div class="form-group lpro">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 


                <select class="form-control" id="nuevoProyecto" name="nuevoProyecto" required>
                  <option value="">Seleccionar Proyecto </option>
                <?php
                  $cate=ControladorProyectos::ctrCategoriaP("proyecto");
                  foreach ($cate as $key => $value) {
                    echo "<option value='".$value['proyecto']."'>".$value['proyecto']."</option>";
                  }
                ?>
                
                </select>

              </div>
            </div>
             <!-- ENTRADA PARA EL NOMBRE PROYECTO -->
             <div class="form-group neta" style="display: none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
   class="form-control" id="nueva_eta" maxlength="2" autocomplete="off" name="nueva_eta" placeholder="Nueva Etapa">
              </div>          
            </div>
             <div class="form-group aeta">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <select class="form-control" id="etapaProyecto" name="etapaProyecto" required>
                   <option value="">Seleccionar Etapa </option>
                <?php
                  $cate=ControladorProyectos::ctrCategoriaP("etapa");
                  foreach ($cate as $key => $value) {
                    echo "<option value=".$value['etapa'].">".$value['etapa']."</option>";
                    # code...
                    }
                ?>
                   </select>

              </div>

            </div>
             <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" name="terrenoProyecto" maxlength="4" placeholder="Ingresar Terreno" id="terrenoProyecto" required>

              </div>

            </div>
             <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control input-lg" maxlength="8" name="precioProyecto" placeholder="Ingresar Precio" id="precioProyecto" required>

              </div>

            </div>
            <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" class="form-control input-lg" name="areaProyecto" placeholder="Ingresar Area" id="areaProyecto" required>

              </div>

            </div>

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6" class="form-control input-lg" name="precioMetro" placeholder="Precio por Metro" id="precioMetro" required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar proyecto</button>

        </div>

        <?php

          $crearProyecto = new ControladorProyectos();
          $crearProyecto -> ctrCrearProyecto();

        ?>

      </form>

    </div>

  </div>

</div>
<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarProyecto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="form_proyecto">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar proyecto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
           

            
            <div class="form-group">
              
              <div class="input-group">
                <input type="hidden"  name="idProyecto" id="idProyecto" required>
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 


                <select class="form-control" id="editarProyecto" name="editarProyecto" required>
                  <option value="">Seleccionar Proyecto </option>
                <?php
                  $cate=ControladorProyectos::ctrCategoriaP("proyecto");
                  foreach ($cate as $key => $value) {
                    echo "<option value='".$value['proyecto']."'>".$value['proyecto']."</option>";
                  }
                ?>
                
                </select>

              </div>
            </div>
             <!-- ENTRADA PARA EL NOMBRE PROYECTO -->
             
             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <select class="form-control" id="editarEtapa" name="editarEtapa" required>
                   <option value="">Seleccionar Etapa </option>
                <?php
                  $cate=ControladorProyectos::ctrCategoriaP("etapa");
                  foreach ($cate as $key => $value) {
                    echo "<option value=".$value['etapa'].">".$value['etapa']."</option>";
                    # code...
                    }
                ?>
                </select>

              </div>

            </div>
             <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" maxlength="4" name="editarTerreno" placeholder="Ingresar Terreno" id="editarTerreno" required>

              </div>

            </div>
             <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" class="form-control input-lg" name="editarPrecio" placeholder="Ingresar Precio" id="editarPrecio" required>

              </div>

            </div>
            <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" class="form-control input-lg" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" name="editarArea" placeholder="Ingresar Area" id="editarArea" required>

              </div>

            </div>

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6" class="form-control input-lg" name="editarMetro" placeholder="Precio por Metro" id="editarMetro" required>

              </div>

            </div>
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      <?php

          $editarProyecto = new ControladorProyectos();
          $editarProyecto -> ctrEditarProyecto();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarProyecto = new ControladorProyectos();
  $borrarProyecto -> ctrBorrarProyecto();

?>