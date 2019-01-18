<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Reporte Cotizaciones
            
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Reporte Cotizaciones</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive <?php if($_SESSION["perfil"] == "Administrador")
                  {
                    echo 'tablas_rep-cotizacion_adm';
                  }
                  if($_SESSION["perfil"] != "Administrador")
                  {
                    echo 'tablas_rep-cotizacion';
                  }
            ?>" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>DNI</th>
           <th>Nombres</th>
           <th style="width:10px">Terreno</th>
           <th>Area</th>
           <th>N Cuot</th>
           <th>Cuot Sep</th>
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

        $usuarios = ControladorCotizador::ctrMostrarCotizadorTabla($item, $valor);

       foreach ($usuarios as $key => $value){
         
          echo ' <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["dni"].'</td>
                  <td>'.$value["nombre"].' '.$value["apellido"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["proyecto"].' - '.$value["etapa"].' - '.$value["precio_lista"].' "><i class="fa fa-info-circle"></i></a>'.$value["terreno"].'</td>                  
                  <td>'.$value["area"].'</td>                  
                  <td>'.$value["cot_pfd"].'</td>
                  <td>'.$value["cot_sep_usd"].'</td>';                            
        $date = new DateTime($value["fecha_creacion"]);
        echo '<td>'.$date->format('d/m/Y H:i:s').'</td>
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnDescargar" idDescarga="cotizador.php?&id='.$value["id"].'"><i class="fa fa-download"></i></button>
                      <a href="index.php?ruta=reserva&id='.$value["id"].'"><button class="btn btn-warning btnEditarUsuario"><i class="fa fa-credit-card"></i></button></a>';
        if($_SESSION["perfil"] == "Administrador")
        {
        echo              '<button class="btn btn-danger btnEliminarCotizacion" idCotizacion="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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

  $borrarCotizador = new ControladorCotizador();
  $borrarCotizador -> ctrBorrarCotizacion();

?> 