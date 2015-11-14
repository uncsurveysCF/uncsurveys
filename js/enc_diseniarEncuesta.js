/******************** PAGINAS ***************************/

function editarTitulo(idEncuesta, idPagina, Titulo) {
    $("#txtTituloPag").val(Titulo);
    $("#nropagina").val(idPagina);
    $("#hdIdEncPag").val(idEncuesta);
    $("#mlPagina").modal('show');
}

function eliminarPagina(idEncuesta, idPagina, Titulo) {
    if (confirm("Esta seguro que desea eliminar la pagina " + Titulo + "? Tambien se eliminaran las preguntas que incluye. ")) {

        $.ajax({
            url: "Negocios/encuestas.php",
            type: "POST",
            data: {idEncuesta: idEncuesta, idPagina: idPagina, oper: 'eliminarPagina'},
            beforeSend: function () {
                $("#respuestaPag").html("Cargando ... ");
            },
            success: function (response) {
                alert(response);
                if (!isNaN(response)) {
                    $("#respuestaPag").html("");
                    $("#mlPreguntas").modal('hide');
                    $.post("Negocios/encuestas.php", {idEncuesta: idEncuesta, oper: 'preguntasXEncuesta'}, function (resultado) {
                        $("#disenioEncuesta").html(resultado);
                    });

                } else {
                    $("#respuestaPag").html(response);
                }

            },
            error: function (xhr, status, error) {
                var error = formatErrorMessage(xhr, error);
                $("#respuestaPag").html(error);
            }
        });
    }
}



/*******************************************************/
function ordernarPreguntas() {
    var x, orden, ele;
    var listaElementos = "";
    var ordenElementos = $(".ui-state-default");
    for (x = 0; x < ordenElementos.length; x++) {
        ele = ordenElementos[x];
        orden = parseInt(x) + 1;
        $("#s" + ele.id).html(orden);
        listaElementos += ele.id + ",";
    }
    //alert(listaElementos);
    $.post("Negocios/preguntas.php", {lista: listaElementos, idEncuesta: $("#hfIdEncuesta").val(),
        oper: 'ordenarPreguntas'}, function (data) {
        
    });

}

function cargarPreguntas() {
    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'preguntasXEncuesta'}, function (resultado) {
        $("#disenioEncuesta").html(resultado);
        $(".fecha").datepicker();
         
         if($("#hfIdEstado").val() == "2" || $("#hfIdEstado").val() == "3")
         {
            $(".btnpreg").hide(); 
            $(".box-icon").hide();
          }
          else{
            ordernarPreguntas();
            $(".sortable").sortable({
                revert: true,
                placeholder: "ui-state-highlight",
                update: function () {
                    ordernarPreguntas();
                }
            });
            $("#draggable").draggable({
                connectToSortable: ".sortable",
                helper: "clone",
                revert: "invalid",
                cursor: "move"
            });
            $("ul, li").disableSelection();
        }
    });
}

function eliminarPregunta(idPregunta, idEncuesta) {
    $("#respuestaPag").html("");
    if (confirm("Esta seguro que desea eliminar la pregunta?")) {
        $.post("Negocios/preguntas.php", {idPregunta: idPregunta, idEncuesta: idEncuesta, oper: 'eliminar'}, function (respuesta) {

            if (respuesta == "1") {
                precargarDatos();
            } else {

                $("#respuestaPag").html(respuesta);
            }
        });

    }
}

