$(document).ready(function() {   
		    
    if($("#hfIdEncuesta").val() !=""){
    	 $.post("Negocios/encuestas.php", { idEncuesta: $("#hfIdEncuesta").val(), oper:'verEncuesta' }, function(data){
    		 //alert(data);
    		 var respuesta = parseInt(data);
    		    if(isNaN(respuesta)){// como no es un numero, significa que devolvio un json
    		    	var datosEnc = JSON.parse(data);    		    	
    		    	$("#txtTitulo").html(datosEnc.Titulo);
    		    	$("#txtDescripcion").html(datosEnc.Descripcion);
    		    	
    		    }	 
    		 
    	 });
    }
    
    $.post("Negocios/grupos.php", { vdefaul: '...', selected:'0', oper:'combo' }, function(data){
     	$("#cbGrupos").html(data);
      });
    
    
    $("#formCompartir").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		cbGrupos: "required"
    		
    		},
    	messages: {
    		cbGrupos: "Seleccione el grupo con el que desea compartir"
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/encuestas.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuesta").html("Cargando ... ");
                     },
                     success:  function (response) {
                      $("#respuesta").html("");                      
                      if(!isNaN(response)) {
                    	   $("#respuesta").html("<div class='alert alert-success'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>"
                    				 + "La encuesta ya es accesible para el grupo " + $("#cbGrupos").text() + "</div>")
            		       $("#btnCompartir").hide();
                       } else{
                    	   
                    	   $("#respuesta").html(response);
                       }    
                     },
         	        error: function(xhr, status, error){		   	        	
         	        	var error = formatErrorMessage(xhr, error);
         	        	$("#respuesta").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>" +
         						error + "</div>");
         			}    
             });
    		
    	}
    		
	});
 
    
    
	});