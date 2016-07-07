<?php


session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funciones.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosUsuarios  = new ServiciosUsuarios();
$serviciosFunciones = new Servicios();
$serviciosHTML		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);



$resTipoCerveza		=	$serviciosReferencias->traerTipoCervezas();

$resUsuarios		=	$serviciosUsuarios->traerUsuarios();

$cadRef = '';
while ($rowTT = mysql_fetch_array($resTipoCerveza)) {
	$cadRef = $cadRef.'<option value="'.$rowTT[0].'">'.utf8_encode($rowTT[1]).'</option>';
	
}

$cadRefE = '';
while ($rowTTE = mysql_fetch_array($resUsuarios)) {
	$cadRefE = $cadRefE.'<option value="'.$rowTTE[0].'">'.utf8_encode($rowTTE[1]).'</option>';
	
}


if ($_SESSION['refroll_predio'] == 2) {
	header('Location: ../index.php');
} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gestión: Let it Brew</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estilo.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.datetimepicker.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">

		
	</style>
    
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
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
        <li><a href="../">Panel de Control</a></li>
        <li><a href="../tiposcervezas/">Tipos de Cervezas</a></li>
        <li><a href="../ventas/">Ventas</a></li>
        <li><a href="../usuarios/">Usuarios</a></li>
        <li><a href="../estadisticas/">Estadisticas</a></li>
        <li class="active"><a href="index.php">Informes <span class="sr-only">(current)</span></a></li>
        <li><a href="../../logout.php">Salir</a></li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav> 

<div class="row" style="padding:2%;">

    <div class="panel panel-primary">
        <div class="panel-heading">
        	<p style="color: #fff; font-size:18px; height:16px;">Caja Diaria - Mensual - Usuarios</p>
        	
        </div>
    	<div class="panel-body">
        	<form class="form-inline formulario" role="form">
        	<div class="row">
            	<div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Seleccione Usuario</label>
                    <div class="input-group col-md-12">
                    	<select id="refusuario1" class="form-control" name="refusuario1">
							<option value="0">--- Seleccionar ---</option>
							<?php echo $cadRefE; ?>
                    	</select>
                    </div>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="'.$campo.'" class="control-label" style="text-align:left">Fecha Desde</label>
                    <div class="input-group col-md-12">
                        <input class="form-control" type="text" name="fechadesde1" id="fechadesde1"/>
                    </div>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="'.$campo.'" class="control-label" style="text-align:left">Fecha Hasta</label>
                    <div class="input-group col-md-12">
                        <input class="form-control" type="text" name="fechahasta1" id="fechahasta1"/>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Acción</label>

                    	<ul class="list-inline">
                        	<li>
                    			<button type="button" class="btn btn-success" id="rptgf" style="margin-left:0px;">Generar</button>
                            </li>
                            <li>
                        		<button type="button" class="btn btn-default" id="rptgfExcel" style="margin-left:0px;">Generar Excel</button>
                            </li>
                        </ul>

                </div>
                

            </div>
            
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>

            </form>
    	</div>
    </div>
    
    



</div>

<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>
<script src="../../js/jquery.datetimepicker.full.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	function traerClientesPorEmpresa(idEmpresa) {
		$.ajax({
				data:  {idEmpresa: idEmpresa,
						accion: 'traerClientesPorEmpresa'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('#refcliente1').html(response);
						
				}
		});
	}
	
	$('#refempresa4').change(function(e) {
		traerClientesPorEmpresa($(this).val());	
	});
	

	
	$("#rptgf").click(function(event) {
        window.open("../../reportes/rptCajaGeneral.php?id=" + $("#refusuario1").val() + "&fechadesde=" + $("#fechadesde1").val()+ "&fechahasta=" + $("#fechahasta1").val(),'_blank');	
						
    });
	
	
	$("#rptgfExcel").click(function(event) {
        window.open("../../reportes/rptCajaGeneralExcel.php?id=" + $("#refusuario1").val() + "&fechadesde=" + $("#fechadesde1").val()+ "&fechahasta=" + $("#fechahasta1").val(),'_blank');	
						
    });
	
	
	$('#fechadesde1').datetimepicker({
	dayOfWeekStart : 1,
	format: 'Y-m-d H:i',
	lang:'en'
	});
	$('#fechadesde1').datetimepicker({step:10});
	
	$('#fechahasta1').datetimepicker({
	dayOfWeekStart : 1,
	format: 'Y-m-d H:i',
	lang:'en'
	});
	$('#fechahasta1').datetimepicker({step:10});

});
</script>



<?php } ?>
</body>
</html>