function editarPregunta(idPregunta, idEncuesta) {
    $.post("Negocios/preguntas.php", {idPregunta: idPregunta, idEncuesta: idEncuesta, oper: 'editar'}, function (respuesta) {
        $("#respuestaPregM").html("");
        $("#respuestaPag").html("");
        var respPreg = parseInt(respuesta);
        if (isNaN(respPreg)) {// como no es un numero, significa que devolvio un json
            var datosPreg = JSON.parse(respuesta);
            $("#paginaModfi").val(datosPreg.idPagina);
            $("#hdIdPregModif").val(datosPreg.idPregunta);
            $("#hdIdTipoPreg").val(datosPreg.idTipoPregunta);
            $("#txtTipoPreguntaM").val(datosPreg.tipoPregunta);
            $("#txtPreguntaM").val(datosPreg.Texto);
            $("#txtMinM").val(datosPreg.ValorMinimo);
            $("#txtMaxM").val(datosPreg.ValorMaximo);
            $(".opcMultiplesM").hide();
            $(".rowOpcionesM").hide();
            $(".opTextoM").hide();
            $("#ordenOpM").hide();
            
            if (datosPreg.RespuestaObligatoria == 1)
            {
                $("#chRespObligatoriaM").prop('checked', true);
            } else {
                $("#chRespObligatoriaM").prop('checked', false);
            }

            //alert(datosPreg.incluirAnalisis);
            if (datosPreg.incluirAnalisis == 1)
            {
                $("#chAnalisisM").prop('checked', true);
            } else {
                $("#chAnalisisM").prop('checked', false);
            }


            $.post("Negocios/parametricas.php", {vdefaul: '...', selected: datosPreg.idEscala, oper: 'escalas'}, function (data) {
                $("#cbEscalaM").html(data);
            });

            $.post("Negocios/parametricas.php", {vdefaul: '...', selected: datosPreg.idFormato, oper: 'formatos'}, function (data) {
                $("#cbFormatoM").html(data);
                
                $("#txtMinM").unmask("99/99/9999");
                $("#txtMaxM").unmask("99/99/9999");
                if (datosPreg.idFormato == "1") {
                    $("#txtMinM").attr("placeholder", "long. Minima");
                    $("#txtMaxM").attr("placeholder", "long. Maxima");
                    $(".opcMultiplesM").hide();
                } else {
                    if (datosPreg.idFormato == "4") {
                        $("#txtMinM").mask("99/99/9999");
                        $("#txtMaxM").mask("99/99/9999");
                        $(".opcMultiplesM").hide();
                    } else {
                        if (datosPreg.idFormato == "5") {
                            $(".col-md-3.opTextoM").hide();
                            $(".opcMultiplesM").hide();
                        }
                        else {
                            if (datosPreg.idFormato == "2" || datosPreg.idFormato == "3") {
                                $(".opcMultiplesM").show();
                            }
                        }
                    }
                }

            });


            $("#cbFormatoM").change(function () {
                $("#cbFormatoM option:selected").each(function () {
                    var formato = $(this).val();
                    $(".opcMultiplesM").hide();
                    $("#txtMinM").attr("placeholder", "Minimo");
                    $("#txtMaxM").attr("placeholder", "Maximo");
                    $(".col-md-3.opTextoM").show();
                    $("#txtMinM").unmask("99/99/9999");
                    $("#txtMaxM").unmask("99/99/9999");
                    if (formato == "1") {
                        $("#txtMinM").attr("placeholder", "long. Minima");
                        $("#txtMaxM").attr("placeholder", "long. Maxima");
                    } else {
                        if (formato == "4") {
                            $("#txtMinM").mask("99/99/9999");
                            $("#txtMaxM").mask("99/99/9999");
                        } else {
                            if (formato == "5") {
                                $(".col-md-3.opTextoM").hide();
                            }
                            else {
                                $(".opcMultiplesM").show();
                            }
                        }
                    }

                });
            });


            var i, j;
            $("#ordenOpM").hide();
            $(".orop").hide();
            $("#opDifM").hide();
            $("#rowOpcionesM").show();
            $("#verOpcionesM").html("");
            $("#verColumnasM").html("");
            switch (datosPreg.idTipoPregunta) {
                case "1":
                    $(".opTextoM").hide();
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcion("", "radio", "verOpcionesM","1",datosPreg.idEscala);
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcion(datosPreg.opciones[i].Texto, "radio", "verOpcionesM",datosPreg.opciones[i].Orden,datosPreg.idEscala);
                    }
                    $("#ordenOpM").show();
                    
                    if(datosPreg.idEscala == 2)
                    {
                        $("#chOrdenarOpM").prop('checked', true);
                        $(".orop").show();
                    } else {
                        $("#chOrdenarOpM").prop('checked', false);
                         $(".orop").hide();
                    }
                    break;

                case "2":

                    $(".opTextoM").hide();
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcion("", "checkbox", "verOpcionesM","1",datosPreg.idEscala);
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcion(datosPreg.opciones[i].Texto, "checkbox", "verOpcionesM",datosPreg.opciones[i].Orden,datosPreg.idEscala);
                    }

                    break;

                case "3":                    
                    $(".opTextoM").hide();
                    $("#verOpcionesM").append('<div class="row"><div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label class="text-left">Filas:</label>' +
                            '</div></div></div>');
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcion("", "", "verOpcionesM","");
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcion(datosPreg.opciones[i].Texto, "", "verOpcionesM",datosPreg.opciones[i].Orden,datosPreg.idEscala);
                    }
                    $("#verColumnasM").append('<div class="row">&nbsp;</div><div class="row"><div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label class="text-left">Columnas:</label>' +
                            '</div></div></div>');
                    if (datosPreg.columnas.length <= 0) {
                        agregarColumna("", "0", "verColumnasM");
                    }
                    for (j in datosPreg.columnas)
                    {

                        agregarColumna(datosPreg.columnas[j].Texto, datosPreg.columnas[j].Ponderacion, "verColumnasM");
                    }
                    $(".opTextoM").hide();
                    $("#rowOpcionesM").hide();
                    $(".orop").hide();
                    
                    break;

                case "4":
                    
                    $("#verOpcionesM").append('<div class="row"><div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label class="text-left">Filas:</label>' +
                            '</div></div></div>');
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcion("", "", "verOpcionesM","",datosPreg.idEscala);
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcion(datosPreg.opciones[i].Texto, "", "verOpcionesM",datosPreg.opciones[i].Orden,datosPreg.idEscala);
                    }
                    $("#verColumnasM").append('<div class="row">&nbsp;</div><div class="row"><div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label class="text-left">Columnas:</label>' +
                            '</div></div></div>');
                    if (datosPreg.columnas.length <= 0) {
                        agregarColumna("", "", "verColumnasM");
                    }
                    for (j in datosPreg.columnas)
                    {
                        agregarColumna(datosPreg.columnas[j].Texto, "", "verColumnasM");
                    }
                    
                    $(".opTextoM").hide();
                    $("#rowOpcionesM").hide();
                    $(".orop").hide();
                    break;

                case "5":
                    $(".opTextoM").hide();
                    $("#verOpcionesM").append('<div class="row"><div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label class="text-left">Filas:</label>' +
                            '</div></div></div>');
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcion("", "", "verOpcionesM","1",datosPreg.idEscala);
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcion(datosPreg.opciones[i].Texto, "", "verOpcionesM",datosPreg.opciones[i].Orden,datosPreg.idEscala);
                    }
                    $("#verColumnasM").append('<div class="row">&nbsp;</div><div class="row"><div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label class="text-left">Columnas:</label>' +
                            '</div></div></div>');
                    if (datosPreg.columnas.length <= 0) {
                        agregarColumna("", "", "verColumnasM");
                    }
                    for (j in datosPreg.columnas)
                    {
                        agregarColumna(datosPreg.columnas[j].Texto, "", "verColumnasM");
                    }
                    
                    $(".opTextoM").hide();
                    $("#rowOpcionesM").hide();
                    $(".orop").hide();
                    
                    break;
                    

                case "6":
                    $(".opTextoM").show();
                    $("#verOpcionesM").html("");
                    $("#verColumnasM").html("");
                    $("#rowOpcionesM").hide();
                    break;

                case "7":
                    $(".opTextoM").hide();
                    $("#verOpcionesM").html("");
                    $("#verColumnasM").html("");
                    $("#rowOpcionesM").hide();
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcion("", "text", "verOpcionesM","1",datosPreg.idEscala);
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcion(datosPreg.opciones[i].Texto, "text", "verOpcionesM",datosPreg.opciones[i].Orden,datosPreg.idEscala);
                    }
                    break;

                case "8":
                    $(".opTextoM").hide();
                    $("#rowOpcionesM").hide();
                    $("#verOpcionesM").html("");
                    $("#verColumnasM").html("");
                    break;

                case "9":
                    $(".opcMultiplesM").hide();
                    $(".opTextoM").show();
                    $("#rowOpcionesM").hide();
                    $("#verOpcionesM").html("");
                    $("#verColumnasM").html("");
                    break;
                   
                case "11":                   
                    $(".opTextoM").hide();
                    $("#opDifM").show();
                    $("#cbDiferencialesM").val(datosPreg.Diferencial);
                    
                    if (datosPreg.opciones.length <= 0) {
                        agregarOpcionDF("", "", "verOpcionesM");
                    }
                    for (i in datosPreg.opciones)
                    {
                        agregarOpcionDF(datosPreg.opciones[i].Texto, datosPreg.opciones[i].Texto2, "verOpcionesM");
                    }
                    break;

                case "12":
                    //alert(datosPreg.opciones[1].Texto);
                    $(".opTextoM").hide();
                    if (datosPreg.opciones.length < 2) {
                        $("#verOpcionesM").html(NuO_dicotmica("",""));
                    }else{
                         $("#verOpcionesM").html(NuO_dicotmica(datosPreg.opciones[0].Texto,datosPreg.opciones[1].Texto));
                    }
                    break;

                default:
                    alert("Error " + datosPreg.idTipoPregunta);
                    break;
            }

            $("#mlModifPreguntas").modal('show');
            //alert(datosPreg.opciones[0].Texto);
        }
    });
}

