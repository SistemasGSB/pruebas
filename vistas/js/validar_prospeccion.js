jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es OBLIGATORIO",
    remote: "Please fix this field.",
    email: "Ingrese un email valido",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Solo se permiten NUMEROS",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("No mas de {0} numeros."),
    minlength: jQuery.validator.format("No menos de {0} numeros."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Solo valores entre {0} y {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});
//Validador de expresiones regulares
jQuery.validator.addMethod("accept", function(value, element, param) {
  return value.match(new RegExp(param + "$"));
}, "Inicial con Mayuscula y Solo Letras");
    $('#form_prospeccion').validate({ // initialize the plugin
        rules: {

            nombre_cliente: {
                required: true,
                accept: "^[A-Z][a-zA-Z ]+",
            },
            nombre_conyuge: {
                accept: "^[A-Z][a-zA-Z ]+",
                
            },
            apellido_cliente: {
                accept: "^[A-Z][a-zA-Z ]+",
                required: true,
            },
            apellido_conyuge: {
                accept: "^[A-Z][a-zA-Z ]+",
                
            },
            dni_cliente:{
                required: true,
                number: true,
                minlength: 8,
                maxlength: 8,
            },
            dni_conyuge:{
                number: true,
                minlength: 8,
                maxlength: 8,
            },
            celular_cliente:{
                required: true,
                number: true,
                minlength: 9,
                maxlength: 9,
            },
            email_cliente:{
                required:true,
                email: true,
            },
            direccion_cliente:{
                required: true,
                accept: "^[A-Z][a-zA-Z0-9 _.-]+",
            },
            distrito_cliente:{
                required: true,
                accept: "^[A-Z][a-zA-Z0-9 _.-]+",
            },
            tipo_cambio:{
                required: true,
                number: true,
            },
            carnet_cliente:{
                number: true,
                minlength: 9,
                maxlength: 9,  
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