<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../error.php');
} else {


include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();


$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Dashboard",$_SESSION['refroll_predio'],'');


/////////////////////// Opciones pagina ///////////////////////////////////////////////

$tituloWeb = "Gestión: Let it Brew";
//////////////////////// Fin opciones ////////////////////////////////////////////////




?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../css/estilo.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">

    <script src="../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">
		table {
		   width: 100%;
		   border: 1px solid #343434;
		   border-radius: 8px 8px 0px 0px;
		-moz-border-radius: 8px 8px 0px 0px;
		-webkit-border-radius: 8px 8px 0px 0px;
		border: 0px solid #000000;
		}
		
		.radius {
		border-radius: 8px 8px 0px 0px;
		-moz-border-radius: 8px 8px 0px 0px;
		-webkit-border-radius: 8px 8px 0px 0px;
		border: 0px solid #000000;
		}
		
		table thead {
			background-color: #686868;
			
		}
		
td {
   width: 100%;
   text-align: center;
   vertical-align: top;
   border: 1px solid #343434;
   border-collapse: collapse;
   padding: 0.3em;
   caption-side: bottom;
   font-weight:bold;
   color:#FFF;
   text-shadow: 1px 1px 1px #333;
}

th {
   width: 100%;
   padding:2px 5px;
   color:#FFF;
   text-align: center;
   vertical-align: top;
   border: 1px solid #343434;
   border-collapse: collapse;
   padding: 0.3em;
   caption-side: bottom;
   font-weight:bold;
   
}
caption {
   padding: 0.3em;
}

.headBoxInfo span {
	cursor:pointer;
}
		
	</style>
    
   
   <link href="../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../js/jquery.mousewheel.js"></script>
      <script src="../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
    
    <link rel="stylesheet" href="../css/chosen.css">
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
	<script src="../js/graficos/morris.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
	<script src="../lib/example.js"></script>
  	<link rel="stylesheet" href="../lib/example.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
    <link rel="stylesheet" href="../css/graficos/morris.css">
</head>

<body>

 






  

<script type="text/javascript">
$(document).ready(function(){
	
	$('.abrir').click(function() {
		
		if ($('.abrir').text() == '(Abrir)') {
			$('.filt').show( "slow" );
			$('.abrir').text('(Cerrar)');
			$('.abrir').removeClass('glyphicon glyphicon-plus');
			$('.abrir').addClass('glyphicon glyphicon-minus');
		} else {
			$('.filt').slideToggle( "slow" );
			$('.abrir').text('(Abrir)');
			$('.abrir').addClass('glyphicon glyphicon-plus');
			$('.abrir').removeClass('glyphicon glyphicon-minus');

		}
	});
	
	$('.abrir').click();
	
	$('.abrir').click(function() {
		$('.filt').show();
	});
	
	function traerInmuebles() {
		$.ajax({
				data:  {refurbanizacion : $('#refurbanizacion').val(),
						reftipovivienda : $('#reftipovivienda').val(),
						refuso : $('#refuso').val(),
						refsituacioninmueble : $('#refsituacioninmueble').val(),
						dormitorios : $('#dormitorios').val(),
						banios : $('#banios').val(),
						encontruccion : $('#encontruccion').val(),
						mts2 : $('#mts2').val(),
						anioconstruccion : $('#anioconstruccion').val(),
						precioventapropietario : $('#precioventapropietario').val(),
						nombrepropietario : $('#nombrepropietario').val(),
						apellidopropietario : $('#apellidopropietario').val(),
						fechacarga : $('#fechacarga').val(),
						refusuario : $('#refusuario').val(),
						refcomision : $('#refcomision').val(),
						accion: 'Filtros'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('.resultados').html(response);
						
				}
		});
	}
	
	
	function traerOportunidades() {
		$.ajax({
				data:  {refurbanizacion : $('#refurbanizacion').val(),
						reftipovivienda : $('#reftipovivienda').val(),
						refuso : $('#refuso').val(),
						refsituacioninmueble : $('#refsituacioninmueble').val(),
						dormitorios : $('#dormitorios').val(),
						banios : $('#banios').val(),
						encontruccion : $('#encontruccion').val(),
						mts2 : $('#mts2').val(),
						anioconstruccion : $('#anioconstruccion').val(),
						precioventapropietario : $('#precioventapropietario').val(),
						nombrepropietario : $('#nombrepropietario').val(),
						apellidopropietario : $('#apellidopropietario').val(),
						fechacarga : $('#fechacarga').val(),
						refusuario : $('#refusuario').val(),
						refcomision : $('#refcomision').val(),
						accion: 'Oportunidades'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('.oportunidades').html(response);
						
				}
		});
	}
	
	function graficos() {
	
	  eval($('#code').text());
	  prettyPrint();
	}
	
	function graficosTV() {
	
	  eval($('#code2').text());
	  prettyPrint();
	}
	
	function graficosU() {
	
	  eval($('#code3').text());
	  prettyPrint();
	}
	
	function GraficoValoracion() {
		$.ajax({
				data:  {refurbanizacion : $('#refurbanizacion').val(),
						reftipovivienda : $('#reftipovivienda').val(),
						refuso : $('#refuso').val(),
						refsituacioninmueble : $('#refsituacioninmueble').val(),
						dormitorios : $('#dormitorios').val(),
						banios : $('#banios').val(),
						encontruccion : $('#encontruccion').val(),
						mts2 : $('#mts2').val(),
						anioconstruccion : $('#anioconstruccion').val(),
						precioventapropietario : $('#precioventapropietario').val(),
						nombrepropietario : $('#nombrepropietario').val(),
						apellidopropietario : $('#apellidopropietario').val(),
						fechacarga : $('#fechacarga').val(),
						refusuario : $('#refusuario').val(),
						refcomision : $('#refcomision').val(),
						accion: 'graficosValoracion'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('#code').html(response);
						graficos();
				}
		});
	}
	
	function GraficosTipoVivienda() {
		$.ajax({
				data:  {refurbanizacion : $('#refurbanizacion').val(),
						reftipovivienda : $('#reftipovivienda').val(),
						refuso : $('#refuso').val(),
						refsituacioninmueble : $('#refsituacioninmueble').val(),
						dormitorios : $('#dormitorios').val(),
						banios : $('#banios').val(),
						encontruccion : $('#encontruccion').val(),
						mts2 : $('#mts2').val(),
						anioconstruccion : $('#anioconstruccion').val(),
						precioventapropietario : $('#precioventapropietario').val(),
						nombrepropietario : $('#nombrepropietario').val(),
						apellidopropietario : $('#apellidopropietario').val(),
						fechacarga : $('#fechacarga').val(),
						refusuario : $('#refusuario').val(),
						refcomision : $('#refcomision').val(),
						accion: 'graficosTipoVivienda'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('#code2').html(response);
						graficosTV();
				}
		});
	}
	
	
	function GraficosUsos() {
		$.ajax({
				data:  {refurbanizacion : $('#refurbanizacion').val(),
						reftipovivienda : $('#reftipovivienda').val(),
						refuso : $('#refuso').val(),
						refsituacioninmueble : $('#refsituacioninmueble').val(),
						dormitorios : $('#dormitorios').val(),
						banios : $('#banios').val(),
						encontruccion : $('#encontruccion').val(),
						mts2 : $('#mts2').val(),
						anioconstruccion : $('#anioconstruccion').val(),
						precioventapropietario : $('#precioventapropietario').val(),
						nombrepropietario : $('#nombrepropietario').val(),
						apellidopropietario : $('#apellidopropietario').val(),
						fechacarga : $('#fechacarga').val(),
						refusuario : $('#refusuario').val(),
						refcomision : $('#refcomision').val(),
						accion: 'graficosUsos'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('#code3').html(response);
						graficosU();
				}
		});
	}
	
	traerInmuebles();
	traerOportunidades();
	GraficoValoracion();
	GraficosTipoVivienda();
	GraficosUsos();
	$('#buscar').click(function(e) {
        
		
	});
	
	$('.actualizar').click(function() {
		traerOportunidades();
	});
	
	
	
	
});
</script>
<?php } ?>
</body>
</html>
