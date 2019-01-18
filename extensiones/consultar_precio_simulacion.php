<?php

$sim_cot_pfd = $_POST['sim_cot_pfd'];
$sim_cot_mfd = $_POST['sim_cot_mfd'];
$sim_periocidad = $_POST['sim_periocidad'];
$sim_cot_tcea = $_POST['sim_cot_tcea'];
$precio_interes = 0;
$sim_per_gracia = $_POST['sim_per_gracia'];
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

echo '<div class="form-group col-sm-12">
        <table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:13px">
            <tr>
              <td width="180px"style="border: 1px solid #666">Plazo</td>
              <td width="380px" style="border: 1px solid #666">Interes</td>
              <td width="380px" style="border: 1px solid #666">Amortizacion</td>
              <td width="160px" style="border: 1px solid #666">Cuota</td>
              <td width="160px" style="border: 1px solid #666">Saldo Capital</td>
            </tr>';
      for($i=0;$i<=$sim_cot_pfd;$i++)
        {            
            if ($i<=$sim_per_gracia) 
            {
              if ($i == 0)
              {
                echo '<tr>
                <td width="180px"style="border: 1px solid #666">0</td>
                <td width="380px" style="border: 1px solid #666">--</td>
                <td width="380px" style="border: 1px solid #666">--</td>
                <td width="160px" style="border: 1px solid #666">--</td>
                <td width="160px" style="border: 1px solid #666">'.$sim_cot_mfd.'</td>
                    </tr>';
              }
              else
              {
              $interes = $sim_cot_mfd * $calculo_tasa;
              $precio_interes = $precio_interes + $interes;
              echo '<tr>
                <td width="180px"style="border: 1px solid #666">'.$i.'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="380px" style="border: 1px solid #666">--</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.$sim_cot_mfd.'</td>
                    </tr>';
              }
            }
            else
            {              
              $saldo_capital = payment($calculo_tasa,$sim_cot_pfd,$sim_cot_mfd,$fv=0.0,$prec=2);
              $interes = $sim_cot_mfd * $calculo_tasa;
              $amortizacion = $saldo_estable - $interes;
              $sim_cot_mfd = $sim_cot_mfd - $amortizacion;
              $precio_interes = $precio_interes + $interes;
              if($i == $sim_cot_pfd)
              {
                echo '<tr>
                <td width="180px"style="border: 1px solid #666">'.$i.'</td>
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
                <td width="380px" style="border: 1px solid #666">'.number_format($interes,2).'</td>
                <td width="380px" style="border: 1px solid #666">'.number_format($amortizacion,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($saldo_estable,2).'</td>
                <td width="160px" style="border: 1px solid #666">'.number_format($sim_cot_mfd,2).'</td>
                    </tr>';
              }
            }            
        }
    echo '<tr>
              <td width="180px" style="border: 1px solid #666; background-color:#00B050"></td>
              <td width="380px" style="border: 1px solid #666; background-color:#00B050">'.number_format($precio_interes,2).'</td>
              <td width="380px" style="border: 1px solid #666; background-color:#00B050"></td>
              <td width="160px" style="border: 1px solid #666; background-color:#00B050"></td>
              <td width="160px" style="border: 1px solid #666; background-color:#00B050"></td>
            </tr></table>
            <div class="form-group col-sm-12">
              <div class="input-group">              
                <input style="display:none;" type="text" class="form-control" id="sim_total_interes" readonly name="sim_total_interes" value="'.number_format($precio_interes,2).'" required>
              </div>
            </div>
      </div>';
