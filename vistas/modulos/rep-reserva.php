<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Reporte Reservas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Reporte Reservas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

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
           <th style="width:10px">Area</th>
           <th style="width:10px">Separacion</th>
           <th>Fecha Dep.</th>
           <th>Operacion</th>
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
          $orden = "id_cliente";
          }
        else
          {
          $item = "asesor";
          $valor = $_SESSION["usuario"];
          $orden = "id_cliente";
          }

        $usuarios = ControladorReserva::ctrMostrarReservaTabla($item, $valor);

       foreach ($usuarios as $key => $value){
        if($value["oculto"] == 0)
        {
         
          echo ' <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["dni"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["asesor"].' "><i class="fa fa-info-circle"></i></a>'.$value["nombre"].' '.$value["apellido"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["proyecto"].' - '.$value["etapa"].' - '.$value["precio_lista"].' "><i class="fa fa-info-circle"></i></a>'.$value["terreno"].'</td>
                  <td>'.$value["area"].'</td>
                  <td>'.$value["res_sep"].'</td>                  
                  <td>'.$value["fecha_deposito"].'</td>
                  <td>'.$value["res_operacion"].'</td>';                            
        $date = new DateTime($value["fecha_creacion"]);
        echo '<td>'.$date->format('d/m/Y H:i:s').'</td>
                  <td>

                    <div class="btn-group">                       
                     
                      <button class="btn btn-warning btnDescargar" idDescarga="reserva.php?&id='.$value["id"].'"><i class="fa fa-download"></i></button>
                      <a href="index.php?ruta=simulador&id='.$value["id"].'"><button class="btn btn-warning btnEditarUsuario"><i class="fa fa-credit-card"></i></button></a>';
        if($_SESSION["perfil"] == "Administrador")
        {
        echo              '<button class="btn btn-danger btnEliminarReserva" idReserva="'.$value["id"].'"><i class="fa fa-times"></i></button>';
        }                                    
                      
        echo            '</div>  

                  </td>

                </tr>';
        }

        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<?php

  $borrarReserva = new ControladorReserva();
  $borrarReserva -> ctrBorrarReserva();

?> 