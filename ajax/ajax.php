<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();


$accion = $_POST['accion'];


switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
        break;


/* PARA Ventas */
case 'insertarVentas':
insertarVentas($serviciosReferencias);
break;
case 'modificarVentas':
modificarVentas($serviciosReferencias);
break;
case 'eliminarVentas':
eliminarVentas($serviciosReferencias);
break;

/* Fin */

/* PARA TipoCervezas */
case 'insertarTipoCervezas':
insertarTipoCervezas($serviciosReferencias);
break;
case 'modificarTipoCervezas':
modificarTipoCervezas($serviciosReferencias);
break;
case 'eliminarTipoCervezas':
eliminarTipoCervezas($serviciosReferencias);
break;

/* Fin */

/* PARA Estadisticas */
case 'graficoTipoCervezas':
graficoTipoCervezas($serviciosReferencias);
break;
/* Fin */

/* PARA ExcepcionHorario */
case 'insertarExcepcionHorario': 
insertarExcepcionHorario($serviciosReferencias); 
break; 
case 'modificarExcepcionHorario': 
modificarExcepcionHorario($serviciosReferencias); 
break; 
case 'eliminarExcepcionHorario': 
eliminarExcepcionHorario($serviciosReferencias); 
break; 

/* Fin */
}

//////////////////////////Traer datos */////////////////////////////////////////////////////////////


/* PARA Ventas */
function insertarVentas($serviciosReferencias) {
	$reftipocerveza = $_POST['reftipocerveza'];
	$precioventa = $_POST['precioventa'];
	$cantidad = $_POST['cantidad'];
	$usuario = $_POST['usuario'];
	
	
	//$observaciones = $_POST['observaciones'];
	$observaciones = '';
	$res = $serviciosReferencias->insertarVentas($reftipocerveza,$precioventa,$cantidad,$usuario,date('Y-m-d H:i:s'),0,$observaciones);
	
	if ((integer)$res > 0) {
		$resCantidadVentasTipoCerveza = $serviciosReferencias->traerVentasPorDiaTipoCerveza($reftipocerveza);
		echo mysql_num_rows($resCantidadVentasTipoCerveza);
	} else {
		echo 'Huvo un error al insertar datos';
	}
}
function modificarVentas($serviciosReferencias) {
$id = $_POST['id'];
$reftipocerveza = $_POST['reftipocerveza'];
$precioventa = $_POST['precioventa'];
$cantidad = $_POST['cantidad'];
$usuario = $_POST['usuario'];
$fechaventa = $_POST['fechaventa'];
if (isset($_POST['cancelado'])) {
$cancelado = 1;
} else {
$cancelado = 0;
}
$observaciones = $_POST['observaciones'];
$res = $serviciosReferencias->modificarVentas($id,$reftipocerveza,$precioventa,$cantidad,$usuario,$fechaventa,$cancelado,$observaciones);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarVentas($serviciosReferencias) {
$id = $_POST['id'];
$observaciones = '';
$res = $serviciosReferencias->eliminarVentas($id, $observaciones);
echo $res;
}

/* Fin */ 



/* PARA TipoCervezas */
function insertarTipoCervezas($serviciosReferencias) {
$tipocerveza = $_POST['tipocerveza'];
$color = $_POST['color'];
$ibu = $_POST['ibu'];
$alcohol = $_POST['alcohol'];
$precio = $_POST['precio'];
$distribuidor = $_POST['distribuidor'];
$observaciones = $_POST['observaciones'];
$res = $serviciosReferencias->insertarTipoCervezas($tipocerveza,$color,$ibu,$alcohol,$precio,$distribuidor,$observaciones);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarTipoCervezas($serviciosReferencias) {
$id = $_POST['id'];
$tipocerveza = $_POST['tipocerveza'];
$color = $_POST['color'];
$ibu = $_POST['ibu'];
$alcohol = $_POST['alcohol'];
$precio = $_POST['precio'];
$distribuidor = $_POST['distribuidor'];
$observaciones = $_POST['observaciones'];
$res = $serviciosReferencias->modificarTipoCervezas($id,$tipocerveza,$color,$ibu,$alcohol,$precio,$distribuidor,$observaciones);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarTipoCervezas($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarTipoCervezas($id);
echo $res;
}

/* Fin */ 


/************* para las ESTADISTICAS **********/

function graficoTipoCervezas($serviciosReferencias) {

	
	$where = '';
	
	$res = $serviciosReferencias->graficoTipoCervezas($where);
	
	echo $res;
	
}


/*********** FIN  *****************************/



/* PARA ExcepcionHorario */
function insertarExcepcionHorario($serviciosReferencias) { 
$reftipocerveza = $_POST['reftipocerveza']; 
$precio = $_POST['precio']; 
$desde = $_POST['desde']; 
$hasta = $_POST['hasta']; 
$res = $serviciosReferencias->insertarExcepcionHorario($reftipocerveza,$precio,$desde,$hasta); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarExcepcionHorario($serviciosReferencias) { 
$id = $_POST['id']; 
$reftipocerveza = $_POST['reftipocerveza']; 
$precio = $_POST['precio']; 
$desde = $_POST['desde']; 
$hasta = $_POST['hasta']; 
$res = $serviciosReferencias->modificarExcepcionHorario($id,$reftipocerveza,$precio,$desde,$hasta); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarExcepcionHorario($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarExcepcionHorario($id); 
echo $res; 
} 

/* Fin */

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
    $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	echo $serviciosUsuarios->modificarUsuario($id,$apellido,$password,$refroll,$email,$nombre);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];
	
	echo $serviciosUsuarios->login($email,$pass);
}


function devolverImagen($nroInput) {
	
	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }
	  
	  $datos = getimagesize($tmp_name);
	  
	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);	
}


?>