$(document).ready(function() {    	
    
	$("#formNuevoGrupo").validate({
		ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
    		txtNombre: "required"    		
    		},
    	messages: {
    		txtNombre: "Ingrese Nombre del grupo" 		
    	},
    	
    	submitHandler: function(form) {
    		
    		$.ajax({
                     url: "Negocios/grupos.php",
                     type:"POST",
                     data: $(form).serialize(),
                     beforeSend: function () {
                         $("#respuestaNueva").html("Cargando ... ");
                     },
                     success:  function (response) {
                       $("#respuestaNueva").html("");
                       //alert(response);
                      if(!isNaN(response)) {
                    	   $("#respuestaNueva").html("<div class='form-group has-success col-md-10'>" +
            		       "<input type='text' class='form-control' id='success' readonly value='El grupo ha creado correctamente'></div>")
            		      
                       } else{
                    	   
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