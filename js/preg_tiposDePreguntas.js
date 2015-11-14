function NuO_multipleUnaOpcion(tipo, texto, orden){
	var viform ="";
        
	viform = '<div class="row">'+
		       '<div class="col-md-1 text-right">'+
			   '               <input type="radio" name="optionsRadios">'+
			   '		  </div>'+
                '		  <div class="col-md-8">'+
                '		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
                '					name="opcionPregunta[]" type="text"  value="'+ texto +'" placeholder="Ingrese el texto de la opci&oacute;n" />'+
                '		  </div>'+
                                ' <div class="col-md-1 orop">'+
		'		   <input class="form-control input-sm" style="padding-left:5px;padding-right:2px;" maxlength="2" id="OrdenOpcion[]" '+
		'		     name="OrdenOpcion[]" type="text" value="'+ orden +'" /> </div>' +
                '		 <div class="col-md-2">'+
                '		  <a class="red" style="font-size:1.4em">'+
                '		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
                '			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarOpciones("'+ tipo +'");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
                '		 </div>'+
                '		</div>';
	return viform;
}

function NuO_dicotmica(texto1,texto2){
    //alert(texto2);
    var viform ="";
    viform = '<div class="row">'+
                   '<div class="col-md-1 text-right">'+
                       '               <input type="radio" name="optionsRadios">'+
                       '		  </div>'+
            '		  <div class="col-md-8">'+
            '		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
            '					name="opcionPregunta[]" type="text"  value="'+ texto1 +'" placeholder="Ingrese el texto de la opci&oacute;n" />'+
            '		  </div>'+
            '		</div>';
    viform += '<div class="row">'+
                   '<div class="col-md-1 text-right">'+
                       '               <input type="radio" name="optionsRadios">'+
                       '		  </div>'+
            '		  <div class="col-md-8">'+
            '		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
            '					name="opcionPregunta[]" type="text"  value="'+ texto2 +'" placeholder="Ingrese el texto de la opci&oacute;n" />'+
            '		  </div>'+
            '		</div>';
    return viform;
}


function NuO_multipleVariasOpciones(tipo,texto){
	var viform ="";
	viform = '<div class="row">'+
		       '<div class="col-md-1 text-right">'+
			   '               <input type="checkbox" name="optionsCheck">'+
			   '		  </div>'+
				'		  <div class="col-md-8">'+
				'		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
				'					name="opcionPregunta[]" type="text" value="'+ texto+'"  placeholder="Ingrese el texto de la opci&oacute;n" />'+
				'		  </div>'+
				'		 <div class="col-md-2">'+
				'		  <a class="red" style="font-size:1.4em">'+
				'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
				'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarOpciones("'+ tipo +'");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
				'		 </div>'+
				'		</div>';
	return viform;
}

function NuO_multipleTexto(tipo){
	var viform ="";
	viform = '<div class="row">'+		      
				'		  <div class="col-md-8">'+
				'		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
				'					name="opcionPregunta[]" type="text"  placeholder="Ingrese el etiqueta para el cuadro de texto " />'+
				'		  </div>'+
				'		 <div class="col-md-2">'+
				'		  <a class="red" style="font-size:1.4em">'+
				'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
				'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarOpciones("'+ tipo +'");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
				'		 </div>'+
				'		</div>';
	return viform;
}

function agregarFilas(){
	
	var nuFila ="";
	nuFila ='<div class="row">' +
	'		  <div class="col-md-8">'+
	'		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
	'					name="opcionPregunta[]" type="text"  placeholder="Ingrese el texto de la opci&oacute;n" />'+
	'		  </div>'+
	'		 <div class="col-md-2">'+
	'		  <a class="red" style="font-size:1.4em">'+
	'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
	'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarFilas();\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
	'		 </div>'+
	'</div>';
	$("#filas").append(nuFila);
}


