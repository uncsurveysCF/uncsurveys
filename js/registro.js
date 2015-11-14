/**
 * Validacion de perfil de usuario
 */
$(document).ready(function() { 
	
	
	$("#formRegistro").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		txtApellido: "required",
    		txtNombre: "required",
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
			txtEmail: {
				required: true,
				email: true
			}
    		},
    	messages: {
    		txtApellido: "Ingrese Apellido",
    		txtNombre: "Ingrese Nombre",
    		txtPass: {
				required: "Ingrese su contrase&ntilde;a",
				minlength: "Su contrase&ntilde;a debe tener al menos 5 caracteres"
			},
			txtRPass: {
				required: "Ingrese su contrase&ntilde;a",
				minlength: "Su contrase&ntilde;a debe tener al menos 5 caracteres",
				equalTo: "La contrase&ntilde;a no coincide"
			},
			txtEmail: {required: "Ingrese Email",
                                    email: "Email Invalido"
                            },
			txtUsuario: {
				required: "Ingrese su usuario",
				minlength: "Su nombre se usuario debe tener al menos 4 caracteres"
					}
    	},
    	
    	submitHandler: function(form) {
    		$.ajax({
                     url: "Negocios/usuarios.php",
                     type:"post",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuestaReg").html("Cargando ... ");
                     },
                     success:  function (response) {
                    	 if(response == "1"){
                            $("#respuestaReg").html("<div class='alert alert-success'><button class='close' data-dismiss='alert' " +
              	        	 		" type='button'>x</button><strong></strong>Su cuenta se ha creado exitosamente!</div>");
                    	 }else{
                            $("#respuestaReg").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' " +
              	        	 		" type='button'>x</button><strong></strong>" + response +"</div>"); 
                    	 }
                     },
         	        error: function(xhr, status, error){		   	        	
         	        	var error = formatErrorMessage(xhr, error);
         	        	 $("#respuestaReg").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert' " +
         	        	 		" type='button'>x</button><strong></strong>" + error +"</div>");
         			}    
             });
    		
    	}
    		
	});
	
	
});