$(document).ready(function() {
	
 $.post("Negocios/encuestas.php", {oper:'listar' }, function(data){	 
	 $("#listadoDatos").html(data);
	 $("#tblEncuestas").dataTable({"ordering": false});
 });
		
});