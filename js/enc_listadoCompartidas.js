$(document).ready(function() {
	
 $.post("Negocios/encuestas.php", {oper:'listarCompartidas' }, function(data){	 
	 $("#listadoDatos").html(data);
	 $("#tblEncuestas").dataTable();
 });
		
});