function validarEmail(email) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(email))
        return false;
    return true;
}

$(document).ready(function () {

    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#txtFcIni').datepicker({changeMonth: true,changeYear: true});
    $('#txtFcFin').datepicker({changeMonth: true,changeYear: true});
    $('#txtFcFin').mask("99/99/9999");
    $('#txtFcIni').mask("99/99/9999")

    $('#txtDestinos').on('beforeItemAdd', function (event) {
        // event.item: contains the item
        if (!validarEmail(event.item))
        {
            alert("La direccion ingresada es invalida");
            event.cancel = true;
        }

    });

    $("#ckRecWeb").change(function () {
        if (this.checked) {
            $("#pnlRecWeb").show();
        } else {
            $("#pnlRecWeb").hide();
        }
    });

    $("#ckRecEmail").change(function () {
        if (this.checked) {
            $("#pnlRecEmail").show();
        } else {
            $("#pnlRecEmail").hide();
        }
    });
    
    $("#ckIdentificacion").change(function () {
        if (this.checked) {
            $("#pnlIdsParticipantes").show();
        } else {
            $("#pnlIdsParticipantes").hide();
        }
    });

    //alert($("#hfIdEncuesta").val());
    if ($("#hfIdEncuesta").val() != "")
    {
        $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
            //alert(data);
            var respuesta = parseInt(data);
            if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
                var datosEnc = JSON.parse(data);

                $("#txtTitulo").html(datosEnc.Titulo);
                $("#spTitulo").html(datosEnc.Titulo);
                $("#hfTitulo").val(datosEnc.Titulo);
                $("#tipoEncuesta").val(datosEnc.idTipoEncuesta);
                $("#txtTema").html("<b>Tema:</b> " + datosEnc.Tema);
                $("#txtTipo").html("<b>Tipo:</b> " + datosEnc.Tipo);
                $("#txtDescripcion").html(datosEnc.Descripcion);
                $("#txtProposito").html("<b>Prop&oacute;sito: </b> " + datosEnc.Proposito);
                $("#txtPoblacion").html("<b>Poblaci&oacute;n:</b> " + datosEnc.Poblacion);
                $("#txtCarMu").html("<b>Caracteristicas de la Muestra:</b> " + datosEnc.CaractecisticasMuestra);

                if ((datosEnc.FechaLimite != "") && (datosEnc.FechaLimite != null)) {
                    $("#txtFechaLimite").html("<b>Fecha L&iacute;mite: </b>" + datosEnc.FechaLimite);
                    $("#txtFechaLimite").val(datosEnc.FechaLimite);
                } else {
                    $("#txtFechaLimite").html("<b>Fecha L&iacute;mite: </b> Sin definir");
                }

                if ((datosEnc.HoraLimite != "") && (datosEnc.HoraLimite != null)) {
                    $("#txtHoraLimite").html("<b>Hora L&iacute;mite: </b>" + datosEnc.HoraLimite);
                } else {
                    $("#txtHoraLimite").html("<b>Hora L&iacute;mite: </b> Sin definir");
                }

                if ((datosEnc.CantMaxAccesos != "") && (datosEnc.CantMaxAccesos != null)) {
                    $("#txtMaxAcc").html("<b>Cantidad de Accesos: </b>" + datosEnc.CantMaxAccesos);
                } else {
                    $("#txtMaxAcc").html("<b>Cantidad de Accesos: </b> Sin definir");
                }
                
                
                if(datosEnc.idTipoEncuesta == 3){
                    
                    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verPartPanel'}, function (recolectores) {
                        //alert(recolectores);
                        var sal = parseInt(recolectores);
                        if (isNaN(sal)) {// como no es un numero, significa que devolvio un json
                            var datosReco = JSON.parse(recolectores);
                            if(datosReco.Identificadores != ""){
                                $('#txtIdsPart').tagsinput('add', datosReco.Identificadores);
                                $("#txtIdsPart").attr('readonly', 'readonly');
                                $('#txtIdsPart').removeAttr('data-role');
                            }
                            
                            if(datosReco.Emails != "" && datosReco.Emails != null){                                
                                $('#txtDestinos').tagsinput('add', datosReco.Emails);
                                $("#ckRecEmail").attr('checked','checked');
                                $("#pnlRecEmail").show();
                            }
                        }  

                    });
                    
                }
                
                if(datosEnc.idTipoEncuesta == "5"){
                    
                }
                
                
            }

        });
    }


 $("#formrecopilar").validate({
    	rules: {
            "ckRecolector[]": { required: true, minlength: 1 },
            txtFcIni: { required: true },
            txtIdsPart: { required: true },
            txtEnlaceWeb: {
                required: function (element) {
                    return ($("#ckRecWeb").is(':checked'));
                }
            },             
            txtDestinos: {
                required: function (element) {
                    return ($("#ckRecEmail").is(':checked'));
                }
            }, 
            txtAsunto: {
                required: function (element) {
                    return ($("#ckRecEmail").is(':checked'));
                }
            }, 
            txtMensaje: {
                required: function (element) {
                    return ($("#ckRecEmail").is(':checked'));
                }
            }, 
    	},
    	messages: {
            "ckRecolector[]": "Debe seleccionar un recolector",
            txtFcIni: "Dato requerido",
            txtIdsPart: "Debe ingresar las identficaciones de los participantes",
            txtEnlaceWeb: "Dato requerido",
            txtDestinos: "Dato requerido",
            txtAsunto: "Dato requerido",
            txtMensaje: "Dato requerido",
    	},
    	
    	submitHandler: function(form) {
        $.ajax({
            url: "Negocios/encuestas.php",
            type: "POST",
            data: $(form).serialize(),
            beforeSend: function () {
                $("#respuesta").html("Cargando ... ");
            },
            success: function (response) {
                //alert(response);
                if (!isNaN(response)) {
                    $("#respuesta").html("<div class='alert alert-success'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>"
                            + "La encuesta ya es p&uacute;blica para la recopilaci&oacute;n de datos</div>");
                    $("#btnRecopilar").hide();

                } else {
                    $("#respuesta").html(response);
                }

            },
            error: function (xhr, status, error) {
                var error = formatErrorMessage(xhr, error);
                $("#respuesta").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                        error + "</div>");
            }
        });
        }
    });

});