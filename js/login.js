/**
 * 
 */
$(document).ready(function(){
		 
    $('#formLogin').validate({
    rules:{
		txtUsuario : {
			 required : true
	     },
		txtPass:{
			 required : true
	    }
	},
    	 
	 messages : {
		 txtUsuario : {
	      required : "Ingrese usuario."
	     },
		txtPass : {
	     required : "Ingrese Contrase&ntilde;a."
	    }
	 },
	 
	 submitHandler: function(form) {
        $.ajax({
            url: "Negocios/validarLogin.php",
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
            	if(response == "1")
            		window.location='enc_listadoEncuestas.php';
            	else{
            		$("#divResp").show();
              	    $("#respuesta").val(response);
            	}
            	            	                
            },
	        error: function(xhr, status, error){		   	        	
	        	var error = formatErrorMessage(xhr, error);
	        	 $("#divResp").show();
           	     $("#respuesta").val(error);
			}  
            
        });
    }

 });
});