function precargarDatos() {

    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
        //alert(data);
        var respuesta = parseInt(data);
        if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
            var datosEnc = JSON.parse(data);
            $("#txtTitulo").html(datosEnc.Titulo);
            $("#txtDescripcion").html(datosEnc.Descripcion);
            $("#hfIdEstado").val(datosEnc.idEstado);
            if(datosEnc.idEstado >= 2){
              $("#btnPublicar").hide(); 
              $("#btnCompartir").hide(); 
              $("#btnNuevaPagina").hide(); 
              $("#btnNuevaPreg").hide(); 
              $(".box-icon").hide();   
            }
            
            if($("#hfIdUsuario").val() != datosEnc.idUsuario)
            {
                $("#btnCompartir").hide();
            }
            cargarPreguntas();
        }

    });
}

function agregarPregunta(idPagina) {
    $("#pagina").val(idPagina);
    $("#verOpciones").html("");
    $("#mlPreguntas").modal('hide');
    $("#cbTipoPregunta").val("");
    $("#txtPregunta").val("");
    $("#respuestaPreg").html("");
    $("#cbDiferenciales").val("");                        
    $("#cbFormato").val("");
    $("#cbEscala").val("");
    $("#txtMin").val("");
    $("#txtMax").val("");
    $("#ordenOp").hide();
    $("#opDif").hide();
    $("#rowOpciones").hide();
    $("#mlPreguntas").modal('show');
    $(".opTexto").hide();
    $(".opcMultiples").hide();
    
}


function quitarOpcion(elto) {
    elto.parentNode.parentNode.parentNode.parentNode.removeChild(elto.parentNode.parentNode.parentNode);
}

$("#chOrdenarOp").change(function () {
    if (this.checked) {
        $(".orop").show();
    } else {
        $(".orop").hide();
        $(".orop").each(function () {
            $(this).val("1");
        });

    }
});

$("#chOrdenarOpM").change(function () {
    if (this.checked) {
        $(".orop").show();
    } else {
        $(".orop").hide();
        $(".orop").each(function () {            
            $(this).val("1");
        });

    }
});

function agregarOpciones(tipoPreg) {
    $("#rowOpciones").show();
    $("#ordenOp").hide();
    $("#opDif").hide();
    $(".opcMultiples").hide();
    var arrOrd = $(".orop");
    var cant = arrOrd.length;
    cant = cant + 1;
    switch (tipoPreg) {
        case "1":
            var op = NuO_multipleUnaOpcion(tipoPreg, "", cant);
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            $("#ordenOp").show();
            if ($("#chOrdenarOp").is(':checked')) {
                $(".orop").show();
            } else {
                $(".orop").hide();
            }
            break;

        case "2":
            var op = NuO_multipleVariasOpciones(tipoPreg, "");
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            break;

        case "3":
            $("#rowOpciones").hide();
            var op = NuO_escalaValoracion(tipoPreg);
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            break;

        case "4":
            $("#rowOpciones").hide();
            var op = NuO_matriz(tipoPreg);
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            break;

        case "5":
            $("#rowOpciones").hide();
            var op = NuO_matriz(tipoPreg);
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            break;

        case "6":
            $("#rowOpciones").hide();
            $(".opTexto").show();
            break;

        case "7":
            var op = NuO_multipleTexto(tipoPreg);
            $("#verOpciones").append(op);
            $(".opTexto").show();
            break;

        case "8":
            $("#rowOpciones").hide();
            $(".opTexto").hide();
            break;

        case "9":
            $("#rowOpciones").hide();
            $(".opTexto").hide();
            break;

        case "10":
            $("#rowOpciones").hide();
            $("#verFormPreg").hide();
            $(".opTexto").hide();
            break;
        case "11":
            var op = NuO_escalaDF(tipoPreg, "", "");
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            $("#opDif").show();
            break;
            
        case "12":
            var op = NuO_dicotmica("","");
            $("#verOpciones").append(op);
            $(".opTexto").hide();
            break;
        
        default:
            alert("Error " + tipoPreg);
            break;
    }
}

