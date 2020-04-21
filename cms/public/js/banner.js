/*=======================================
DataTable Servidor de administradores
=======================================*/

// $.ajax({

//     url: ruta+"/administradores",
//     success: function(respuesta){

//         //console.log("respuesta", respuesta);

//     },
//     error: function(jqXHR, textStatus, errorThrown){
//         console.error(textStatus + " " + errorThrown);
//     }
    
// })

/*=======================================
DataTables de Banners
=======================================*/

var tablaBanner = $("#tablaBanner").DataTable({

    processing: true,
    serverSide: true,

    ajax:{
        url: ruta+"/banner"
    },

    "columnDefs":[{

        "searchable": true,
        "orderable": true,
        "targets": 0

    }],

    "order":[0, "desc"],

    columns: [
        {
            data: 'id_banner',
            name: 'id_banner'
        },
        {
            data: 'pagina_banner',
            name: 'pagina_banner'
        },
        {
            data: 'titulo_banner',
            name: 'titulo_banner'
        },
        {
            data: 'descripcion_banner',
            name: 'descripcion_banner'
        },
        {
            data: 'img_banner',
            name: 'img_banner',
            render: function(data, type, full, meta){

                return '<img src="'+ruta+'/'+data+'" class="img-fluid">'

            },
            orderable: false

        },
        {
            data: 'fecha_banner',
            name: 'fecha_banner',
        },
        {
            data: 'acciones',
            name: 'acciones'
        }
    ],
    "language":{

        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptypeTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_",
	    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
	    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix": "",
	    "sSearch": "Buscar:",
	    "sUrl": "",
	    "sInfoThousands": ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	      "sFirst": "Primero",
	      "sLast": "Último",
	      "sNext": "Siguiente",
	      "sPrevious": "Anterior"
	    },
	    "oAria": {
	      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
	      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }
    }

});

tablaBanner.on('order.dt search.dt', function(){

    tablaBanner.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i){ cell.innerHTML = i+1})

}).draw();

$(document).on("change", ".selectPagina", function(){

    var pagina = $(this).val();

    switch(pagina){

        case "inicio":
            $(".titulo_banner").prop("disabled", true);
            $(".descripcion_banner").prop("disabled", true);
            $(".titulo_banner").prop("required", false);
            $(".descripcion_banner").prop("required", false);
            console.log('dio click a ', pagina);
        break;

        case "interno":
            $(".titulo_banner").prop("disabled", false);
            $(".descripcion_banner").prop("disabled", false);
            console.log('dio click a ', pagina);
        break;

        default:
            $(".titulo_banner").prop("disabled", true);
            $(".descripcion_banner").prop("disabled", true);
            console.log('dio click a ');
    }
})