function agregarColumnas(conValor){
	
	var nuCol ="";
	nuCol ='<div class="row">' +
	'		  <div class="col-md-8">'+
	'		  		<input class="form-control input-sm" id="columnasPregunta[]" '+
	'					name="columnasPregunta[]" type="text"  placeholder="Ingrese el texto de la columna" />'+
	'		  </div>';
	
	if(conValor == "1"){
		nuCol +=' <div class="col-md-2">'+
		'		  		<input class="form-control input-sm" id="valorPregunta[]" '+
		'					name="valorPregunta[]" type="text" />'+
		'		  </div>';
		nuCol +='<div class="col-md-2">'+
		'		  <a class="red" style="font-size:1.4em">'+
		'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
		'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarColumnas(1);\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
		'		 </div>'+
		'		</div>';
	}
	else{
	nuCol +=' <div class="col-md-2" style="display:none;">'+
	'		  		<input class="form-control input-sm" id="valorPregunta[]" '+
	'					name="valorPregunta[]" type="text" style="display:none;" value="1" />'+
	'		  </div>';
	nuCol +='<div class="col-md-2">'+
	'		  <a class="red" style="font-size:1.4em">'+
	'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
	'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarColumnas();\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
	'		 </div>'+
	'		</div>';
	}
	$("#columnas").append(nuCol);
}

function NuO_escalaValoracion(tipo){
	var viform ="";
	viform = '<div class="row"><div class="col-md-12">' +
			'<div class="form-group">' +
			'<label class="text-left">Filas:</label>' +
			'</div></div></div>' +
			'<div id="filas"><div class="row">' +
			'		  <div class="col-md-8">'+
			'		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
			'					name="opcionPregunta[]" type="text"  placeholder="Ingrese el texto de la opci&oacute;n" />'+
			'		  </div>'+
			'		 <div class="col-md-2">'+
			'		  <a class="red" style="font-size:1.4em">'+
			'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
			'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarFilas();\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
			'		 </div>'+
			'</div></div>';
	viform += '<div class="row">&nbsp;</div><div class="row"><div class="col-md-12">' +
	'<div class="form-group">' +
	'<label class="text-left">Columnas:</label>' +
	'</div></div></div>' +
	'<div id="columnas"><div class="row">' +
	'		  <div class="col-md-8">'+
	'		  		<input class="form-control input-sm" id="columnasPregunta[]" '+
	'					name="columnasPregunta[]" type="text"  placeholder="Ingrese el texto de la columna" />'+
	'		  </div>'+
	'		  <div class="col-md-2">'+
	'		  		<input class="form-control input-sm" id="valorPregunta[]" '+
	'					name="valorPregunta[]" maxlength="2" type="text"  value="1" />'+
	'		  </div>'+
	'		 <div class="col-md-2">'+
	'		  <a class="red" style="font-size:1.4em">'+
	'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
	'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarColumnas(1);\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
	'		 </div>'+
	'		</div></div>';
	return viform;
}

function NuO_matriz(tipo){
	var viform ="";
	viform = '<div class="row"><div class="col-md-12">' +
			'<div class="form-group">' +
			'<label class="text-left">Filas:</label>' +
			'</div></div></div>' +
			'<div id="filas"><div class="row">' +
			'		  <div class="col-md-8">'+
			'		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
			'					name="opcionPregunta[]" type="text"  placeholder="Ingrese el texto de la opci&oacute;n" />'+
			'		  </div>'+
			'		 <div class="col-md-2">'+
			'		  <a class="red" style="font-size:1.4em">'+
			'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
			'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarFilas();\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
			'		 </div>'+
			'</div></div>';
	viform += '<div class="row">&nbsp;</div><div class="row"><div class="col-md-12">' +
	'<div class="form-group">' +
	'<label class="text-left">Columnas:</label>' +
	'</div></div></div>' +
	'<div id="columnas"><div class="row">' +
	'		  <div class="col-md-8">'+
	'		  		<input class="form-control input-sm" id="columnasPregunta[]" '+
	'					name="columnasPregunta[]" type="text"  placeholder="Ingrese el texto de la columna" />'+
	'		  </div>'+
	'		 <div class="col-md-2">'+
	'		  <a class="red" style="font-size:1.4em">'+
	'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
	'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarColumnas(0);\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
	'		 </div>'+
	'		</div></div>';
	return viform;
}


