<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Reporte Proformas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Reporte Proformas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive <?php if($_SESSION["perfil"] == "Administrador")
                  {
                    echo 'tablas_rep-proforma_adm';
                  }
                  if($_SESSION["perfil"] != "Administrador")
                  {
                    echo 'tablas_rep-proforma';
                  }
            ?>" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>DNI</th>
           <th>Nombres</th>
           <th>Proyecto</th>
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

        $usuarios = ControladorProforma::ctrMostrarProformaTabla($item, $valor);

       foreach ($usuarios as $key => $value){

        if($value["oculto"] == 0)
        {
         
          echo ' <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["dni"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["asesor"].' "><i class="fa fa-info-circle"></i></a>'.$value["nombre"].' '.$value["apellido"].'</td>
                  <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$value["proyecto"].' - '.$value["etapa"].' - '.$value["precio_lista"].' "><i class="fa fa-info-circle"></i></a>'.$value["terreno"].'</td>';                            
        $date = new DateTime($value["fecha_creacion"]);
        echo '<td>'.$date->format('d/m/Y H:i:s').'</td>
                  <td>

                    <div class="btn-group">
                        
                     <button class="btn btn-warning btnDescargar" idDescarga="proforma.php?&id='.$value["id"].'"><i class="fa fa-download"></i></button>
                     <button class="btn btn-warning btnDescargar" idDescarga="contrato.php?&id='.$value["id"].'"><i class="fa fa-file-word-o"></i></button>';
        if($_SESSION["perfil"] == "Administrador")
        {
        echo              '<button class="btn btn-danger btnEliminarProforma" idProforma="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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

  $borrarProforma = new ControladorProforma();
  $borrarProforma -> ctrBorrarProforma();

?> 