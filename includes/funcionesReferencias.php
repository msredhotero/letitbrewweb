<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}



/* PARA TipoCervezas */

function insertarTipoCervezas($tipocerveza,$color,$ibu,$alcohol,$precio,$distribuidor,$observaciones) {
$sql = "insert into tbtipocervezas(idtipocerveza,tipocerveza,color,ibu,alcohol,precio,distribuidor,observaciones)
values ('','".utf8_decode($tipocerveza)."','".utf8_decode($color)."','".utf8_decode($ibu)."','".utf8_decode($alcohol)."',".$precio.",'".utf8_decode($distribuidor)."','".utf8_decode($observaciones)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarTipoCervezas($id,$tipocerveza,$color,$ibu,$alcohol,$precio,$distribuidor,$observaciones) {
$sql = "update tbtipocervezas
set
tipocerveza = '".utf8_decode($tipocerveza)."',color = '".utf8_decode($color)."',ibu = '".utf8_decode($ibu)."',alcohol = '".utf8_decode($alcohol)."',precio = ".$precio.",distribuidor = '".utf8_decode($distribuidor)."',observaciones = '".utf8_decode($observaciones)."'
where idtipocerveza =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTipoCervezas($id) {
$sql = "delete from tbtipocervezas where idtipocerveza =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTipoCervezas() {
$sql = "select idtipocerveza,tipocerveza,color,ibu,alcohol,precio,distribuidor,observaciones from tbtipocervezas order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTipoCervezasPorId($id) {
$sql = "select idtipocerveza,tipocerveza,color,ibu,alcohol,precio,distribuidor,observaciones from tbtipocervezas where idtipocerveza =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */


/* PARA Ventas */

function insertarVentas($reftipocerveza,$precioventa,$cantidad,$usuario,$fechaventa,$cancelado,$observaciones) {
$sql = "insert into dbventas(idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones)
values ('',".$reftipocerveza.",".$precioventa.",".$cantidad.",'".utf8_decode($usuario)."','".utf8_decode($fechaventa)."',".$cancelado.",'".utf8_decode($observaciones)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarVentas($id,$reftipocerveza,$precioventa,$cantidad,$usuario,$fechaventa,$cancelado,$observaciones) {
$sql = "update dbventas
set
reftipocerveza = ".$reftipocerveza.",precioventa = ".$precioventa.",cantidad = ".$cantidad.",usuario = '".utf8_decode($usuario)."',fechaventa = '".utf8_decode($fechaventa)."',cancelado = ".$cancelado.",observaciones = '".utf8_decode($observaciones)."'
where idventa =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarVentas($id,$observaciones) {
$sql = "update dbventas
set
cancelado = 1,observaciones = '".utf8_decode($observaciones)."'
where idventa =".$id;
$res = $this->query($sql,0);
return $res;
}

function eliminarVentasDefinitivo($id) {
$sql = "delete from dbventas where idventa =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerVentas() {
$sql = "select idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones from dbventas order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerVentasPorDia() {
if ((date('H') > 0) && (date('H') < 14)) {
	$dia = 	'DATE_ADD(curdate(), interval -1 day)';
} else {
	$dia = 	'curdate()';
	//$dia = 	'DATE_ADD(curdate(), interval -1 day)';
}
$sql = "select idventa,tc.tipocerveza,cantidad,cantidad * precioventa,usuario,fechaventa,(case when cancelado=0 then 'No' else 'Si' end) as cancelado ,v.observaciones 
			from dbventas v 
			inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
			where	v.fechaventa >= concat(cast(".$dia." as CHAR),' ','14:00:00')
					and v.fechaventa <= DATE_ADD(cast(concat(cast(".$dia." as CHAR),' ','14:00:00') as date), interval 28 hour) 
			order by fechaventa DESC";
$res = $this->query($sql,0);
return $res;
}

function traerVentasPorUsuarioFechas($usuario,$fechadesde, $fechahasta) {
	$where = '';
$sql = "select idventa,tc.tipocerveza,cantidad,(cantidad * precioventa) as monto,usuario,fechaventa,(case when cancelado=0 then 'No' else 'Si' end) as cancelado ,v.observaciones 
			from dbventas v 
			inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza ";
			if (($fechadesde != '') && ($fechahasta != '')) {
		$where.= " where v.fechaventa BETWEEN '".$fechadesde."' and '".$fechahasta."' ";
				} else {
					if ($fechadesde != '') {
						$where= " where v.fechaventa >= '".$fechadesde."' ";
					} else {
						if ($fechahasta != '') {
							$where= " where v.fechaventa <= '".$fechahasta."' ";
						}
					}
				}
			if (($usuario != '') and ($usuario != 'Todos')) {
				if ($where != '') {
					$where .= "and v.usuario = '".$usuario."'";	
				} else {
					$where .= "where v.usuario = '".$usuario."'";	
				}
			}
		$sql .= $where;	
		$sql .= "	order by fechaventa DESC";
$res = $this->query($sql,0);
return $res;
//return $sql;
}

function traerVentasPorUsuario() {
$sql = "select idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones from dbventas order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerVentasPorTipoCerveza() {
$sql = "select idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones from dbventas order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerVentasPorDiaTipoCerveza($refTipoCerveza) {
	if ((date('H') > 0) && (date('H') < 14)) {
	$dia = 	'DATE_ADD(curdate(), interval -1 day)';
	} else {
		$dia = 	'curdate()';
		//$dia = 	'DATE_ADD(curdate(), interval -1 day)';
	}

$sql = "select idventa,tc.tipocerveza,cantidad,cantidad * precioventa,usuario,fechaventa,cancelado,v.observaciones 
			from dbventas v 
			inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
			where	v.fechaventa >= concat(cast(".$dia." as CHAR),' ','14:00:00')
					and v.fechaventa <= DATE_ADD(cast(concat(cast(".$dia." as CHAR),' ','14:00:00') as date), interval 28 hour) 
					and v.reftipocerveza = ".$refTipoCerveza." and v.cancelado = 0
			order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerVentasPorDiaTipoCervezaLitros($refTipoCerveza) {
	if ((date('H') > 0) && (date('H') < 14)) {
	$dia = 	'DATE_ADD(curdate(), interval -1 day)';
	} else {
		$dia = 	'curdate()';
		//$dia = 	'DATE_ADD(curdate(), interval -1 day)';
	}
	
	$sql = "select coalesce(sum(cantidad),0) as litros
				from dbventas v 
				inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
				where	v.fechaventa >= concat(cast(".$dia." as CHAR),' ','14:00:00')
						and v.fechaventa <= DATE_ADD(cast(concat(cast(".$dia." as CHAR),' ','14:00:00') as date), interval 28 hour) 
						and v.reftipocerveza = ".$refTipoCerveza." and v.cancelado = 0
				";
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,0);
	}
	
	return '0';
}


function traerVentasPorId($id) {
$sql = "select idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones from dbventas where idventa =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */



/* para las ESTADISTICAS */

function graficoTipoCervezas($where) {
if ($where != '') {
		$sql = "select
					tc.idtipocerveza, tc.tipocerveza, coalesce(sum(v.cantidad),0)
				from dbventas v 
					inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
				where v.cancelado = 0
				group by tc.idtipocerveza, tc.tipocerveza
				order by tc.tipocerveza
		";
		
		
		$sqlT = "select
			sum(v.cantidad)
		
		from dbventas v 
					inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
				where v.cancelado = 0
				";

		
	} else {
		$sql = "select
					tc.idtipocerveza, tc.tipocerveza, coalesce(sum(v.cantidad),0)
				from dbventas v 
					inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
				where v.cancelado = 0
				group by tc.idtipocerveza, tc.tipocerveza
				order by tc.tipocerveza
		";
		
		
		$sqlT = "select
			sum(v.cantidad)
		
		from dbventas v 
					inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
				where v.cancelado = 0
				";
	}
	
	$resT = mysql_result($this->query($sqlT,0),0,0);
	$resR = $this->query($sql,0);
	
	$cad	= "Morris.Donut({
              element: 'graph',
              data: [";
	$cadValue = '';
	if ($resT > 0) {
		while ($row = mysql_fetch_array($resR)) {
			$cadValue .= "{value: ".number_format(((100 * $row[2])	/ $resT),2).", label: '".$row[1]."'},";
		}
	}
	
/*
                {value: ".$porcentajeOportunidad.", label: 'Oportunidad'},
                {value: ".$porcentajeNormal.", label: 'Normal'},
                {value: ".$porcentajeCaro.", label: 'Caro'},
                {value: ".$porcentajeFueraMercado.", label: 'Fuera del Mercado'}*/
	$cad .= substr($cadValue,0,strlen($cadValue)-1);
    $cad .=          "],
              formatter: function (x) { return x + '%'}
            }).on('click', function(i, row){
              console.log(i, row);
            });";
			
	return $cad;	
}

/* FIN */
/* Fin */

function query($sql,$accion) {
		
		
		
		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();	
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];
		
		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
		
		mysql_select_db($database);
		
		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}
		
	}

}

?>