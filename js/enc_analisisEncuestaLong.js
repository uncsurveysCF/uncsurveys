$(document).ready(function () {
    
    $('#tabsAnEncuesta a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $("#btnAnalisis").click(function () {
        $("#resultAn").html("<img src='img/ajax-loaders/ajax-loader-6.gif' title='Cargando....' alt='Cargando....'>");
        $.post("Negocios/preguntas.php", {idPregunta: $("#cbPregunta").val(), idEncuesta: $("#hfIdEncuesta").val(), oper: 'anPregXPeriodo'}, function (respuesta) {
            //alert(respuesta);
            $("#resultAn").html(respuesta);
        });
    });

    $("#btnRespuestas").click(function () {
        $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), idPeriodo:$("#cbPeriodos").val(), oper: 'respXEncXPer'}, function (data) {
           //alert(data);
            var respuesta = parseInt(data);
            if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
                var datosEnc = JSON.parse(data);
                var idR = datosEnc[0].idRespuesta;
                $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(),idRespuesta: idR, oper: 'unaResps'}, function (respuesta) {
                        $("#contenidoPag").html(respuesta);
                });
                $('#page-selection').bootpag({
                    total: datosEnc.length,
                    page: 1,
                    maxVisible: 5
                }).on("page", function(event, /* page number here */ num){
                    var index = num - 1;
                    var idInd = datosEnc[index].idRespuesta;
                    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(),idRespuesta: idInd, oper: 'unaResps'}, function (respuesta) {
                        $("#contenidoPag").html(respuesta);
                      });
                });

            }
        });
    });

    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
            //alert(data);
            var respuesta = parseInt(data);
            if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
                var datosEnc = JSON.parse(data);

                $("#txtTitulo").html(datosEnc.Titulo);
                $("#txtTema").html("<b>Tema:</b> " + datosEnc.Tema);
                $("#txtTipo").html("<b>Tipo:</b> " + datosEnc.Tipo);
                $("#txtDescripcion").html(datosEnc.Descripcion);

                if ((datosEnc.Proposito != "") && (datosEnc.Proposito != null)) {
                    $("#txtProposito").html("<b>Prop&oacute;sito: </b> " + datosEnc.Proposito);
                } else {
                    $("#txtProposito").html("<b>Prop&oacute;sito: </b> Sin definir");
                }
                
                if ((datosEnc.Poblacion != "") && (datosEnc.Poblacion != null)) {
                    $("#txtPoblacion").html("<b>Poblaci&oacute;n:</b> " + datosEnc.Poblacion);
                } else {
                    $("#txtPoblacion").html("<b>Poblaci&oacute;n:</b> Sin definir");
                }
                
                if ((datosEnc.CaractecisticasMuestra != "") && (datosEnc.CaractecisticasMuestra != null)) {
                    $("#txtCarMu").html("<b>Caracteristicas de la Muestra:</b> " + datosEnc.CaractecisticasMuestra);
                } else {
                    $("#txtCarMu").html("<b>Caracteristicas de la Muestra:</b> Sin definir");
                }

                if ((datosEnc.FechaLimite != "") && (datosEnc.FechaLimite != null)) {
                    $("#txtFechaLimite").html("<b>Fecha L&iacute;mite: </b>" + datosEnc.FechaLimite);
                } else {
                    $("#txtFechaLimite").html("<b>Fecha L&iacute;mite: </b> Sin definir");
                }

                if ((datosEnc.HoraLimite != "") && (datosEnc.HoraLimite != null)) {
                    $("#txtHoraLimite").html("<b>Hora L&iacute;mite: </b>" + datosEnc.HoraLimite);
                } else {
                    $("#txtHoraLimite").html("<b>Hora L&iacute;mite: </b> Sin definir");
                }

                if ((datosEnc.CantMaxAccesos != "") && (datosEnc.CantMaxAccesos != null)) {
                    $("#txtMaxAcc").html("<b>Cant. max. de respuestas: </b>" + datosEnc.CantMaxAccesos);
                } else {
                    $("#txtMaxAcc").html("<b>Cant. max. de respuestas: </b> Sin definir");
                }
                                
                $.post("Negocios/preguntas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'cantResp'}, function (resp)
                {
                    if(resp <= 0){
                        $(".tab-pane").hide();
                        $("#datosEnc.tab-pane").show();
                        $("#datosEnc").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                         "A&uacute;n no se han registrado respuestas</div>");
                    }
                    
                    $.post("Negocios/preguntas.php", {vdefaul: '...', selected:'',idEncuesta: $("#hfIdEncuesta").val() , oper: 'comboPregAn'}, function (data) {
                        $("#cbPregunta").html(data);
                    });
                    
                    $.post("Negocios/encuestas.php", {vdefaul: '...', selected:'',idEncuesta: $("#hfIdEncuesta").val() , oper: 'comboPeriodosAn'}, function (data) {
                        $("#cbPeriodos").html(data);
                    });
                    
                });
                

            }
        });
        
        


});
