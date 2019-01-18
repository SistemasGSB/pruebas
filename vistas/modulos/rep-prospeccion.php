<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      Reporte Prospecciones
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Reporte Prospecciones</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
      <div class="box-header with-border">
  
        <button class="btn btn-primary" id="Prospeccion">
          Agregar prospeccion
        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive <?php if($_SESSION["perfil"] == "Administrador")
                  {
                    echo 'tablas_rep-prospeccion_adm';
                  }
                  
                  if($_SESSION["perfil"] != "Administrador")
                  {
                    echo 'tablas_rep-prospeccion';
                  }
            ?>" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>DNI</th>
           <th>Nombres</th>
           <th>Proyecto</th>
           <th style="width:10px">Etapa</th>
           <th style="width:10px">Terreno</th>
           <th>Precio</th>
           <th>Area</th>
           <th>Fecha</th>
           <th>Accion</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        if($_SESSION["perfil"] == "Administrador")
          {
          $item = null;
          $valor = null;
          }
        else
          {
          $item = "asesor";
          $valor = $_SESSION["usuario"];
          } 

      $usuarios = ControladorProspeccion::ctrMostrarProspeccion($item, $valor);

       foreach ($usuarios as $key => $value){
         
          echo ' <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["dni"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["asesor"].' "><i class="fa fa-info-circle"></i></a>'.$value["nombre"].' '.$value["apellido"].'</td>
                  <td>'.$value["proyecto"].'</td>
                  <td>'.$value["etapa"].'</td>
                  <td>'.$value["terreno"].'</td>                  
                  <td>'.$value["precio_lista"].'</td>
                  <td>'.$value["area"].'</td>';                            
        $date = new DateTime($value["fecha"]);

        echo '<td>'.$date->format('d/m/Y H:i:s').'</td>
                  <td>

                    <div class="btn-group">
                      <button class="btn btn-warning btnDescargar" idDescarga="prospeccion.php?id='.$value["id"].'"><i class="fa fa-download"></i></button>  
                      <a href="index.php?ruta=cotizador&id='.$value["id"].'"><button class="btn btn-warning btnEditarUsuario"><i class="fa fa-credit-card"></i></button></a>';
        if($_SESSION["perfil"] == "Administrador")
        {
        echo              '<a href="index.php?ruta=prospeccion&id_e='.$value["id"].'"><button class="btn btn-warning btnEditarProspeccion"><i class="fa fa-pencil"></i></button></a>
          <button class="btn btn-danger btnEliminarProspeccion" idProspeccion="'.$value["id"].'"><i class="fa fa-times"></i></button>';
        }                                    
                      
        echo            '</div>  

                  </td>

                </tr>';

        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>
  
</div>
<?php
  $borrarProspeccion = new ControladorProspeccion();
  $borrarProspeccion -> ctrBorrarProspeccion();
?> 