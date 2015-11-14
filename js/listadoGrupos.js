
function activarEnGrupo(idGrupo,grupo,usuario){
    if(confirm("Esta seguro que desea formar parte de grupo " + grupo + "?")){
        $.post("Negocios/grupos.php", {oper:'acUsuGrupo', idGrupo: idGrupo, nomGrupo: grupo }, function(respuesta){
             //alert(respuesta);
             $.post("Negocios/grupos.php", {oper:'listadoMiembro' }, function(data){	 
                $("#listadoGruposComp").html(data);
                $("#tblGruposMiembro").dataTable();
            });
        });
    }
}

function dejarGrupo(idGrupo,grupo,usuario){
    if(confirm("Esta seguro que desea darse de baja del grupo " + grupo + "?")){
        $.post("Negocios/grupos.php", {oper:'delUsuGrupo', idGrupo: idGrupo, nomGrupo: grupo }, function(respuesta){
             //alert(respuesta);
             $.post("Negocios/grupos.php", {oper:'listadoMiembro' }, function(data){	 
                $("#listadoGruposComp").html(data);
                $("#tblGruposMiembro").dataTable();
            });
        });
    }
}

$(document).ready(function() {
	
 $.post("Negocios/grupos.php", {oper:'listadoAd' }, function(data){	 
	 $("#listadoDatos").html(data);
	 $("#tblGruposAdm").dataTable();
 });
 
 $.post("Negocios/grupos.php", {oper:'listadoMiembro' }, function(data){	 
	 $("#listadoGruposComp").html(data);
	 $("#tblGruposMiembro").dataTable();
 });

    
 
    
});