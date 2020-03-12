/*=======================================
AGREGAR RED
=======================================*/
$(document).on("click", ".agregarRed", function(){

    //Asignar los valores de los input
    var url = $("#url_red").val();
    var icono = $("#icono_red").val().split(",")[0];
    var color = $("#icono_red").val().split(",")[1];

    //Mostrar la nueva red agregada
    $(".listadoRed").append(`
    
        <div class="col-lg-12">

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                <div class="input-group-text text-white" style="background:`+color+`">
                                        
                    <i class="`+icono+`"></i>
                                          
                </div>

                </div>

                <input type="text" class="form-control" value="`+url+`">

                <div class="input-group-prepend">

                <div class="input-group-text" style="cursor:pointer">
                                        
                    <span class="bg-danger px-2 rounded-circle eliminarRed" red="`+icono+`" url="`+url+`">&times;</span>
                                          
                </div>

                </div>

            </div>

        </div>
    
    `)

    //Actualizar el registro para subir a la BD

    var listaRed = JSON.parse($("#listaRed").val());

    listaRed.push({

        "url": url,
        "icono": icono,
        "background": color

    })

    $("#listaRed").val(JSON.stringify(listaRed));
    

})

/*=======================================
ELIMINAR RED
=======================================*/
$(document).on("click", ".eliminarRed", function(){

    var listaRed = JSON.parse($("#listaRed").val());

    var red = $(this).attr("red");
    var url = $(this).attr("url");

    for (var i = 0; i < listaRed.length; i++) {
        if(red == listaRed[i]["icono"] && url == listaRed[i]["url"]){
        
            listaRed.splice(i, 1);
            
            $(this).parent().parent().parent().parent().remove();

            $("#listaRed").val(JSON.stringify(listaRed));

        }
        
    }

})


/*=======================================
SUMMERNOTE
=======================================*/

$(".summernote").summernote();