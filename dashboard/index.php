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
//$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Dashboard",$_SESSION['refroll_predio'],'');


/////////////////////// Opciones pagina ///////////////////////////////////////////////

$tituloWeb = "Gestión: Let it Brew";
//////////////////////// Fin opciones ////////////////////////////////////////////////


$resTiposCervezas	= $serviciosReferencias->traerTipoCervezasExcepciones();


/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras 		= "	<th>Tipo Cerveza</th>
					<th>Cantidad</th>
					<th>Monto</th>
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Cancelado</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerVentasPorDia(),99);
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
    <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">


.contCerveza1 {
	background-color:#FFF;
	border-top:1px solid #000;
	border-left:1px solid #000;
	border-right:1px solid #000;
	padding:15px;
	min-height:130px;
	display:block;
}

.contCerveza2 {
	background-color:#FFF;
	border-bottom:1px solid #000;
	border-left:1px solid #000;
	border-right:1px solid #000;
	padding:15px;
	min-height:130px;
	display:block;
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

 
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Let it Brew</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Panel de Control <span class="sr-only">(current)</span></a></li>
        <li><a href="tiposcervezas/">Tipos de Cervezas</a></li>
        <li><a href="excepcioneshorarias/">Excepciones Horarias</a></li>
        <li><a href="usuarios/">Usuarios</a></li>
        <li><a href="estadisticas/">Estadisticas</a></li>
        <li><a href="informes/">Informes</a></li>
        <li><a href="../logout.php">Salir</a></li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav> 



<form class="form-inline formulario" role="form">

	<?php
		echo '<div class="row">';
		$i=0;
		$primero = 1;
		while ($rowC = mysql_fetch_array($resTiposCervezas)) { 
			$resVTC = $serviciosReferencias->traerVentasPorDiaTipoCerveza($rowC[0]);
			$cantVentas = mysql_num_rows($resVTC);
			$cantLitros = $serviciosReferencias->traerVentasPorDiaTipoCervezaLitros($rowC[0]);
			
			if ((($i % 4) == 0) && ($primero != 1)) {
				echo '</div>';
				echo '<div class="row">';	
			}
	?>
	<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
    	<div class="contCerveza1">	
            <div style="float:left; height:100px; display:block;">
            	<?php
					switch ($rowC['color']) {
						case 'Rubia':
							echo '<img src="../imagenes/rubia.png" width="40">';	
							break;
						case 'Amber':
							echo '<img src="../imagenes/amber.png" width="40">';	
							break;
						case 'Red':
							echo '<img src="../imagenes/red.png" width="40">';	
							break;
						case 'Negra':
							echo '<img src="../imagenes/negra.png" width="40">';	
							break;
						case 'Brown':
							echo '<img src="../imagenes/brown.png" width="40">';	
							break;	
						default:
							echo '<img src="../imagenes/rubia.png" width="40">';	
							break;
					}
				?>
                
            </div>
            <div align="center">
                <h5>Cerveza: <span style="font-weight:bold; font-size:1.3em;"><?php echo $rowC[1]; ?></span> <span style=" background-color: #0F3;" class="badge" id="<?php echo 'badge'.$rowC[0]; ?>"><?php echo $cantVentas; ?></span><span class="badge" style=" background-color: #009;" id="<?php echo 'badgeL'.$rowC[0]; ?>"><?php echo $cantLitros; ?></span></h5>
                <h5>Precio: $<?php echo $rowC['precio']; ?></h5>
                <h5>IBU: <?php echo $rowC['ibu']; ?></h5>
                <h5>Alcohol: <?php echo $rowC['alcohol']; ?></h5>            
            </div>
            <p>Obs.: <?php echo $rowC['observaciones']; ?></p>
        </div>
        
        <div class="contCerveza2">	
        	<div class="form-group col-md-6 col-xs-10 col-sm-6">
                <label for="precio" class="control-label" style="text-align:left">Precio</label>
                <div class="input-group col-md-12 col-xs-12 col-sm-12">
                	
                    <input class="form-control" type="text" name="precio<?php echo $rowC[0]; ?>" id="precio<?php echo $rowC[0]; ?>" value="<?php echo $rowC['precio']; ?>"/>
                    
                </div>
                
            </div>
            
            
            <div class="form-group col-md-6">
                <label for="cantidad" class="control-label" style="text-align:left">Cantidad</label>
                <div class="input-group col-md-12">
                    <input class="form-control" type="number" name="cantidad<?php echo $rowC[0]; ?>" id="cantidad<?php echo $rowC[0]; ?>" value="1"/>
                </div>
                
            </div>
            
            

            <div class="form-group col-md-12" style="margin-top:6px; margin-bottom:5px; text-align:center;">

                <button type="button" class="btn btn-primary cargar" id="<?php echo $rowC[0]; ?>" style="margin-left:0px;">Cargar Venta</button>

            </div>
            
            <div class='form-group col-md-12' style="height:50px; display:block;">
                <div class='alert error<?php echo $rowC[0]; ?> alert-dismissable'>
                	<button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <div id='load'>
                
                </div>
            </div>
			
    	</div>   
    </div>
    
    <?php
		
			if (($i%4 ==0) || ($primero == 1)) {
					
				$primero = 0;
			}
			$i += 1;
		}
		echo '</div>';
	?>

</form>



<div class="row" style="padding:2%;">
	<div class="panel panel-primary">
        <div class="panel-heading">
        	Ventas Cargadas
        	
        </div>
    	<div class="panel-body">
        	<?php echo $lstCargados; ?>
    	</div>
    </div>
</div>

	

<div id="dialog2" title="Cancelar Venta">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea cancelar la venta?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si cancelara la venta pero no se borrara.</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script src="../bootstrap/js/dataTables.bootstrap.js"></script>  

<script type="text/javascript">
$(document).ready(function(){
	$('#example').dataTable({
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
						
	function insertarVenta(precio, cantidad, tipocerveza, label) {
		$.ajax({
				data:  {precioventa : precio,
						cantidad: cantidad,
						reftipocerveza : tipocerveza,
						usuario: '<?php echo $_SESSION['nombre_predio']; ?>',
						accion: 'insertarVentas'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
					
					if (!isNaN(response)) {

						$('#badge'+label).html(response);

						$('#badgeL'+label).html(parseInt($('#badgeL'+label).html()) + parseInt(cantidad));
						$('.error'+label).removeClass("alert-danger");
						$('.error'+label).removeClass("alert-info");
                        $('.error'+label).addClass("alert-success");
                        $('.error'+label).append('<strong>Ok!</strong> Se cargo correctamente</strong>. ');
					} else {
					
						$('.error'+label).removeClass("alert-danger");
                        $('.error'+label).addClass("alert-danger");
                        $('.error'+label).append('<strong>Error!</strong> '+response);
					}
						
				}
		});
	}
	
	
	
	$('.cargar').click(function(){
		tipocerveza =  $(this).attr("id");
		if (!isNaN(tipocerveza)) {
			insertarVenta($('#precio'+tipocerveza).val(), $('#cantidad'+tipocerveza).val(), tipocerveza,tipocerveza);
		
		} else {
		alert("Error, vuelva a realizar la acción.");	
		}
		
	});
	
	$("#example").on("click",'.varborrar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	
	$( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Cancelar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: 'eliminarVentas'},
									url:   '../ajax/ajax.php',
									type:  'post',
									beforeSend: function () {
											
									},
									success:  function (response) {
											url = "index.php";
											$(location).attr('href',url);
											
									}
							});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Salir: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar
	
	
});
</script>
<?php } ?>
</body>
</html>
