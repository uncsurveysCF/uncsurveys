/**
 * 
 */
$(document).ready(function(){
		 
    $('#formRecuperar').validate({
    rules:{
            txtUsuario : {
                required : true
            },
            txtCE:{
                required : true,
                email: true
            }
	},
    	 
    messages : {
	txtUsuario : {
            required : "Ingrese usuario"
           },
        txtCE : {
           required : "Ingrese Correo Electr&oacute;nico",
           email: "Email Inv&aacute;lido"
          }
	 },
	 
    submitHandler: function(form) {
        $("#BtnRecuperar").hide();
        $.ajax({
            url: "Negocios/usuarios.php",
            type: form.method,
            data: $(form).serialize(),
            beforeSend: function () {
                $("#divResp").show();
              	$("#divResp").html("<img src='img/ajax-loaders/ajax-loader-6.gif' title='img/ajax-loaders/ajax-loader-6.gif'>");
            },
            success: function(response) {
                //alert(response);
            	if(response == "1"){
                    $("#divResp").show();
                    $("#divResp").html("<div class='alert alert-success'><button class='close' data-dismiss='alert' " +
              	    " type='button'>x</button><strong></strong>Se enviar&aacute; una nueva clave a su correo electr&oacute;nico!</div>");
                }
            	else{
                    $("#BtnRecuperar").show();
                    $("#divResp").show();
              	    $("#divResp").html(response);
            	}
            	            	                
            },
	        error: function(xhr, status, error){		   	        	
	        	var error = formatErrorMessage(xhr, error);
	        	 $("#divResp").show();
                         $("#divResp").html(error);
			}  
            
        });
    }

 });
});

