$(document).ready(function () {
if ($("#hfIdEncuesta").val() != "")
    {
        $.post("../Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
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
                
                $("#hfIdEstado").val(datosEnc.idEstado);    
               
                

            }
        });
        
        


        $.post("../Negocios/preguntas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'pregXPagAn'}, function (resp)
        {
            if(resp == -1){
                $(".tab-pane").hide();
                $("#datosEnc.tab-pane").show();
                $("#datosEnc").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
				"A&uacute;n no se han registrado respuestas</div>");
            }
            else{
                $("#datosEnc").html(resp);
                //alert($("#hfIdEstado").val());
                if($("#hfIdEstado").val() == "3"){
                  $(".interpre").show();  
                }else{
                  $(".interpre").hide();  
                }
                $(".btn").hide(); 
                
                $.ajax({type: "POST", url: "../Negocios/preguntas.php", async: true, data: {idEncuesta: $("#hfIdEncuesta").val(), oper: 'listaXenc'},
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
                                    $("#preguntas1" + idP).html("<img src='../img/ajax-loaders/ajax-loader-1.gif' title='img/ajax-loaders/ajax-loader-1.gif'>");
                                    switch (tipoPreg)
                                    {
                                        case "1":
                                        case "12":
                                        case "2":
                                            $.ajax({type: "POST", async: false, url: "../Negocios/preguntas.php", data: {idPregunta: idP, idEscala: escala, oper: 'anPregOpciones'},
                                                success: function (opciones) {
                                                    //alert(opciones);
                                                    var data = JSON.parse(opciones);
                                                    if(escala == "1"){
                                                    //alert(data.frecuencias[0][0]);
                                                    var tabla = "<table  class='table datatable table-bordered'><tr><th rowspan='2'>Opci&oacute;n</th>" +
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
                                                    $("#preguntas1" + idP).html("<div class='col-md-10'><a href='../Datos/img/"+data.grafico+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='../Datos/img/"+data.grafico+"' alt='Distribucion de Frecuencias' /></a></div>");
                                                }
                                            });
                                            break;
                                        case "3":
                                        case "4":
                                            $.ajax({type: "POST", async: false, url: "../Negocios/preguntas.php", data: {idPregunta: idP, idEscala: escala, oper: 'anPregMatriz'},
                                                
                                                success: function (opciones) {
                                                //alert(opciones);
                                                    var data = JSON.parse(opciones); 
                                                    $("#preguntas1" + idP).css({"min-height": "200px"});
                                                    $("#preguntas1" + idP).html("<div class='col-md-10'><a href='../Datos/img/"+data.grafico+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='../Datos/img/"+data.grafico+"' alt='Distribucion de Frecuencias' /></a></div>");
                                                    $("#preguntas2" + idP).html(data.tabla);

                                                }
                                            });
                                            break;

                                        case "6":
                                        case "8":
                                            $.ajax({type: "POST", async: false, url: "../Negocios/preguntas.php", data: {idPregunta: idP, idEscala: escala, idFormato: formato, oper: 'anPregTexto'},
                                                success: function (opciones) {
                                                    var data = JSON.parse(opciones); 
                                                    if((escala == "2") || (escala == "3") || (escala == "4"))
                                                    {  
                                                        var tabla = "<table  class='table datatable table-bordered'>";

                                                        for (f in data.summary[0])
                                                        {
                                                            tabla += "<tr><td><b>" + data.summary[0][f] + ": <b></td><td>" + data.summary[1][f] + "</td></tr>";
                                                        }
                                                        tabla += "<tr><td><b>Varianza:</b></td><td>"+ data.varianza +"</td></tr>";
                                                        tabla += "<tr><td><b>Desvio estandar:</b></td><td>"+ data.desvioEst +"</td></tr>";
                                                        tabla += "</table>";
                                                        $("#preguntas2" + idP).html(tabla);
                                                        $("#preguntas1" + idP).html("<div class='col-md-10'><a href='../Datos/img/"+data.grafico+"' target='_blank' title='Click para descargar'><img class='img-responsive' src='../Datos/img/"+data.grafico+"' alt='Grafico de Cajas' /></a></div>");
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
                                            $.ajax({type: "POST", async: false, url: "../Negocios/preguntas.php", data: {idPregunta: idP, oper: 'anDifSem'},
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
