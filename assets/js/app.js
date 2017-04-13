/**
 * Created by desarrollo on 21/12/2016.
 */

$(document).ready(function(){

/*
    vista procedencia/add
*/

    $("#activo").click(function() {
        if($("#activo").is(':checked')) {
            $("#content_motivo").css("display","none");
            $("#alquilado").removeAttr("disabled");
        } else {

            $("#content_motivo").css("display","block");
            $("#alquilado").attr("disabled", true);
            $("#alquilado").attr('checked', false);
            $("#content_alquiler").css("display","none");



        }
        $("#motivo").val('');
    });


    $("#alquilado").click(function() {
        if($("#alquilado").is(':checked')) {
            $("#content_alquiler").css("display","block");

        } else {
            $("#content_alquiler").css("display","none");
            $("#fecha_alquiler").val('');
            $("#nombre_inquilino").val('');
            $("#nombre_responsable").val('');
            $("#tlf_persona_contacto").val('');


        }
    });



/*    $('#tipo_servicio').on('click', function() {
        if ($('#tipo_servicio').val()==1){
            $("#content_aba_movil").css("display","block");
            $("#imei").val('');
            $("#modelo").val('');
            $("#fcc").val('');
        }
        else
        {
            $("#content_aba_movil").css("display","none");
        }

    });*/




    $('[data-rec]').on('change', function() {


        if($("#grupo").val()=='')
        {
            $("#subgrupo").html('<option value="">SELECCIONE</option>');
            return;

        }

        var path="subgrupo/get/";

        if(/editar/.test(window.location.pathname)){

            path="../../subgrupo/get/";
        }


        $.getJSON( path+$("#grupo").val() )
            .done(function( response, textStatus, jqXHR ) {

                if (response.success) {
                    $('#subgrupo').html("");
                    $.each(response.data, function(key, value) {

                        $('#subgrupo').append($('<option>', {
                            value: value['id'],
                            text : value['nombre']
                        }));

                    });
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    alert( "Algo ha fallado: " +  textStatus );
                }
            });


    })








/*logica reporte avanzado*/


    $('#bagrupo').on('change', function() {

        personal($("#bagrupo").val(),$("#basubgrupo").val());


        if($("#bagrupo").val()=='')
        {

        /*    $("#basubgrupo").select2({
                placeholder: "Todos"
            });*/

           // $("#basubgrupo").html('');

             $("#basubgrupo").html('<option value="">Todos</option>');
            $('#basubgrupo').val('').trigger('change');

             $.getJSON( "subgrupo/get" )
            .done(function( response, textStatus, jqXHR ) {

                if (response.success) {
                 //   $('#subgrupo').html("");
                    $.each(response.data, function(key, value) {

                        $('#basubgrupo').append($('<option>', {
                            value: value['id'],
                            text : value['nombre']
                        }));

                    });
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    alert( "Algo ha fallado: " +  textStatus );
                }
            });




            return;

        }




        var path="subgrupo/get/";

        if(/editar/.test(window.location.pathname)){

            path="../../subgrupo/get/";
        }


        $.getJSON( path+$("#bagrupo").val() )
            .done(function( response, textStatus, jqXHR ) {

                if (response.success) {
                     $("#basubgrupo").html('<option value="">Todos</option>');
                     $('#basubgrupo').val('').trigger('change');

 /*$("#basubgrupo").select2({
                placeholder: "Todos"
            });*/


                    $.each(response.data, function(key, value) {

                        $('#basubgrupo').append($('<option>', {
                            value: value['id'],
                            text : value['nombre']
                        }));

                    });
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    alert( "Algo ha fallado: " +  textStatus );
                }
            });


    })




    $('#basubgrupo').on('change', function() {
        personal($("#bagrupo").val(),$("#basubgrupo").val());
    })

});



function personal(idgrupo,idsubgrupo) {

var grupo= idgrupo;
var subgrupo= idsubgrupo;

if(idgrupo==""){
    grupo='0';
}

if(idsubgrupo==""){
    subgrupo='0';
}

/*var grupo= "1";
var subgrupo= "1";*/

             $.getJSON( "personal/get/"+grupo+"/"+subgrupo )
            .done(function( response, textStatus, jqXHR ) {

                if (response.success) {
                     $("#personal").html('<option value="">Todos</option>');
                    // $("#basubgrupo").html('<option value="">Todos</option>');
                     $('#personal').val('').trigger('change');

            

        
                    $.each(response.data, function(key, value) {

                        $('#personal').append($('<option>', {
                            value: value['Userid'],
                            text : value['Name']
                        }));

                    });
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    alert( "Algo ha fallado: " +  textStatus );
                }
            });


}


if (this.checked) {
    $("input.group1").removeAttr("disabled");
} else {
    $("input.group1").attr("disabled", true);
}



if($('.clockpicker').length>0){

    $('.clockpicker').clockpicker();
}


if($('#data_1 .input-group.date').length>0){


    $('#data_1 .input-group.date').datepicker({
        format: "dd-mm-yyyy",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        language: 'es'
    });
}




/*fin datepicker*/

        $("#lactancia").click(function() {
        if($("#lactancia").is(':checked')) {
            $(".content_turno").css("display","block");

        } else {
            $(".content_turno").css("display","none");


        }
    });