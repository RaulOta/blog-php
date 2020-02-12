
/*=============================================
BANNER
=============================================*/

$(".fade-slider").jdSlider({

	isSliding: false,
	isAuto: true,
	isLoop: true,
	isDrag: false,
	interval:5000,
	isCursor: false,
	speed:3000

});

var alturaBanner = $(".fade-slider").height();

$(".bannerEstatico").css({"height":alturaBanner+"px"})


/*=============================================
ANIMACIONES SCROLL
=============================================*/

$(window).scroll(function(){

	var posY = window.pageYOffset;
	
	if(posY > alturaBanner){

		$("header").css({"background":"white"})

		$("header .logotipo").css({"filter":"invert(100%)"})

		$(".fa-search, .fa-bars").css({"color":"black"})

	}else{

		$("header").css({"background":"rgba(0,0,0,.5)"})

		$("header .logotipo").css({"filter":"invert(0%)"})

		$(".fa-search, .fa-bars").css({"color":"white"})

	}

})

/*=============================================
MENÚ
=============================================*/

$(".fa-bars").click(function(){

	$(".menu").fadeIn("fast");

})

$(".btnClose").click(function(e){

	e.preventDefault();

	$(".menu").fadeOut("fast");

})

/*=============================================
GRID CATEGORÍAS
=============================================*/

$(".grid figure, .gridFooter figure").mouseover(function(){

	$(this).css({"background-position":"right bottom"})

})

$(".grid figure, .gridFooter figure").mouseout(function(){

	$(this).css({"background-position":"left top"})

})

$(".grid figure, .gridFooter figure").click(function(){

	var vinculo = $(this).attr("vinculo");

	window.location = vinculo;

})

/*=============================================
PAGINACIÓN
=============================================*/

//Se asigna el valor a una variable el valor mandado desde el html para poder ser usado en JS, utilizando
//la función Number para convertir el valor de la variable string a entero (.pagination -> nombre de la clase/evento)
var totalPaginas = Number($(".pagination").attr("totalPaginas"));

var rutaActual = $("#rutaActual").val(); //Se esta capturando el valor que se esta registrando en el input oculdo en la plantilla para traer la dirección actual

var paginaActual = Number($(".pagination").attr("paginaActual"));

var rutaPagina = $(".pagination").attr("rutaPagina"); //Variable que capture la ruta de la página

if($(".pagination").length != 0){

	//startPage -> El número que se quiere pintar en la númeración
	$(".pagination").twbsPagination({
		totalPages: totalPaginas,
		startPage: paginaActual,
		visiblePages: 4,
		first: "Primero",
		last: "Último",
		prev: '<i class="fas fa-angle-left"></i>',
		next: '<i class="fas fa-angle-right"></i>'

	}).on("page", function(evt, page){
		
		if(rutaPagina != ""){

			window.location = rutaActual+rutaPagina+"/"+page;	

		}else{

			//console.log("evt", page);
			//console.log("page", page);
			window.location = rutaActual+page;

		}
	})

}

//funcion on para mostrar el evento que tiene el plugin con los parametros "evt" y "page" 


/*=============================================
SCROLL UP
=============================================*/

$.scrollUp({
	scrollText:"",
	scrollSpeed: 2000,
	easingType: "easeOutQuint"
})

/*=============================================
DESLIZADOR DE ARTÍCULOS
=============================================*/

$(".deslizadorArticulos").jdSlider({
	wrap: ".slide-inner",
	slideShow: 3,
	slideToScroll:3,
	isLoop: true,
	responsive: [{
		viewSize: 320,
		settings:{
			slideShow: 1,
			slideToScroll: 1
		}

	}]

})

/*=============================================
COMPARTIR ARTÍCULOS
=============================================*/

$('.social-share').shapeShare();


