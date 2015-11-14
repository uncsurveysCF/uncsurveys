function comprobarEscala(){
    $("#escala1").val("0");
    $("#escala2").val("0");
    if(($("#cbPregunta1").val() != "-1") && ($("#cbPregunta2").val() != "-1"))
    {
        $.post("Negocios/preguntas.php", {idPregunta: $("#cbPregunta1").val(), oper: 'verEscala'}, function (respEscala) {
         $("#escala1").val(respEscala);
         $.post("Negocios/preguntas.php", {idPregunta: $("#cbPregunta2").val(), oper: 'verEscala'}, function (respEscala2) {             
          $("#escala2").val(respEscala2);

          if(parseInt($("#escala1").val()) > 2 && parseInt($("#escala2").val()) > 2){                 
              $("#cbMetodo").append('<option value="pearson">Pearson</option>');
          }else{
              $("#cbMetodo option[value='pearson']").remove();                 
          }
         });

        });
    }  
}

function guardarInterpretacion(idPregunta){
    $.post("Negocios/preguntas.php", {idPregunta: idPregunta,Texto: $("#txtInterpretacion" + idPregunta).val(), oper: 'cargaInterp'}, function (respuesta) {
      if(respuesta != "1")
      {
          $("#txtInterpretacion" + idPregunta).val("");
      }      
    });
}


$(document).ready(function () {
    
    $('#tabsAnEncuesta a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $("#cbPregunta1").change(function () {
        comprobarEscala();
    });

    $("#cbPregunta2").change(function () {
        comprobarEscala();
    });


    $("#btnGraf").click(function () {
        $.post("Negocios/preguntas.php", {idPregunta1: $("#cbPregunta1").val(),idPregunta2: $("#cbPregunta2").val(), oper: 'anPearson'}, function (respuesta) {
          $("#grafAnalisis").html("<div class='col-md-10'><a href='Datos/img/"+respuesta+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='Datos/img/"+respuesta+"' alt='Analisis' /></a></div>");
        });
    });
    
    
    $("#formCorrelacion").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		cbPregunta1: "required",
    		cbPregunta2: "required",
                cbMetodo: "required",
    		},
    	messages: {
    		cbPregunta1: "Seleccione una pregunta",
                cbPregunta2: "Seleccione una pregunta",
                cbMetodo: "Seleccione un m&eacute;todo",
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/preguntas.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuesta").html("Cargando ... ");
                     },
                     success:  function (response) {
                      //alert(response);
                      var datos = JSON.parse(response);
                      if(datos.resultado == "ok") {
                    	   $("#grafAnalisis").html("<div class='col-md-10'><a href='Datos/img/"+datos.salida+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='Datos/img/"+datos.salida+"' alt='Analisis' /></a></div>");
                       } else{                    	   
                    	   $("#grafAnalisis").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                                                + " Ha ocurrido un error. - "+ datos.salida +" </div>");
                       }    
                     },
         	        error: function(xhr, status, error){		   	        	
         	        	var error = formatErrorMessage(xhr, error);
         	        	$("#grafAnalisis").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
         						error + "</div>");
         			}    
             });
    		
    	}
    		
	});
        
        $("#formLikert").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		cbLikert: "required",
    		cbOpcionLikert: "required",
                cbGrupo: "required",
                txtMetodo: "required",
    		},
    	messages: {
    		cbLikert: "Seleccione una pregunta",
                cbOpcionLikert: "Seleccione una opci&oacute;n",
                cbGrupo: "Seleccione una pregunta",
                txtMetodo: "Falta un metodo",
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/preguntas.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#grafAnalisisLikert").html("Cargando ... ");
                     },
                     success:  function (response) {
                      //alert(response);
                      var datos = JSON.parse(response);
                      if(datos.resultado == "ok") {
                          $("#detAnalisis").html("<p>"+ datos.valorP +"</p>");
                    	  $("#grafAnalisisLikert").html("<div class='col-md-10'><img class='img-responsive' src='Datos/img/"+datos.grafico+"' alt='Analisis' /></div>");
                       } else{                    	   
                    	   $("#grafAnalisisLikert").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                                                + " Ha ocurrido un error. </div>");
                       }    
                     },
         	        error: function(xhr, status, error){		   	        	
         	        	var error = formatErrorMessage(xhr, error);
         	        	$("#grafAnalisisLikert").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
         						error + "</div>");
         			}    
             });
    		
    	}
    		
	});
 

    if ($("#hfIdEncuesta").val() != "")
    {
        $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val() , oper: 'respXEnc'}, function (data) {
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
        
        
        $.post("Negocios/preguntas.php", {vdefaul: '...', selected:'',idEncuesta: $("#hfIdEncuesta").val() , oper: 'comboPreg'}, function (data) {
          $("#cbPregunta1").html(data);
          $("#cbPregunta2").html(data);
        });
        
        $.post("Negocios/preguntas.php", {vdefaul: '...', selected:'',idEncuesta: $("#hfIdEncuesta").val() , oper: 'comboPregLikert'}, function (data) {
            //alert(data);
          $("#cbLikert").html(data);
        });
        
        $.post("Negocios/preguntas.php", {vdefaul: '...', selected:'',idEncuesta: $("#hfIdEncuesta").val() , oper: 'comboPregNom'}, function (data) {
          $("#cbGrupo").html(data);
        });
        
         $("#cbLikert").change(function () {
            $.post("Negocios/preguntas.php", {vdefaul: '...', selected:'',idPregunta: $("#cbLikert").val() , oper: 'comboOpcionesPreg'}, function (data) {
                $("#cbOpcionLikert").html(data);
              });
        });
        
         $("#cbGrupo").change(function () {
            $.post("Negocios/preguntas.php", {idPregunta: $("#cbGrupo").val() , oper: 'OpcionesPreg'}, function (data) {
               var opciones = parseInt(data);
               var o,salida,metodo;
                if (isNaN(opciones)) {// como no es un numero, significa que devolvio un json
                    var opciones = JSON.parse(data);                    
                    salida = "<br /><ul>";
                    for (o in opciones)
                    {
                        salida += "<li>"+opciones[o].Texto+"</li>";
                    }
                    salida += "</ul>";
                    //alert(opciones.length);
                    if(opciones.length <= 2)
                    {
                        metodo = "Mann-Whitney";
                    }else{
                        metodo = "Kruskal-Wallis";
                    }
                    $("#grupos").html(salida);
                    $("#txtMetodo").val(metodo);
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
                    $("#txtMaxAcc").html("<b>Cantidad max. de Accesos: </b>" + datosEnc.CantMaxAccesos);
                } else {
                    $("#txtMaxAcc").html("<b>Cantidad max. de Accesos: </b> Sin definir");
                }
                $("#hfIdEstado").val(datosEnc.idEstado);    
                if(datosEnc.idEstado >= 3){
                    $("#btnCerrar").hide();
                }
                

            }
        });
        
        


        $.post("Negocios/preguntas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'pregXPagAn'}, function (resp)
        {
            if(resp == -1){
                $(".tab-pane").hide();
                $("#datosEnc.tab-pane").show();
                $("#datosEnc").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
				"A&uacute;n no se han registrado respuestas</div>");
            }
            else{
                $("#datosEnc").html(resp);
                if($("#hfIdEstado").val() == "3"){
                  $(".interpre").show();  
                }else{
                  $(".interpre").hide();  
                }
                  
                $.ajax({type: "POST", url: "Negocios/preguntas.php", async: true, data: {idEncuesta: $("#hfIdEncuesta").val(), oper: 'listaXenc'},
                    success: function (listado)
                    {
                        var r = parseInt(listado);
                        if (isNaN(r))
                        {
                            var preguntas = JSON.parse(listado);
                            var i, tipoPreg, escala, formato;

                            for (i in preguntas)
                            {
                                var idP = preguntas[i].idPregunta;
                                tipoPreg = preguntas[i].idTipoPregunta;
                                escala = preguntas[i].idEscala;
                                formato = preguntas[i].idFormato;
                                
                                if (preguntas[i].incluirAnalisis == 1)
                                {
                                    $("#txtInterpretacion" + idP).val(preguntas[i].Interpretacion);
                                    $("#preguntas1" + idP).html("<img src='img/ajax-loaders/ajax-loader-1.gif' title='img/ajax-loaders/ajax-loader-1.gif'>");
                                    switch (tipoPreg)
                                    {
                                        case "1":
                                        case "12":
                                        case "2":
                                            $.ajax({type: "POST", async: false, url: "Negocios/preguntas.php", data: {idPregunta: idP, idEscala: escala, oper: 'anPregOpciones'},
                                                success: function (opciones) {
                                                    //alert(opciones);
                                                    var data = JSON.parse(opciones);
                                                    if(escala == "1"){
                                                    //alert(data.frecuencias[0][0]);
                                                    var tabla = "<table  class='table datatable table-bordered responsive'><tr><th rowspan='2'>Opci&oacute;n</th>" +
                                                            "<th colspan='2'>Respuestas</th></tr><tr><th>Frecuencia</th><th>Frec. Relativa</th></tr>";
                                                    //alert(data[1][1][1]);
                                                    for (f in data.frecuencias[0])
                                                    {
                                                        tabla += "<tr><td>" + data.frecuencias[0][f].trim() + "</td><td>" + data.frecuencias[1][f] + "</td><td>" +
                                                                 data.frecuencias[2][f] + " %</td></tr>";
                                                    }
                                                    tabla += "<tr><th colspan='3'>MODA:" + data.modo + " </th></tr></table>";
                                                    }else{
                                                        var textos="";var porcentajes="";
                                                        var ordenes="";var cuartiles="";                                                    
                                                        //alert(opciones);
                                                         if(escala == "2"){
                                                            var tabla = "<table  class='table datatable table-bordered'>" +
                                                                          "<tr><th colspan='3'>Referencias</th></tr><tr><td><table  class='table datatable table-bordered'>";                                                
                                                            for (f in data.referencias)
                                                            {
                                                                textos += "<td>" + data.referencias[f].label + "</td>";
                                                                ordenes += "<td>" + data.referencias[f].Orden + "</td>";
                                                            }
                                                            tabla += "<tr><td>&nbsp;</td>"+textos+"</tr><tr><td>Orden</td>"+ordenes+"</tr></table></td></tr>" +
                                                                     "<tr><th colspan='3'>MODA:" + data.modo + " </th></tr>" +
                                                                     "<tr><th colspan='3'>MEDIANA:" + data.mediana + " </th></tr>" +
                                                                     "<tr><td><table class='table datatable table-bordered'><tr><th colspan='3'>Quartiles</th></tr>";

                                                            for (q in data.cuartiles[0])
                                                            {
                                                                porcentajes += "<td>" + data.cuartiles[0][q] + "</td>";
                                                                cuartiles += "<td>" + data.cuartiles[1][q] + "</td>";
                                                            } 
                                                            tabla +="<tr>"+porcentajes+"</tr><tr>"+cuartiles+"</tr></table></td></tr></table>";
                                                         }
                                                    }

                                                    $("#preguntas2" + idP).html(tabla);
                                                    /*$("#preguntas1" + idP).css({"min-height": "200px"});*/
                                                    $("#preguntas1" + idP).html("<div class='col-md-10'><a href='Datos/img/"+data.grafico+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='Datos/img/"+data.grafico+"' alt='Distribucion de Frecuencias' /></a></div>");
                                                }
                                            });
                                            break;
                                        case "3":
                                        case "4":
                                            $.ajax({type: "POST", async: false, url: "Negocios/preguntas.php", data: {idPregunta: idP, idEscala: escala, oper: 'anPregMatriz'},
                                                
                                                success: function (opciones) {
                                                //alert(opciones);
                                                    var data = JSON.parse(opciones); 
                                                    $("#preguntas1" + idP).css({"min-height": "200px"});
                                                    $("#preguntas1" + idP).html("<div class='col-md-10'><a href='Datos/img/"+data.grafico+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='Datos/img/"+data.grafico+"' alt='Distribucion de Frecuencias' /></a></div>");
                                                    $("#preguntas2" + idP).html(data.tabla);

                                                }
                                            });
                                            break;

                                        case "6":
                                        case "8":
                                            $.ajax({type: "POST", async: false, url: "Negocios/preguntas.php", data: {idPregunta: idP, idEscala: escala, idFormato: formato, oper: 'anPregTexto'},
                                                success: function (opciones) {
                                                    var data = JSON.parse(opciones); 
                                                    if((escala == "2") || (escala == "3") || (escala == "4"))
                                                    {  
                                                        var tabla = "<table  class='table datatable table-bordered responsive'>";

                                                        for (f in data.summary[0])
                                                        {
                                                            tabla += "<tr><td><b>" + data.summary[0][f] + ": <b></td><td>" + data.summary[1][f] + "</td></tr>";
                                                        }
                                                        tabla += "<tr><td><b>Varianza:</b></td><td>"+ data.varianza +"</td></tr>";
                                                        tabla += "<tr><td><b>Desv&iacute;o estandar:</b></td><td>"+ data.desvioEst +"</td></tr>";
                                                        
                                                        if((escala == "4"))
                                                        {
                                                            tabla += "<tr><td><b>Medio Geo.:</b></td><td>"+ data.mediaGeo +"</td></tr>";
                                                            tabla += "<tr><td><b>Coef. Variaci&oacute;n:</b></td><td>"+ data.coeficiente +"</td></tr>";
                                                        }
                                                        
                                                        tabla += "</table>";
                                                        $("#preguntas2" + idP).html(tabla);
                                                        $("#preguntas1" + idP).html("<div class='col-md-10'><a href='Datos/img/"+data.grafico+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='Datos/img/"+data.grafico+"' alt='Grafico de Cajas' /></a></div>");
                                                    }
                                                    else{
                                                        $("#preguntas1" + idP).html("");
                                                        $("#preguntas1" + idP).css({"min-height": "200px"});
                                                        $("#preguntas1" + idP).jQCloud(data);
                                                    }
                                                }
                                            });
                                            break;
                                        
                                        case "11":
                                            $.ajax({type: "POST", async: false, url: "Negocios/preguntas.php", data: {idPregunta: idP, oper: 'anDifSem'},
                                                success: function (opciones) 
                                                {
                                                    $("#preguntas1" + idP).html(opciones);
                                                }
                                            });
                                            break;
                                            

                                    }
                                }
                                
                                
                                
                                
                            }
                        }
                        
                       
                        
                    }
                });
            }
        });
    }
});