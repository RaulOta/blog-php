<?php
require_once "controladores/plantilla_controlador.php";

require_once "controladores/blog_controlador.php";
require_once "modelos/blog_modelo.php";

require_once "controladores/correo_controlador.php";

require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrTraerPlantilla();