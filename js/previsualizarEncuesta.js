function formatErrorMessage(jqXHR, exception) {
    if (jqXHR.status === 0) {
        return ('No hay conexion');
    } else if (jqXHR.status == 404) {
        return ('No se ha encontrado la pagina buscada [404]');
    } else if (jqXHR.status == 500) {
        return ('Error Interno [500].');
    } else if (exception === 'parsererror') {
        return ('Error al obneter los datos');
    } else if (exception === 'timeout') {
        return ('Tiempo de espera agotado');
    } else if (exception === 'abort') {
        return ('Solicitud Abortada');
    } else {
        return ('Error:\n' + jqXHR.responseText);
    }
}


function precargarDatos() {
    $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verEncuesta'}, function (data) {
        //alert(data);
        var respuesta = parseInt(data);
        if (isNaN(respuesta)) {// como no es un numero, significa que devolvio un json
            var datosEnc = JSON.parse(data);

            $("#txtTitulo").html(datosEnc.Titulo);
            $("#divDescripcion").html(datosEnc.Descripcion);

            if((datosEnc.TieneClave == "1") || (datosEnc.tieneIdentificadores == "1"))
            {
                $("#divClave").show();
                 $("#divEncuesta").hide(); 
            }else{
                $("#divClave").hide();
                $("#divEncuesta").show();
            }

            if ((datosEnc.TieneClave == "1")) 
            {
                $("#hfClaveAcceso").val($.md5(datosEnc.ClaveAcceso));
                $("#pnlClaveAcc").show(); 
            } else {                
                $("#pnlClaveAcc").hide(); 
            }
            
            if(datosEnc.tieneIdentificadores == "1")
            {                
                $("#hfIdAcceso").val("1");
                $("#ingIdes").show();
            }else{
                $("#hfIdAcceso").val("0");
                $("#ingIdes").hide();
            }
            
            
            /***** CAGAR NAVEGADOR ******************/
            $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'pagXEnc'}, function (paginas) {
                var navegador = "";
                var respPag = parseInt(paginas);
                if (isNaN(respPag)) {// como no es un numero, significa que devolvio un json
                    var arrayspaginas = JSON.parse(paginas);
                    /***** CARGAR ENCUESTA ******************/

                    if (arrayspaginas.length > 1)
                    {
                        navegador += "<ul>";
                        for (x in arrayspaginas) {
                            navegador += "<li><a href='#pagina" + arrayspaginas[x].NroPagina + "' data-toggle='tab'>P&aacute;gina " +
                                    arrayspaginas[x].NroPagina + "</a></li>";
                        }
                        navegador += "</ul>";

                        $("#navegador").html(navegador);
                        //$("#navegador").hide();
                        $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verParaRecopilar'}, function (encCompleta)
                        {
                            $("#contenidoEncuesta").addClass("tab-content");
                            $("#contenidoEncuesta").html(encCompleta);
                            $(".fecha").datepicker();
                            $("#contenidoEncuesta").append("<ul class='pager wizard'>" +
                                    "<li class='previous'><a href='javascript:;'>Anterior</a></li>" +
                                    "<li class='next'><a href='javascript:;'>Siguiente</a></li>" +
                                    "<li class='next finish red' style='display:none;'><a href='javascript:;'>Enviar</a></li>" +
                                    "</ul>");


                            $('#rootwizard').bootstrapWizard({onTabShow: function (tab, navigation, index) {

                                    var $total = navigation.find('li').length;
                                    var $current = index + 1;
                                    var $percent = ($current / $total) * 100;

                                    // If it's the last tab then hide the last button and show the finish instead
                                    if ($current >= $total) {
                                        $('#rootwizard').find('.pager .next').hide();
                                        if ($("#hfop").val() == "0")
                                        {
                                            $('#rootwizard').find('.pager .finish').show();
                                            $('#rootwizard').find('.pager .finish').removeClass('disabled');
                                        }
                                    } else {
                                        $('#rootwizard').find('.pager .next').show();
                                        $('#rootwizard').find('.pager .finish').hide();

                                    }
                                },
                                onNext: function (tab, navigation, index) {
                                    if (!$("#formEncuesta").validationEngine('validate'))
                                    {
                                        return false;
                                    }
                                }
                            });
                            $('#rootwizard .finish').click(function () {
                                if ($("#formEncuesta").validationEngine('validate'))
                                {
                                   return false;
                                }
                            });

                            $('.tabs').bind('click', function (e) {
                                if($("#formEncuesta").validationEngine('validate'))
                                {
                                   return false;
                                }
                            });
                        });


                    }
                    else {
                        $("#rootwizard .navbar").hide();
                        $("#foNavegador").hide();
                        $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(), oper: 'verParaRecopilar'}, function (encCompleta) {
                            $("#contenidoEncuesta").html(encCompleta);
                            $("#contenidoEncuesta").append("<ul class='pager wizard'>" +
                                    "<li class='next finish red'><a href='#'>Enviar</a></li>" +
                                    "</ul>");
                            $(".finish").click(function () {
                                 if($("#formEncuesta").validationEngine('validate'))
                                {
                                   return false;
                                }  
                            });
                        });
                    }

                }

            });


        }

    });
}

$(function () {
    $("#formEncuesta").validationEngine({promptPosition : "topRight"});
    precargarDatos(); 
    $("#btnCheckEncuesta").click(function(){
       var seguir = true; 
        if($("#hfIdAcceso").val() == "1")
        {
            $.post("Negocios/encuestas.php", {idEncuesta: $("#hfIdEncuesta").val(),oper: 'comprobarIdentificador', ide:$("#txtIdentificacion").val()}, function (resultado) {
                 alert(resultado);
                if(resultado != "1")
                 {
                     seguir = false;
                     $("#msnResp").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                                   "La identificaci&oacute;n ingresada no es correcta</div>"); 
                 }else{
                     $("#hfIde").val($("#txtIdentificacion").val());
                     if($("#hfClaveAcceso").val() != "")
                    {
                        var claveIng = $("#txtClave").val();
                        if($("#hfClaveAcceso").val() != $.md5(claveIng)){
                           seguir = false;
                           $("#msnResp").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                                              "La clave ingresada no es correcta</div>"); 
                        }
                    }
                 }                 
                if(seguir)
                {            
                    $("#divEncuesta").show();
                    $("#divClave").hide();
                }
             });
        }else{       
            if($("#hfClaveAcceso").val() != "")
            {
                var claveIng = $("#txtClave").val();
                if($("#hfClaveAcceso").val() != $.md5(claveIng)){
                   seguir = false;
                   $("#msnResp").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
                                      "La clave ingresada no es correcta</div>"); 
                }
            }
            if(seguir)
            {            
                $("#divEncuesta").show();
                $("#divClave").hide();
            }
        }
        
  });
  
  
});

