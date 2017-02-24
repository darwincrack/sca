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




    $('[data-rec]').on('click', function() {

        var path="show-procedencia/";

        if(/editar/.test(window.location.pathname)){

            path="../show-procedencia/";
        }


        $.getJSON( path+$("#ciudades").val()+"/"+$("#tipo_procedencia").val() )
            .done(function( response, textStatus, jqXHR ) {

                if (response.success) {
                    $('#procedencia').html("");
                    $.each(response.data, function(key, value) {

                        $('#procedencia').append($('<option>', {
                            value: value['id_procedencia'],
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



});




if (this.checked) {
    $("input.group1").removeAttr("disabled");
} else {
    $("input.group1").attr("disabled", true);
}






$('#data_1 .input-group.date').datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    language: 'es'
});
/*fin datepicker*/