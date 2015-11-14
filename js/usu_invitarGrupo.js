$(document).ready(function() {   
		
   
    
    if($("#hfIdGrupo").val() !=""){
    	 $.post("Negocios/grupos.php", { idGrupo: $("#hfIdGrupo").val(), oper:'ver'}, function(data){
    		
    		 var respuesta = parseInt(data);
    		    if(isNaN(respuesta)){// como no es un numero, significa que devolvio un json
    		    	var datosEnc = JSON.parse(data);    		    	
    		    	$("#txtGrupo").html(datosEnc.Nombre);
    		    	$("#txtDescripcion").html(datosEnc.Descripcion);
                        $("#txtNomGrupo").val(datosEnc.Nombre);
    		    	
    		    	
    		    	 $.post("Negocios/grupos.php", {oper:'listarIntegrantes', idGrupo: $("#hfIdGrupo").val(), soloVer: "1" }, function(data){	 
    		    		 $("#listadoIntegrantes").html(data);
    		    	 });
    		    	
    		    }	 
    		 
    	 });
    }
    
    $("#formInvitar").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		txtemail: {
				required: true,
				email: true
			}
    		
    		},
    	messages: {
    		txtemail: {
                        required: "Ingrese email",
                        email: "Ingrese un email valido"
                                }
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/grupos.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuesta").html("Cargando ... ");
                     },
                     success:  function (response) {
                      
                      if(!isNaN(response)) {
                          $("#respuesta").html("");
                    	  $("#txtemail").val("");
                    	  $.post("Negocios/grupos.php", {oper:'listarIntegrantes', idGrupo: $("#hfIdGrupo").val(), soloVer: "1" }, function(data){	 
         		    	$("#listadoIntegrantes").html(data);
         		   });
                    	  
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