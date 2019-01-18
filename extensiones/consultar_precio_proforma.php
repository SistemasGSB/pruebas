<?php
$cot_sci_usd = $_POST['cot_sci_usd'];
$proforma_pc = $_POST['proforma_pc'];
$fecha_uno = $_POST['fecha_uno'];
$fecha_dos = $_POST['fecha_dos'];
$fecha_tres = $_POST['fecha_tres'];
$amortizacion_uno = $_POST['amortizacion_uno'];
$amortizacion_dos = $_POST['amortizacion_dos'];

$saldo_contable_uno = $proforma_pc - $amortizacion_uno;
$saldo_contable_dos = $saldo_contable_uno - $amortizacion_dos;
$saldo_contable_tres = $saldo_contable_dos- $cot_sci_usd;
/**GENERAMOS UN COTIZADOR*/
$sim_cot_pfd=$_POST['sim_cot_pfd'];
$sim_cot_mfd=$_POST['sim_cot_mfd'];
$sim_periocidad=$_POST['sim_periocidad'];
$sim_cot_tcea=$_POST['sim_cot_tcea'];
$precio_interes = 0;
$amortizacion_final = $amortizacion_uno+$amortizacion_dos+$cot_sci_usd;
$cuota_final = $amortizacion_uno+$amortizacion_dos+$cot_sci_usd;
$sim_per_gracia=$_POST['sim_per_gracia'];
$calculo_tasa = pow((1+($sim_cot_tcea/100)),($sim_periocidad/12))-1;
$saldo_estable = payment($calculo_tasa,($sim_cot_pfd-$sim_per_gracia),$sim_cot_mfd,$fv=0.0,$prec=2);
function payment($apr,$n,$pv,$fv=0.0,$prec=2){
    
    if ($apr !=0) {
        $alpha = 1/(1+$apr);
        $retval =  round($pv * (1 - $alpha) / $alpha / (1 - pow($alpha,$n)),$prec) ;
    } else {
        $retval = round($pv / $n, $prec);
    }
    return($retval);

}

//**SUMA DE 3 MESES **/
$conversor = str_replace('/','-',$fecha_dos);
$fecha = date("d/m/Y", strtotime(" +1 month " , strtotime($conversor)));

$inicio_d = str_replace('/','-',$fecha_tres);
$fecha_d = date("Y-m-d", strtotime(" -1 month " , strtotime($inicio_d)));

echo '<input type="hidden" id="aviso" name="aviso" value="algo">
<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:13px">
            <tr>
              <td width="180px"style="border: 1px solid #666">Plazo</td>
              <td width="380px" style="border: 1px solid #666">Fecha Vto</td>
              <td width="300px" style="border: 1px solid #666">Interes</td>
              <td width="240px" style="border: 1px solid #666">Amortizacion</td>
              <td width="240px" style="border: 1px solid #666">Cuota</td>
              <td width="160px" style="border: 1px solid #666">Saldo Capital</td>
            </tr>';
echo '      <tr>
              <td width="180px"style="border: 1px solid #666">Inicial</td>
              <td width="380px" style="border: 1px solid #666">'.$fecha_uno.'</td>
              <td width="300px" style="border: 1px solid #666"></td>
              <td width="240px" style="border: 1px solid #666">'.$amortizacion_uno.'</td>
              <td width="240px" style="border: 1px solid #666">'.$amortizacion_uno.'</td>
              <td width="160px" style="border: 1px solid #666">'.$saldo_contable_uno.'</td>
            </tr>';
echo '      <tr>
              <td width="180px"style="border: 1px solid #666">Inicial</td>
              <td width="380px" style="border: 1px solid #666">'.$fecha_dos.'</td>
              <td width="300px" style="border: 1px solid #666"></td>
              <td width="240px" style="border: 1px solid #666">'.$amortizacion_dos.'</td>
              <td width="240px" style="border: 1px solid #666">'.$amortizacion_dos.'</td>
              <td width="160px" style="border: 1px solid #666">'.$saldo_contable_dos.'</td>
            </tr>';
echo '      <tr>
              <td width="180px"style="border: 1px solid #666">Inicial</td>
              <td width="380px" style="border: 1px solid #666">'.$fecha.'</td>
              <td width="300px" style="border: 1px solid #666"></td>
              <td width="240px" style="border: 1px solid #666">'.$cot_sci_usd.'</td>
              <td width="240px" style="border: 1px solid #666">'.$cot_sci_usd.'</td>
              <td width="160px" style="border: 1px solid #666">'.$saldo_contable_tres.'</td>
            </tr>';
for($i=1;$i<=$sim_cot_pfd;$i++)
        { 
            $nuevafecha2 = date("d/m/Y", strtotime(" +1 month " , strtotime($fecha_d)));
            $fecha_d = str_replace('/','-',$nuevafecha2);
            if ($i<=$sim_per_gracia) 
            {
              $interes = $sim_cot_mfd * $calculo_tasa;
              $precio_interes = $precio_interes + $interes;
              $cuota_final = $cuota_final + $interes; 
              echo '<tr>
                <td width="180px"style="border: 1px solid #666">'.$i.'</td>
                <td width="380px" style="border: 1px solid #666">'.$nuevafecha2.'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="380px" style="border: 1px solid #666">--</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.$sim_cot_mfd.'</td>
                    </tr>';
            }
            else
            {              
              $saldo_capital = payment($calculo_tasa,$sim_cot_pfd,$sim_cot_mfd,$fv=0.0,$prec=2);
              $interes = $sim_cot_mfd * $calculo_tasa;
              $amortizacion = $saldo_estable - $interes;
              $sim_cot_mfd = $sim_cot_mfd - $amortizacion;
              $precio_interes = $precio_interes + $interes;
              $amortizacion_final = $amortizacion_final + $amortizacion;
              $cuota_final = $cuota_final + $saldo_estable;
              if($i == $sim_cot_pfd)
              {
                echo '<tr>
                <td width="180px"style="border: 1px solid #666">'.$i.'</td>
                <td width="380px" style="border: 1px solid #666">'.$nuevafecha2.'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($amortizacion,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($saldo_estable,2).'</td>
                <td width="160px" style="border: 1px solid #666">0.00</td>
                    </tr>';
              }
              else
              {
              echo '<tr>
                <td width="180px"style="border: 1px solid #666">'.$i.'</td>
                <td width="380px" style="border: 1px solid #666">'.$nuevafecha2.'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($amortizacion,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($saldo_estable,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($sim_cot_mfd,2).'</td>
                    </tr>';
              }
            }            
        }
echo '<tr>
              <td width="180px" style="border: 1px solid #666; background-color:#00B050">TOTAL</td>
              <td width="380px" style="border: 1px solid #666; background-color:#00B050"></td>
              <td id="sum_i" width="380px" style="border: 1px solid #666; background-color:#00B050">'.number_format($precio_interes,2).'</td>
              <td width="160px" style="border: 1px solid #666; background-color:#00B050">'.number_format($amortizacion_final,2).'</td>
              <td width="160px" style="border: 1px solid #666; background-color:#00B050">'.number_format($cuota_final,2).'</td>
              <td width="160px" style="border: 1px solid #666; background-color:#00B050"></td>
            </tr></table>';