$(document).ready(function () {

    $.post("Negocios/tiposDePreguntas.php", {vdefaul: '...', selected: '0', oper: 'combo'}, function (data) {
        $("#cbTipoPregunta").html(data);
    });

    $.post("Negocios/parametricas.php", {vdefaul: '...', selected: '0', oper: 'escalas'}, function (data) {
        $("#cbEscala").html(data);
    });

    $.post("Negocios/parametricas.php", {vdefaul: '...', selected: '0', oper: 'formatos'}, function (data) {
        $("#cbFormato").html(data);
    });

    $.post("Negocios/parametricas.php", {vdefaul: '...', selected: '0', oper: 'escalas'}, function (data) {
        $("#cbEscalaM").html(data);
    });

    $.post("Negocios/parametricas.php", {vdefaul: '...', selected: '0', oper: 'formatos'}, function (data) {
        $("#cbFormatoM").html(data);
    });

    $("#cbTipoPregunta").change(function () {
        $("#cbTipoPregunta option:selected").each(function () {
            var tipoPreg = $(this).val();
            if (tipoPreg != "") {
                $("#verFormPreg").show();
                $("#verOpciones").html("");
                agregarOpciones(tipoPreg);

            } else {
                $("#verFormPreg").hide();
            }
        });
    });

    $("#cbFormato").change(function () {
        $("#cbFormato option:selected").each(function () {
            var formato = $(this).val();
            $(".opcMultiples").hide();
            $("#txtMin").attr("placeholder", "Minimo");
            $("#txtMax").attr("placeholder", "Maximo");
            $(".col-md-3.opTexto").show();
            $("#txtMin").unmask("99/99/9999");
            $("#txtMax").unmask("99/99/9999");
            if (formato == "1") {
                $("#txtMin").attr("placeholder", "long. Minima");
                $("#txtMax").attr("placeholder", "long. Maxima");
            } else {
                if (formato == "4") {
                    $("#txtMin").mask("99/99/9999");
                    $("#txtMax").mask("99/99/9999");
                } else {
                    if (formato == "5") {
                        $(".col-md-3.opTexto").hide();
                    } else {
                        $(".opcMultiples").show();
                    }
                }
            }

        });
    });


    if ($("#hfIdEncuesta").val() != "") {
        precargarDatos();
    }

    $("#btnNuevaPagina").click(function () {
        $("#respuestaPag").html("");
        $.ajax({
            url: "Negocios/encuestas.php",
            type: "POST",
            data: {idEncuesta: $("#hfIdEncuesta").val(), oper: 'nuevaPagina'},
            beforeSend: function () {
                $("#respuestaPag").html("Cargando ... ");
            },
            success: function (response) {
                if (!isNaN(response)) {
                    $("#respuestaPag").html("");
                    $("#mlPreguntas").modal('hide');
                    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'preguntasXEncuesta'}, function (resultado) {
                        $("#disenioEncuesta").html(resultado);
                    });

                } else {
                    $("#respuestaPag").html(response);
                }

            },
            error: function (xhr, status, error) {
                var error = formatErrorMessage(xhr, error);
                $("#respuestaPag").html(error);
            }
        });
    });

    $("#formNuevaPregunta").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            txtNroPreg: "required",
            cbTipoPregunta: "required",
            txtPregunta: {
                required: function (element) {
                    return ($("#cbTipoPregunta").val() != "10");
                }
            }

        },
        messages: {
            txtNroPreg: "Ingrese Nro de Pregunta",
            cbTipoPregunta: "Ingrese tipo de pregunta",
            txtPregunta: "Ingrese Pregunta"
        },
        submitHandler: function (form) {
            $("#respuestaPreg").html("");
            var nroPag = $("#pagina").val();
            $.ajax({
                url: "Negocios/preguntas.php",
                type: "POST",
                data: $(form).serialize(),
                beforeSend: function () {
                    $("#respuestaPreg" + nroPag).html("Cargando ... ");
                },
                success: function (response) {
                    if (!isNaN(response)) {
                        $("#verOpciones").html("");
                        $("#mlPreguntas").modal('hide');
                        $("#cbTipoPregunta").val("");
                        $("#txtPregunta").val("");
                        $("#respuestaPreg").html("");
                        $("#cbDiferenciales").val("");
                        $("#cbFormato").val("");
                        $("#cbEscala").val("");
                        $("#txtMin").val("");
                        $("#txtMax").val("");
                        cargarPreguntas();

                    } else {
                        $("#respuestaPreg").html(response);
                    }

                },
                error: function (xhr, status, error) {
                    var error = formatErrorMessage(xhr, error);
                    $("#respuestaPreg").html(error);
                }
            });

        }

    });



    $("#formTituloPagina").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
                    txtTituloPag: "required"
                },
        messages: {
            txtTituloPag: "Ingrese T&iacute;tulo"
        },
        submitHandler: function (form) {
            $("#respuestaPag").html("");
            $.ajax({
                url: "Negocios/encuestas.php",
                type: "POST",
                data: $(form).serialize(),
                beforeSend: function () {
                    $("#respTitPag").html("Cargando ... ");
                },
                success: function (response) {
                    if (!isNaN(response)) {
                        $("#txtTituloPag").val("");
                        $("#mlPagina").modal('hide');
                        $("#respTitPag").html("");
                        
                        $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'preguntasXEncuesta'}, function (resultado) {
                            $("#disenioEncuesta").html(resultado);
                        });

                    } else {
                        $("#respTitPag").html(response);
                    }

                },
                error: function (xhr, status, error) {
                    var error = formatErrorMessage(xhr, error);
                    $("#respTitPag").html(error);
                }
            });

        }

    });


    $("#formModifPregunta").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
                rules: {
                    txtPregunta: "required"

                },
        messages: {
            txtPregunta: "Ingrese Pregunta"
        },
        submitHandler: function (form) {
            $("#respuestaPag").html("");
            $("#respuestaPregM").html("");
            var nroPag = $("#pagina").val();
            $.ajax({
                url: "Negocios/preguntas.php",
                type: "POST",
                data: $(form).serialize(),
                beforeSend: function () {
                    $("#respuestaPregM").html("Cargando ... ");
                },
                success: function (response) {
                    //alert(response);
                    if (!isNaN(response)) {
                   
                        $("#verOpcionesM").html("");
                        $("#mlModifPreguntas").modal('hide');
                        $("#respuestaPregM").html("");
                        $("#hdIdPregModif").val("");
                        $("#hdIdTipoPreg").val("");
                        $("#cbDiferencialesM").val("");                        
                        $("#cbFormatoM").val("");
                        $("#cbEscalaM").val("");
                        $("#txtMinM").val("");
                        $("#txtMaxM").val("");
                        cargarPreguntas();

                    } else {
                        $("#respuestaPregM").html(response);
                    }

                },
                error: function (xhr, status, error) {
                    var error = formatErrorMessage(xhr, error);
                    $("#respuestaPregM").html(error);
                }
            });

        }

    });


});