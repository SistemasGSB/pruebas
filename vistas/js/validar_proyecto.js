jQuery.validator.addMethod("acceptp", function(value, element, param) {
  return value.match(new RegExp(param + "$"));
}, "Respete el Formato ejem: A-10");
 
$('#form_proyecto').validate({ // initialize the plugin
    rules: {
        editarTerreno:{
            required:true,
            acceptp: "^[A-Z]\-[0-9]+",
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

$('#form_proyecto_c').validate({ // initialize the plugin
    rules: {
        terrenoProyecto:{
            required:true,
            acceptp: "^[A-Z]\-[0-9]+",
        },
        nuevo_pro:{
            accept: "^[A-Z][a-zA-Z ]+",
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