function agregarOpcion(texto,tipo,divTarget,orden,escala){
	//alert(escala);
	var viform ="";
        
        if(orden == "null" || orden == "" || orden == null)
        {
            orden = "";
        }
	viform = '<div class="row">';
	if(tipo != ""){
		viform += '<div class="col-md-1 text-right">'+
			   		'<input type="'+tipo+'" name="optionsRadios"></div>';
	}
	
	viform +='<div class="col-md-7">'+
	'	<input class="form-control input-sm" id="opcionPregunta[]" '+
	'		name="opcionPregunta[]" type="text"  value="'+ texto +'" placeholder="Ingrese el texto de la opci&oacute;n" />'+
	'</div>'+
                ' <div class="col-md-1 orop">'+
		'		   <input class="form-control input-sm" style="padding-left:5px;padding-right:2px;" id="OrdenOpcion[]" '+
		'		     name="OrdenOpcion[]" maxlength="2" type="text" value="'+ orden +'" /> </div>' +
	'<div class="col-md-2">'+
	' <a class="red" style="font-size:1.4em">'+
	'  <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
	' <a class="green" style="font-size:1.4em" href="#" onclick=\'agregarOpcion("","'+ tipo +'","'+ divTarget + '","'+ orden + '","'+ escala + '");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
	'</div>'+
	'</div>';
	$("#"+divTarget).append(viform);
        
        if(escala == 1) $(".orop").hide();
            
}


function agregarColumna(texto,conValor,divTarget){
	//alert(conValor);
	var nuCol ="";
	nuCol ='<div class="row">' +
	'		  <div class="col-md-8">'+
	'		  		<input class="form-control input-sm" id="columnasPregunta[]" '+
	'					name="columnasPregunta[]" value="'+ texto +'" type="text"  placeholder="Ingrese el texto de la columna" />'+
	'		  </div>';
	
	if(conValor != ""){
		nuCol +=' <div class="col-md-2">'+
		'		  		<input class="form-control input-sm" id="valorPregunta[]" '+
		'					name="valorPregunta[]" maxlength="2" value="'+ conValor +'" type="text" />'+
		'		  </div>';
	}
	
	nuCol +='<div class="col-md-2">'+
	'		  <a class="red" style="font-size:1.4em">'+
	'		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
	'			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarColumna("","' + conValor + '","'+ divTarget +'");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
	'		 </div>'+
	'		</div>';
	
	$("#"+divTarget).append(nuCol);
}

function NuO_escalaDF(tipo, texto1, texto2){
	var viform ="";
        
	viform = '<div class="row">'+
                '		  <div class="col-md-4">'+
        '		  		<input class="form-control input-sm" id="opcionPregunta[]" '+
        '					name="opcionPregunta[]" type="text"  value="'+ texto1 +'" placeholder="Adjetivo de Menor Valor" />'+
                '		  </div>'+
                 '              <div class="col-md-4">'+
        '		  		<input class="form-control input-sm" id="opcion2Pregunta[]" '+
        '					name="opcion2Pregunta[]" type="text" value="'+ texto2 +'" placeholder="Adjetivo de Mayor Valor" />'+
                '		  </div>'+
                '		 <div class="col-md-2">'+
                '		  <a class="red" style="font-size:1.4em">'+
                '		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
                '			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarOpciones("'+ tipo +'");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
                '		 </div>'+
                '		</div>';
	return viform;
}

function agregarOpcionDF(texto1,texto2,divTarget){
	
	var viform ="";
        
        viform = '<div class="row">'+
                    '<div class="col-md-4">'+
                        '<input class="form-control input-sm" id="opcionPregunta[]" '+
                        ' name="opcionPregunta[]" type="text"  value="'+ texto1 +'" placeholder="Adjetivo de Menor Valor" />'+
                    '</div>'+
                    '<div class="col-md-4">'+
                        '<input class="form-control input-sm" id="opcion2Pregunta[]" '+
                        ' name="opcion2Pregunta[]" type="text" value="'+ texto2 +'" placeholder="Adjetivo de Mayor Valor" />'+
                    '</div>'+
                '		 <div class="col-md-2">'+
                '		  <a class="red" style="font-size:1.4em">'+
                '		      <i class="glyphicon glyphicon-minus-sign" href="#" onclick="quitarOpcion(this);"></i></a>'+
                '			<a class="green" style="font-size:1.4em" href="#" onclick=\'agregarOpcionDF("","","'+ divTarget +'");\'><i class="glyphicon glyphicon-plus-sign"></i></a>'+		
                '		 </div>'+
                '		</div>';
        
	$("#"+divTarget).append(viform);
}
