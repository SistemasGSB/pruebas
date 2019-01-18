<?php

$item = null;
$valor = null;
$orden="id_cliente";

$proyectos = ControladorProyectos::ctrMostrarProyectos($item, $valor);
$totalproyectos= count($proyectos);
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
$clientes = ControladorClientes::ctrMostrarClientes($item, $valor ,$orden);
$totalClientes = count($clientes);

$prospeccion = ControladorProspeccion::ctrMostrarProspeccion($item, $valor);
$totalProspeccion = count($prospeccion);
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
$reserva = ControladorReserva::ctrMostrarReservaTabla($item, $valor);
$cotizacion = ControladorCotizador::ctrMostrarCotizadorTabla($item, $valor);
?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Tablero
      
      <small>Panel de Control</small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Tablero</li>
    
    </ol>

  </section>
  <!-- CONTENIDO INICIO -->
  <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Proyectos</span>
              <span class="info-box-number">3</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Lotes</span>
              <span class="info-box-number"><?php echo number_format($totalproyectos); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Clientes</span>
              <span class="info-box-number"><?php echo number_format($totalClientes); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Prospecciones</span>
              <span class="info-box-number"><?php echo number_format($totalProspeccion); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ultimas Reservas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Proyecto</th>
                    <th>Fecha</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if(sizeof($reserva) < 2)
                  {
                    echo '<tr>
                    <td>-</td>
                    <td>SIN DATOS</td>
                    <td><span class="label label-success">SIN DATOS (Min 2 reservas)</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">SIN DATOS</div>
                    </td>
                  </tr>';
                  }
                  else
                  {
                  for($i = 0; $i < 2; $i++){
                  echo '<tr>
                    <td>'.$reserva[$i]["id"].'</td>
                    <td><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$reserva[$i]["asesor"].'"><i class="fa fa-info-circle"></i></a>'.$reserva[$i]["nombre"].' '.$reserva[$i]["apellido"].'</td>
                    <td><span class="label label-success">'.$reserva[$i]["proyecto"].' '.$reserva[$i]["terreno"].'</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">'.$reserva[$i]["fecha_creacion"].'</div>
                    </td>
                  </tr>';
                  }                  
                  }
                  ?>                            
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="rep-reserva" class="btn btn-sm btn-default btn-flat pull-right">Ver todas</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ultimas Cotizaciones</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php
                if(sizeof($cotizacion) < 2)
                  {
                    echo '<tr>
                    <td>-</td>
                    <td>SIN DATOS</td>
                    <td><span class="label label-success">SIN DATOS (Min 2 cotizaciones)</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">SIN DATOS</div>
                    </td>
                  </tr>';
                  }
                else
                {
                  for($i = 0; $i < 2; $i++){
                echo '<li class="item">
                  <div class="product-img">
                    <img src="vistas/dist/img/default-50x50.gif" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><a class="top" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="'.$cotizacion[$i]["asesor"].'"><i class="fa fa-info-circle"></i></a>'.$cotizacion[$i]["nombre"].' '.$cotizacion[$i]["apellido"].'
                      <span class="label label-warning pull-right"> '.$cotizacion[$i]["cot_sep_usd"].'</span></a>
                    <span class="product-description">
                          '.$cotizacion[$i]["proyecto"].' '.$cotizacion[$i]["terreno"].' - '.$cotizacion[$i]["fecha_creacion"].'
                        </span>
                  </div>
                </li>';
                }
                }
                ?>
                
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="rep-cotizador" class="uppercase">Ver todas las cotizaciones</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ventas</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                 <canvas id="areaChart" style="height:250px"></canvas>
              </div>    
            </div>
      </div>
      
      <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->