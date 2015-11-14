function validarTag(tag) {
    if (tag.length > 50)
        return false;
    return true;
}

function precargarDatos() {

    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
        //alert(data);
        var respuesta = parseInt(data);
        if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
            var datosEnc = JSON.parse(data);

            $("#txtTitulo").val(datosEnc.Titulo);
            $("#txtDescripcion").val(datosEnc.Descripcion);
            $("#txtFechaLimite").val(datosEnc.FechaLimite);
            $("#txtHoraLimite").val(datosEnc.HoraLimite);
            $("#txtProposito").val(datosEnc.Proposito);
            $("#txtPoblacion").val(datosEnc.Poblacion);
            $("#txtCarMu").val(datosEnc.CaractecisticasMuestra);
            $("#txtMaxAcc").val(datosEnc.CantMaxAccesos);

            if (datosEnc.TieneClave != "" && datosEnc.TieneClave != "0")
            {
                $('#ckTieneClave').attr('checked', true);
                $("#txtClaveAcc").html(datosEnc.ClaveAcceso);
            } else {
                $('#ckTieneClave').attr('checked', false);
            }
            if (datosEnc.MostrarResultados != "" && datosEnc.MostrarResultados != "0")
            {
                $('#ckMostrarResult').attr('checked', true);

            } else {
                $('#ckMostrarResult').attr('checked', false);
            }

            if (datosEnc.BloquearIP != "" && datosEnc.BloquearIP != "0")
            {
                $('#ckBloquearIP').attr('checked', true);
            } else {
                $('#ckBloquearIP').attr('checked', false);
            }

            $.post("Negocios/temas.php", {vdefaul: '...', selected: datosEnc.idTema, oper: 'combo'}, function (data) {
                $("#cbTema").html(data);
            });


            $.post("Negocios/tiposEncuestas.php", {vdefaul: '...', selected: datosEnc.idTipoEncuesta, oper: 'combo'}, function (data) {
                $("#cbTipoEnc").html(data);
            });
            
            $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'tagsEnc'}, function (data) {
              
                $('#txtTags').tagsinput('add', data);
            });
            
            if(datosEnc.idEstado >= 2)
            {
                $("#cbTema").attr('disabled', 'disabled');
                $("#cbTipoEnc").attr('disabled', 'disabled');
                $("#txtTitulo").attr('readonly', 'readonly');
                
                if(datosEnc.idEstado == 3)
                {
                    $("#btnGuardar").hide();
                    
                }
            }
        }

    });
}


$(document).ready(function () {

    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#txtFechaLimite').datepicker({changeMonth: true, changeYear: true});
    $("#txtHoraLimite").mask("99:99");
    $('#txtFechaLimite').mask("99/99/9999");

    if ($("#hfIdEncuesta").val() != "") {
        precargarDatos();
    }

    $('#txtTags').on('beforeItemAdd', function (event) {
        // event.item: contains the item
        if (!validarTag(event.item))
        {
            alert("No debe superar los 50 caracteres");
            event.cancel = true;
        }

    });


    $("#formConfigEnc").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
                rules: {
                    cbTema: "required",
                    cbTipoEnc: "required",
                    txtTitulo: "required"

                },
        messages: {
            cbTema: "Ingrese Tema",
            cbTipoEnc: "Ingrese Tipo",
            txtTitulo: "Ingrese T&iacute;tulo"
        },
        submitHandler: function (form) {
            $("#cbTema").removeAttr('disabled');
            $("#cbTipoEnc").removeAttr('disabled');
            $.ajax({
                url: "Negocios/encuestas.php",
                type: "POST",
                data: $(form).serialize(),
                beforeSend: function () {
                    $("#respuestaNueva").html("Cargando ... ");
                },
                success: function (response) {
                    $("#respuestaNueva").html("");
                    $("#cbTema").attr('disabled', 'disabled');
                    $("#cbTipoEnc").attr('disabled', 'disabled');
                    $("#respuestaNueva").html(response);

                },
                error: function (xhr, status, error) {
                    var error = formatErrorMessage(xhr, error);
                    $("#respuestaNueva").html(error);
                }
            });

        }

    });


});