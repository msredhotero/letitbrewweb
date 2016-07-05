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


function eliminarVentas($id) {
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
$sql = "select idventa,tc.tipocerveza,cantidad,cantidad * precioventa,usuario,fechaventa,cancelado,v.observaciones 
			from dbventas v 
			inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
			where	v.fechaventa >= concat(cast(curdate() as CHAR),' ','14:00:00')
					and v.fechaventa <= DATE_ADD(cast(concat(cast(curdate() as CHAR),' ','14:00:00') as date), interval 28 hour) 
			order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerVentasPorFechas() {
$sql = "select idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones from dbventas order by 1";
$res = $this->query($sql,0);
return $res;
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
$sql = "select idventa,tc.tipocerveza,cantidad,cantidad * precioventa,usuario,fechaventa,cancelado,v.observaciones 
			from dbventas v 
			inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
			where	v.fechaventa >= concat(cast(curdate() as CHAR),' ','14:00:00')
					and v.fechaventa <= DATE_ADD(cast(concat(cast(curdate() as CHAR),' ','14:00:00') as date), interval 28 hour) 
					and v.reftipocerveza = ".$refTipoCerveza."
			order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerVentasPorDiaTipoCervezaLitros($refTipoCerveza) {
	$sql = "select sum(cantidad) as litros
				from dbventas v 
				inner join tbtipocervezas tc on tc.idtipocerveza = v.reftipocerveza
				where	v.fechaventa >= concat(cast(curdate() as CHAR),' ','14:00:00')
						and v.fechaventa <= DATE_ADD(cast(concat(cast(curdate() as CHAR),' ','14:00:00') as date), interval 28 hour) 
						and v.reftipocerveza = ".$refTipoCerveza."
				";
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,0);
	}
	
	return 0;
}


function traerVentasPorId($id) {
$sql = "select idventa,reftipocerveza,precioventa,cantidad,usuario,fechaventa,cancelado,observaciones from dbventas where idventa =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */

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