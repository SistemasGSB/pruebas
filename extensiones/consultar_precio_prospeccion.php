<?php
require_once "../modelos/conexion.php";
$proyecto = $_POST['proyecto'];
$etapa = $_POST['etapa'];
$terreno = $_POST['lotes'];
$stmt = Conexion::conectar()->prepare("SELECT * FROM proyectos WHERE proyecto = '$proyecto' AND etapa ='$etapa' AND terreno ='$terreno' ");
$stmt -> execute();

while ( $row = $stmt->fetch() )
{
  echo '<h3 for="codigo" class="control-label" style="text-align: center;"><b>PRECIO COTIZACION</b></h3><br>
        <input type="hidden" id="id_proyecto" name="id_proyecto" value="'.$row['id_proyecto'].'">
          <table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:13px">
            <tr>
              <td width="180px" style="border: 1px solid #666; background-color:#333; color:#fff">Etapa de Proyecto</td>
              <td width="380px" style="border: 1px solid #666; background-color:#333; color:#fff">Lote</td>
              <td width="380px" style="border: 1px solid #666; background-color:#333; color:#fff">Área</td>
              <td width="160px" style="border: 1px solid #666; background-color:#333; color:#fff">Precio ($)</td>
          </table>
          <table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:13px">
            <tr>
              <td width="180px"style="border: 1px solid #666">' . $row['etapa']. '</td>
              <td width="380px" style="border: 1px solid #666">' . $row['terreno']. '</td>
              <td width="380px" style="border: 1px solid #666">' . $row['area']. '</td>
              <td width="160px" style="border: 1px solid #666"> ' . $row['precio_lista']. '</td>
            </tr>
          </table>';
}
$stmt = null;