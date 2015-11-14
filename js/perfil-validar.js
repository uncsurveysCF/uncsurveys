/**
 * Validacion de perfil de usuario
 */
$(document).ready(function() { 	
	
	$("#form-perfil").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		txtApellido: "required",
    		txtnombre: "required",
    		txtuser: {
				required: true,
				minlength: 4
			},
    		password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			txtemail: {
				required: true,
				email: true
			}
    		},
    	messages: {
    		txtApellido: "Ingrese Apellido",
    		txtnombre: "Ingrese Nombre",
    		password: {
				required: "Ingrese su contrase&ntilde;a",
				minlength: "Su contrase&ntilde;a debe tener al menos 5 caracteres"
			},
			confirm_password: {
				required: "Ingrese su contrase&ntilde;a",
				minlength: "Su contrase&ntilde;a debe tener al menos 5 caracteres",
				equalTo: "La contrase&ntilde;a no coincide"
			},
			txtemail: {
				required: "Ingrese email",
				email: "Ingrese un email valido"
					},
			txtuser: {
				required: "Ingrese su usuario",
				minlength: "Su nombre se usuario debe tener al menos 4 caracteres"
					}
    	},
    	
    	submitHandler: function(form) {
    		$.ajax({
                     url: "Negocios/guardarUsuario.php",
                     type:"post",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#lblRespuesta").html("Cargando ... ");
                     },
                     success:  function (response) {
                        alert(response);                  
                     },
         			error: function(xhr, status, error){
                     	$("#lblRespuesta").html("No se encontro la pagina buscada");
         			}
             });
    		
    	}
    		
	});
	
	
});