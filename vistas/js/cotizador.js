var precio_venta_general=$('#cot_pv').val();
  $('#cot_sep_usd').change(function() {
      var numero=document.getElementById('cot_sep_usd').value;
      var calculo = (numero/precio_venta_general)*100;
      calculo = calculo.toFixed(2);
      $("#cot_sep").val(calculo);
  });
  $('#cot_cis_usd').change(function() {
      var numero=document.getElementById('cot_cis_usd').value;
      var calculo = (numero/precio_venta_general)*100;
      calculo = calculo.toFixed(2);
      $("#cot_cis").val(calculo);
  });
  $('#cot_tci').change(function() {
      var numero=document.getElementById('cot_tci').value;
      var calculo = precio_venta_general*(numero/100);
      calculo = calculo.toFixed(2);
      $("#cot_tci_usd").val(calculo);
      var numero1=document.getElementById('cot_tci_usd').value;
      var numero2=document.getElementById('cot_cis_usd').value;
      var numero3=document.getElementById('cot_sep_usd').value;
      if(($("#cot_tci_usd").val().length > 1 && $("#cot_cis_usd").val().length > 1  && $("#cot_sep_usd").val().length > 1 ))
      {
      var calculo_resta = numero1-numero2-numero3;
      calculo_resta = calculo_resta.toFixed(2);
      $("#cot_sci_usd").val(calculo_resta);
      //**Saldo de Cuota Inicial **//
      var numero4=document.getElementById('cot_sci_usd').value;
      var calculo_sci = (numero4/precio_venta_general)*100;
      calculo_sci = calculo_sci.toFixed(2);
      $("#cot_sci").val(calculo_sci);
      //**Monto Financiamiento Directo**//
      var numero5=document.getElementById('cot_tci_usd').value;
      var calculo_mfd = precio_venta_general-numero5;
      calculo_mfd = calculo_mfd.toFixed(2);
      $("#cot_mfd").val(calculo_mfd);
      }
      else
      {
        swal({
              title: "Error!",
              text: "Campos Vacios!",
              icon: "warning",
              button: "Aceptar!",
              });
      }
  });
  $('#cot_pfd').change(function() {
      var valor=document.getElementById('cot_pfd').value;      
      $("#cot_cuota").val(valor);
      var valor1=document.getElementById('cot_mfd').value;
      var valor2=document.getElementById('cot_cuota').value;
      var calculo_aprox = valor1/valor2;
      calculo_aprox = calculo_aprox.toFixed(2);
       $("#cot_cuotam").val(calculo_aprox);      
  });