jQuery.validator.addMethod("format", function(value, element, param) {
  return value.match(new RegExp(param + "$"));
}, "Cumpla con el formato Ejem: 3.30");
$('#form_cotizador').validate({ // initialize the plugin
    rules: {
        tipo_cambio:{
            required:true,
            maxlength:5,
            number:true,
            format:"[0-9]+\.[0-9]+",
        },
        cot_tci: {
            required: true,
            range: [16,100],
        },
        cot_sep_usd:{
            required:true,
            range:[0,20],
        },
        cot_cis_usd:{
            required: true,
            range:[100,9999],
        },
        cot_pfd:{
            required: true,
            range:[6,48],
        },
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