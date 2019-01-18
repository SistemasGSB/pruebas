$('#form_simulador').validate({ // initialize the plugin
    rules: {
        tipo_cambio:{
            required:true,
            maxlength:5,
            number:true,
            format:"[0-9]+\.[0-9]+",
        },
        sim_periocidad:{
            required:true,
            number:true,
            range:[0,6],
        },
        sim_cot_tcea:{
            required:true,
            number:true,
            range:[0,15],
        },
        sim_per_gracia:{
            required:true,
            number:true,
            range:[0,15],
        },
        sim_cot_tasa: "required",
    },
    messages: {
        sim_cot_tasa: {
            required: "Genera la Tasa antes de Continuar",
            
        }
    },
    showErrors: function(errorMap, errorList) {
        $.each(this.successList, function(index, value) {
          return $(value).popover("hide");
        });
        return $.each(errorList, function(index, value) {
          var _popover;
          _popover = $(value.element).popover({
            trigger: "manual",
            placement: "top",
            content: value.message,
            template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\" id=\"validacion\"><p></p></div></div></div>"
          });
          // Bootstrap 3.x :      
          _popover.data("bs.popover").options.content = value.message;
          // Bootstrap 2.x :
          //_popover.data("popover").options.content = value.message;
          return $(value.element).popover("show");
        });
    },
    //messages: {},
    //errorElement : 'div',
    //errorLabelContainer: '.errorTxt'
});