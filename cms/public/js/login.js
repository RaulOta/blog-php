/*=======================================
Función para crear cookies en JS
=======================================*/

function crearCookie(nombre, valor, diasExpiracion){

    var hoy = new Date();

    hoy.setTime(hoy.getTime() + (diasExpiracion*24*60*60*1000));

    var fechaExpiracion = "expires=" + hoy.toUTCString();

    document.cookie = nombre + "=" +valor+"; "+fechaExpiracion;

}

/*=======================================
Capturar Email Login para convertirlo en variable cookie
=======================================*/

$(document).on("change", ".email_login", function(){

    //console.log("$(this).val())"), $(this).val());
    crearCookie("email_login", $(this).val(), 1);

})