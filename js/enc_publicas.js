function validarTag(tag) {
    if (tag.length > 50)
        return false;
    return true;
}

$(document).ready(function() {
	
        $.post("Negocios/temas.php", {vdefaul: '...', selected:"", oper: 'combo'}, function (data) {
            $("#cbTema").html(data);
        });
        $.post("Negocios/tiposEncuestas.php", {vdefaul: '...', selected: "", oper: 'combo'}, function (data) {
            $("#cbTipoEnc").html(data);
        });
        
        
    $.post("Negocios/encuestas.php", {oper:'listarPublicas' }, function(data){	 
        //alert(data);
        $("#listadoDatos").html(data);
        $("#tblEncuestas").dataTable();
    });
		
});


