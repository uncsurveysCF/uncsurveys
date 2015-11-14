$(document).ready(function() {  

	//--------------- Tabs ------------------//
    $('#tabsNuevaEncuesta a').click(function (e) {
	  	e.preventDefault();
	  	$(this).tab('show');
	});
    
    $.post("Negocios/tiposEncuestas.php", { vdefaul: '...', selected:'0', oper:'combo' }, function(data){
     	$("#cbTipoEncuesta").html(data);
      });

    $.post("Negocios/temas.php", { vdefaul: '...', selected:'0', oper:'combo' }, function(data){
     	$("#cbTema").html(data);
      });
    
    $("#btnPreguntas").click(function(){
    	window.location="enc_diseniarEncuesta.php?id="+$("#hdIdEnc").val();
    });
    
    $("#btnPreguntasCopia").click(function(){
    	window.location="enc_diseniarEncuesta.php?id="+$("#hdIdEncCopia").val();
    });
    
    $.post("Negocios/encuestas.php", { vdefaul: '...', selected:'0', oper:'combo' }, function(data){
     	$("#cbMisEnc").html(data);
      });
        
    
    $("#cbMisEnc").change(function () {
        $("#cbMisEnc option:selected").each(function () {
         var enc=$(this).text();        
         $("#txtTituloCopia").val(enc + " - Copia ");
     });
    });    
    
    
    
    $.post("Negocios/tiposEncuestas.php", { oper:'listado' }, function(data){     	
    	var resp = parseInt(data);
		    if(isNaN(resp)){// como no es un numero, significa que devolvio un json
		    	
		    	var tipos = JSON.parse(data);
		    	var i;
		    	var contenido ="<dl>";
		    	
		    	for(i in tipos)
		    	{
		    		contenido +="<dt style='font-size:small;'>"+tipos[i].Descripcion+"</dt>" +
		    					"<dd style='font-size:x-small;'>"+tipos[i].Observaciones+"</dd>";
		    	}
		    	contenido +="</dl>";
		    	//alert(contenido);
		    	$('#lisTipos').popover({
		    		title : 'Tipos de Encuestas',
		    	    html: true,
		    		content: contenido
		    	});
		    }
      });
    
	$("#formNuevaEnc").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		cbTema: "required",
    		cbTipoEncuesta: "required",
    		txtTitulo: "required"
    		
    		},
    	messages: {
    		cbTema: "Ingrese Tema",
    		cbTipoEncuesta: "Ingrese Tipo de Encuesta",
    		txtTitulo: "Ingrese T&iacute;tulo"    		
    	},
    	
    	submitHandler: function(form) {
    		
            $.ajax({
                     url: "Negocios/encuestas.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuestaNueva").html("Cargando ... ");
                     },
                     success:  function (response) {
                       $("#respuestaNueva").html("");
                       //alert(response);
                      if(!isNaN(response)) {                   	   
                   	   	$("#respuestaNueva").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
														"Ha ocurrido un error al intentar cargar los datos de la encuesta</div>");
                       } else{ 
                    	   $("#hdIdEnc").val(response);
                    	   $("#respuestaNueva").html("<div class='form-group has-success col-md-10'>" +
            		       "<input type='text' class='form-control' id='success' readonly value='Los datos se cargaron correctamente'></div>")
            		       $("#btnGuardar").hide();
                    	   $("#btnPreguntas").show();
                    	   
                       }    
                     },
         	     error: function(xhr, status, error){		   	        	
                        var error = formatErrorMessage(xhr, error);
                         $("#respuestaNueva").html(error);
                        }    
             });
    		
    	}
    		
	});
	
	
	$("#formNuevaEncCopia").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		cbMisEnc: "required",
    		txtTituloCopia: "required"
    		
    		},
    	messages: {
    		cbMisEnc: "Selecciones una encuesta",
    		txtTituloCopia: "Ingrese T&iacute;tulo"    		
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/encuestas.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuestaCopia").html("Cargando ... ");
                     },
                     success:  function (response) {
                       $("#respuestaCopia").html("");
                       //alert(response);
                      if(!isNaN(response)) {
                    	   $("#hdIdEncCopia").val(response);
                    	   $("#respuestaCopia").html("<div class='form-group has-success col-md-10'>" +
            		       "<input type='text' class='form-control' id='success' readonly value='Los datos se cargaron correctamente'></div>")
            		       $("#btnGuardar").hide();
                    	   $("#btnPreguntasCopia").show();
                       } else{
                    	   
                    	   $("#respuestaCopia").html(response);
                       }    
                     },
         	        error: function(xhr, status, error){		   	        	
         	        	var error = formatErrorMessage(xhr, error);
         	        	 $("#respuestaCopia").html(error);
         			}    
             });
    		
    	}
    		
	});
	
	
});