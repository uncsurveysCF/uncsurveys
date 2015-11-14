$(document).ready(function() {    	
    
	$("#formCambiarClave").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		txtUsuario: {
                    required: true,
                    minlength: 4
                },
                txtPass: {
                    required: true,
                    minlength: 5
                },
                txtRPass: {
                    required: true,
                    minlength: 5,
                    equalTo: "#txtPass"
                },		
    		},
    	messages: {
    		txtPass: {
                    required: "Ingrese su contrase&ntilde;a",
                    minlength: "Su contrase&ntilde;a debe tener al menos 5 caracteres"
                },
                txtRPass: {
                    required: "Ingrese su contrase&ntilde;a",
                    minlength: "Su contrase&ntilde;a debe tener al menos 5 caracteres",
                    equalTo: "La contrase&ntilde;a no coincide"
                },
                txtUsuario: {
                    required: "Ingrese su usuario",
                    minlength: "Su nombre se usuario debe tener al menos 4 caracteres"
                }	
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/usuarios.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                        $("#respuestaNueva").html("<img src='img/ajax-loaders/ajax-loader-6.gif' title='img/ajax-loaders/ajax-loader-6.gif'>");
                     },
                     success:  function (response) {
                        $("#respuestaNueva").html("");
                       //alert(response);
                      if(!isNaN(response)) {
                        $("#btnCambiarCave").hide();  
                    	$("#respuestaNueva").html("<div class='alert alert-success'><button class='close' data-dismiss='alert' " +
              	        	 		" type='button'>x</button><strong></strong>Su contrase&ntilde;a ha sido modificada!</div>")
            		      
                       } 
                       else{
                        $("#respuestaNueva").html(response);
                       }    
                     },
         	     error: function(xhr, status, error){		   	        	
                        var error = formatErrorMessage(xhr, error);
                         $("#respuestaNueva").html(error);
                    }    
             });
    		
    	}
    		
	});
	
});
