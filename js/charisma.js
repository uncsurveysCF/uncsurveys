$(document).ready(function () {
    //themes, change CSS with JS
    //default theme(CSS) is cerulean, change it if needed
    var defaultTheme = 'simplex';

    var currentTheme = $.cookie('currentTheme') == null ? defaultTheme : $.cookie('currentTheme');
    var msie = navigator.userAgent.match(/msie/i);
    $.browser = {};
    $.browser.msie = {};
    
    $('.navbar-toggle').click(function (e) {
        e.preventDefault();
        $('.nav-sm').html($('.navbar-collapse').html());
        $('.sidebar-nav').toggleClass('active');
        $(this).toggleClass('active');
    });

    var $sidebarNav = $('.sidebar-nav');

    // Hide responsive navbar on clicking outside
    $(document).mouseup(function (e) {
        if (!$sidebarNav.is(e.target) // if the target of the click isn't the container...
            && $sidebarNav.has(e.target).length === 0
            && !$('.navbar-toggle').is(e.target)
            && $('.navbar-toggle').has(e.target).length === 0
            && $sidebarNav.hasClass('active')
            )// ... nor a descendant of the container
        {
            e.stopPropagation();
            $('.navbar-toggle').click();
        }
    });

    //highlight current / active link
    $('ul.main-menu li a').each(function () {
        if ($($(this))[0].href == String(window.location))
            $(this).parent().addClass('active');
    });

    //establish history variables
    var
        History = window.History, // Note: We are using a capital H instead of a lower h
        State = History.getState(),
        $log = $('#log');

    //bind to State Change
    History.Adapter.bind(window, 'statechange', function () { // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
        $.ajax({
            url: State.url,
            success: function (msg) {
                $('#content').html($(msg).find('#content').html());
                $('#loading').remove();
                $('#content').fadeIn();
                var newTitle = $(msg).filter('title').text();
                $('title').text(newTitle);
                docReady();
            }
        });
    });

   
    $('.accordion > a').click(function (e) {
        e.preventDefault();
        var $ul = $(this).siblings('ul');
        var $li = $(this).parent();
        if ($ul.is(':visible')) $li.removeClass('active');
        else                    $li.addClass('active');
        $ul.slideToggle();
    });

    $('.accordion li.active:first').parents('ul').slideDown();


    $('.datatable').dataTable({
        "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-12'i><'col-md-12 center-block'p>>",
        "sPaginationType": "bootstrap",
        "bFilter": false,    	            			
        "sLengthMenu": [2, 10, 25, 50, 100 ],
        "oLanguage": {
        	"sProcessing": "Procesando...",
        	"sLengthMenu": "Mostrar _MENU_ registros",
        	"sZeroRecords": "No se encontraron resultados",
        	"sEmptyTable": "No se encontraron registros",
        	"sInfo": "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
        	"sInfoEmpty": "0 registros encontrados",
        	"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        	"sInfoPostFix": "",
        	"sSearch": "Buscar:",
        	"sUrl": "",
        	"sInfoThousands": ",",
        	"sLoadingRecords": "Cargando...",
        	"oPaginate": {
        	"sFirst": "<<",
        	"sLast": ">>",
        	"sNext": ">",
        	"sPrevious": "<"
        	},
        	"oAria": {
        	"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        	"sSortDescending": ": Activar para ordenar la columna de manera descendente"
        	}
        	}
    });
    
    $.validator.addMethod("anyDate",
    	    function(value, element) {
    	        return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
    	    },
    	    "Ingrese una Fecha Valida (dd/mm/aaaa)"
    	);
    
    
    //other things to do on document ready, separated for ajax calls
    docReady();
});

function formatErrorMessage(jqXHR, exception) {
    if (jqXHR.status === 0) {
        return ('No hay conexion');
    } else if (jqXHR.status == 404) {
        return ('No se ha encontrado la pagina buscada [404]');
    } else if (jqXHR.status == 500) {
        return ('Error Interno [500].');
    } else if (exception === 'parsererror') {
        return ('Error al obneter los datos');
    } else if (exception === 'timeout') {
        return ('Tiempo de espera agotado');
    } else if (exception === 'abort') {
        return ('Solicitud Abortada');
    } else {
        return ('Error:\n' + jqXHR.responseText);
    }
}

