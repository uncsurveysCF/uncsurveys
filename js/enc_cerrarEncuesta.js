$(document).ready(function () {
  
    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
            //alert(data);
        var respuesta = parseInt(data);
        if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
            var datosEnc = JSON.parse(data);

            $("#txtTitulo").html(datosEnc.Titulo);
            $("#txtTema").html("<b>Tema:</b> " + datosEnc.Tema);
            $("#txtTipo").html("<b>Tipo:</b> " + datosEnc.Tipo);
            $("#txtDescripcion").html(datosEnc.Descripcion);
            $("#txtRespuestas").html("<p><b>El total de respuestas registradas es: " + datosEnc.cantResp+"</b></p>");              


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
        }
    });
    
    $("#btnCerrar").click(function () {
	if(confirm("Est\u00E1 seguro que desea cerrar la encuesta: " + $("#txtTitulo").html()))
        {
            $.ajax({
                url: "Negocios/encuestas.php",
                type:"POST",
                data: {idEncuesta: $("#hfIdEncuesta").val(), idPeriodo:'0', oper: 'cerrarEncuesta'},
                beforeSend: function () {
                    $("#resultado").html("Cargando ... ");
                },
                success:  function (response) {
                 $("#respuesta").html("");                      
                 if(!isNaN(response)) {
                      alert("La encuesta ha sido cerrada, ya no se recibir\u00E1n m\u00E1s respuestas");
                      window.location = "enc_listadoEncuestas.php";
                  } else{
                      $("#resultado").html(response);
                  }    
                },
                error: function(xhr, status, error){		   	        	
                    var error = formatErrorMessage(xhr, error);
                    $("#resultado").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                                            error + "</div>");
                }    
             });
        }
    });
    
    
});
