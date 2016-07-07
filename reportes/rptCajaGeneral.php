<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

if ($_GET['id'] != 0) {
	$id				=	$_GET['usuario'];	
	$resUsuario		=	$serviciosUsuarios->traerUsuarioId($id);
	$usuario		=	mysql_result($resUsuario,0,'nombrecompleto');
} else {
	
	$usuario = 'Todos';	
}


//////////////////              PARA LAS FECHAS        /////////////////////////////////////////////////////////////////

$fechadesde		=	$_GET['fechadesde'];
$fechahasta		=	$_GET['fechahasta'];


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$datos			=	$serviciosReferencias->traerVentasPorUsuarioFechas($usuario,$fechadesde,$fechahasta);
//die(var_dump($datos));
$TotalIngresos = 0;
$TotalEgresos = 0;
$Totales = 0;
$Caja = 0;



class PDF extends FPDF
{
// Cargar los datos




// Tabla coloreada
function ingresosFacturacion($header, $data, &$TotalIngresos)
{
	$this->SetFont('Arial','',12);
	$this->Ln();
	$this->Ln();
	$this->Cell(60,7,'Caja Diaria - Mensual - Usuarios',0,0,'L',false);
	$this->SetFont('Arial','',11);
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
	$this->Ln();
	
	
    // Cabecera
    $w = array(75,22,22,60,30,22);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
	
	$total = 0;
	$totalcant = 0;
	$totalLitros = 0;
	
	$this->SetFont('Arial','',9);
    while ($row = mysql_fetch_array($data))
    {
		if ($row['cancelado'] == 0) {
		$total = $total + $row['monto'];
		$totalcant += 1; 
		$totalLitros = $totalLitros + $row['cantidad'];
		}

        $this->Cell($w[0],5,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[1],5,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[2],5,'$'.number_format($row[3],2,',','.'),'LR',0,'R',$fill);
		$this->Cell($w[3],5,$row[4],'LR',0,'L',$fill);
		$this->Cell($w[4],5,$row[5],'LR',0,'C',$fill);
		$this->Cell($w[5],5,$row[6],'LR',0,'C',$fill);
        $this->Ln();
        
		
		if ($totalcant == 25) {
			$this->AddPage();
			$this->SetFont('Arial','',11);
			// Colores, ancho de línea y fuente en negrita
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],6,$header[$i],1,0,'C',true);
			$this->Ln();
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Datos
			$fill = false;
			$this->SetFont('Arial','',9);
		}
    }
	
	$this->Cell($w[0]+$w[1]+$w[2]+$w[3],5,'Totales:','LRT',0,'L',$fill);
	$this->Cell($w[4]+$w[5],5,number_format($total,2,',','.'),'LRT',0,'R',$fill);

	$fill = !$fill;
	$this->Ln();
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
	$this->SetFont('Arial','',12);
	$this->Ln();
	$this->Ln();
	$this->Cell(60,7,'Cantidad de Ventas: '.$totalcant,0,0,'L',false);
	$this->Ln();
	$this->Cell(60,7,'Total Litros Vendidos: '.$totalLitros,0,0,'L',false);
	$this->Ln();
	$this->Cell(60,7,'Total: $'.number_format($total, 2, '.', ',').'  /* No se tienen en cuenta las ventas canceladas */',0,0,'L',false);
	
}

//Pie de página
function Footer()
{

$this->SetY(-10);

$this->SetFont('Arial','I',8);

$this->Cell(0,10,'Pagina '.$this->PageNo()." - Fecha: ".date('Y-m-d'),0,0,'C');
}
   
}






$pdf = new PDF("L");


// Títulos de las columnas

$headerFacturacion = array("Cerveza", "Cant. Ltrs", "Monto","Usuario", "Fecha", "Cancelado");
// Carga de datos

$pdf->AddPage();

$pdf->SetFont('Arial','U',17);
$pdf->Cell(260,7,'Reporte Caja',0,0,'C',false);
$pdf->Ln();
$pdf->SetFont('Arial','U',14);
$pdf->Cell(260,7,"Usuario: ".strtoupper($usuario),0,0,'C',false);
$pdf->Ln();
$pdf->Cell(260,7,'Fecha: desde '.$fechadesde." hasta ".$fechahasta,0,0,'C',false);
$pdf->Ln();

$pdf->SetFont('Arial','',10);

$pdf->ingresosFacturacion($headerFacturacion,$datos,$TotalFacturacion);

$pdf->Ln();



$pdf->SetFont('Arial','',13);

$nombreTurno = "rptCajaGeneral-".$fecha.".pdf";

$pdf->Output($nombreTurno,'D');


?>