function docReady() {
   
    //datatable
    $('.datatable').dataTable({
        "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-12'i><'col-md-12 center-block'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page"
        }
    });
    $('.btn-close').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().fadeOut();
    });
    $('.btn-minimize').click(function (e) {
        e.preventDefault();
        var $target = $(this).parent().parent().next('.box-content');
        if ($target.is(':visible')) $('i', $(this)).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        else                       $('i', $(this)).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        $target.slideToggle();
    });
   
  //popover
   
}


//additional functions for data table
$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
    return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    };
}

$.extend( $.fn.dataTable.defaults, {
    "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-12'i><'col-md-12 center-block'p>>",
    "sPaginationType": "bootstrap",
     "bFilter": false,    	            			
	 "sLengthMenu": [2, 10, 25, 50, 100 ],
     "oLanguage": {
    	"sProcessing": "Procesando...",
    	"sLengthMenu": "Mostrar _MENU_ registros",
    	"sZeroRecords": "No se encontraron resultados",
    	"sEmptyTable": "No se encontraron resultados",
    	"sInfo": "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
    	"sInfoEmpty": "",
    	"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    	"sInfoPostFix": "",
    	"sSearch": "Buscar:",
    	"sUrl": "",
    	"sInfoThousands": ",",
    	"sLoadingRecords": "Cargando...",
    	"oPaginate": {
    	"sFirst": "<<",
    	"sLast": ">>",
    	"sNext": ">",
    	"sPrevious": "<"
    	},
    	"oAria": {
    	"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
    	"sSortDescending": ": Activar para ordenar la columna de manera descendente"
    	}
    	}
});


$.extend($.fn.dataTableExt.oPagination, {
    "bootstrap": {
        "fnInit": function (oSettings, nPaging, fnDraw) {
            var oLang = oSettings.oLanguage.oPaginate;
            var fnClickHandler = function (e) {
                e.preventDefault();
                if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                    fnDraw(oSettings);
                }
            };

            $(nPaging).addClass('pagination').append(
                '<ul class="pagination small text-right" style="margin-top:0px;padding-top:0px;">' +
                    '<li class="prev disabled"><a href="#">' + oLang.sPrevious + '</a></li>' +
                    '<li class="next disabled"><a href="#">' + oLang.sNext + '</a></li>' +
                    '</ul>'
            );
            var els = $('a', nPaging);
            $(els[0]).bind('click.DT', { action: "previous" }, fnClickHandler);
            $(els[1]).bind('click.DT', { action: "next" }, fnClickHandler);
        },

        "fnUpdate": function (oSettings, fnDraw) {
            var iListLength = 5;
            var oPaging = oSettings.oInstance.fnPagingInfo();
            var an = oSettings.aanFeatures.p;
            var i, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

            if (oPaging.iTotalPages < iListLength) {
                iStart = 1;
                iEnd = oPaging.iTotalPages;
            }
            else if (oPaging.iPage <= iHalf) {
                iStart = 1;
                iEnd = iListLength;
            } else if (oPaging.iPage >= (oPaging.iTotalPages - iHalf)) {
                iStart = oPaging.iTotalPages - iListLength + 1;
                iEnd = oPaging.iTotalPages;
            } else {
                iStart = oPaging.iPage - iHalf + 1;
                iEnd = iStart + iListLength - 1;
            }

            for (i = 0, iLen = an.length; i < iLen; i++) {
                // remove the middle elements
                $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                // add the new list items and their event handlers
                for (j = iStart; j <= iEnd; j++) {
                    sClass = (j == oPaging.iPage + 1) ? 'class="active"' : '';
                    $('<li ' + sClass + '><a href="#">' + j + '</a></li>')
                        .insertBefore($('li:last', an[i])[0])
                        .bind('click', function (e) {
                            e.preventDefault();
                            oSettings._iDisplayStart = (parseInt($('a', this).text(), 10) - 1) * oPaging.iLength;
                            fnDraw(oSettings);
                        });
                }

                // add / remove disabled classes from the static elements
                if (oPaging.iPage === 0) {
                    $('li:first', an[i]).addClass('disabled');
                } else {
                    $('li:first', an[i]).removeClass('disabled');
                }

                if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
                    $('li:last', an[i]).addClass('disabled');
                } else {
                    $('li:last', an[i]).removeClass('disabled');
                }
            }
        }
    }
});
