<?php
require_once "../modelos/conexion.php";

require_once "../controladores/prospeccion.controlador.php";
require_once "../modelos/prospeccion.modelo.php";

$proyecto = $_POST['proyecto'];
$etapa = $_POST['etapa'];

  
if (isset($_POST['id_e'])) {
$datos = ControladorProspeccion::ctrEditPros($_POST['id_e']);
}


$stmt = Conexion::conectar()->prepare("SELECT * FROM proyectos WHERE proyecto = '$proyecto' AND etapa ='$etapa' AND estado= '0' ");
$stmt -> execute();
echo '<option value="0">Seleccione</option>';
while ( $row = $stmt->fetch() )
{
	if(isset($_POST['id_e'])){
    	if($datos[0]['lotes_proyecto']==$row['terreno'] ){
    		echo '<option value="' . $row['terreno']. '" selected="selected">' . $row['terreno'] . '</option>' . "\n";
    	}
    	else{
    		echo '<option value="' . $row['terreno']. '">' . $row['terreno'] . '</option>' . "\n";		
    	}
    }
    else{
    	echo '<option value="' . $row['terreno']. '">' . $row['terreno'] . '</option>' . "\n";	
    }
	
}
$stmt = null;