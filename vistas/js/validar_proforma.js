$('#form_proforma').validate({ // initialize the plugin
    rules: {
        tipo_cambio:{
            required:true,
            maxlength:5,
            number:true,
            format:"[0-9]+\.[0-9]+",
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