<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los términos de la Licencia Pública General GNU publicada por la Fundación de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versión 2 de la Licencia, o (en su opción)   #
# cualquier posterior versión. REGIMED es distribuido con la esperanza de que será útil, pero SIN CUALQUIER #
# GARANTÍA; Sin aún la garantía implícita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROPÓSITO PARTICULAR.  #
# Vea la Licencia Pública General del GNU para más detalles. Usted debería haber recibido una copia de la   #
# Licencia  Pública General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
include('script.php');
@session_start();
require_once('connections/miConex.php');
$versphpvieja = str_ireplace('.','',phpversion());
$versphpnueva = 540;
if($versphpvieja < $versphpnueva ){?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php 
}else{ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php 
}?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/template.css" rel="stylesheet">
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="ajax.js"></script> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/animatedcollapse.js"></script>
<?php  
function genera_talon() {
 include('connections/miConex.php');
	$fecha = date( 'Y-m-d' );
	
	$sql = "SELECT COUNT(id) as total FROM talones";
	$result = mysqli_query($miConex, $sql) or die(mysql_error());
	$rwe = mysqli_fetch_array($result);
	$total = $rwe['total'];
	
	if ($total !=0) {
	   $sql_ultimo = "SELECT * FROM talones ORDER BY id DESC";
	   $result_ultimo = mysqli_query($miConex, $sql_ultimo) or die(mysql_error());
	   $rwe_ultimo = mysqli_fetch_array($result_ultimo);
	
	   $sql_talon = "UPDATE talones SET estado='Terminado' WHERE id='".$rwe_ultimo['id']."'";
	   $result_talon = mysqli_query($miConex, $sql_talon) or die(mysql_error());
	   
	   $consecutivo = "Tal&oacute;n ".($total+1);
	   $sqlin ="insert into talones (id, nombre, fecha, estado) values (NULL, '".$consecutivo."','".$fecha."','Activo')";
	}else{
	   $consecutivo = "Tal&oacute;n 1";
	   $sqlin ="insert into talones (id, nombre, fecha, estado) values (NULL, '".$consecutivo."','".$fecha."','Activo')";
	}
 	$resultin = mysqli_query($miConex, $sqlin) or die(mysql_error());
}
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
if(($rus["tipo"]) =="root") { 
$cuantos = 5;
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);

if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$ordena=@$_REQUEST['ordena'];
    $i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if ($i=="es") {
	  include('esp.php');
	}else{
	  include('eng.php');
	}
 ///////navegador
		$inicio = 0; 
		$pagina = 1; 
		$registros = $cuantos;
	if(isset($_REQUEST["registros"])) {
		$registros = $_REQUEST["registros"];
		$inicio = 0; 
		$pagina = 1;
	}
	if(isset($_REQUEST['pagina']))  { 
		$pagina=$_REQUEST['pagina'];
		$inicio = ($pagina - 1) * $registros; 
	}
	if(isset($_REQUEST["mostrar"])) {
		$registros = $_REQUEST["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0; 
		$pagina = 1;
	}
///////////

if(isset($_POST['insertar'])){
	$vinicial= strtoupper ($_POST["vinicial"]);
	$vfinal= strtoupper ($_POST["vfinal"]);
	$digitos= $_REQUEST["digitos"];
	$prefijo= $_REQUEST["prefijo"];
	$fecha = date( 'Y-m-d' );

	if (isset($_REQUEST["separador"]) and ($_REQUEST["separador"]!='-1') and ($_REQUEST["prefijo"]!='')) {
	 $separador= $_REQUEST["separador"];
	}else{
	 $separador= "";
	}
	genera_talon();
	
	$sql = "SELECT * FROM talones order by id DESC";
	$result = mysqli_query($miConex, $sql) or die(mysql_error());
	$rwe = mysqli_fetch_array($result);
	$idTalo = $rwe['id'];
	
	for ($i=$vinicial; $i<=$vfinal; $i++) {
		$cadena =$prefijo.$separador.$i;
		$sql = "insert into sellos (id, numero, estado,idtalon) values (NULL, '".$cadena."','Disponible','".$idTalo."')";
		$result = mysqli_query($miConex, $sql) or die(mysql_error());
	} ?>
	<script type="text/javascript">window.parent.location='form-insertaraft.php';</script><?php 
}

$rowsella =0;	
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($qus);
$ta="";

$sqltalo ="SELECT * FROM talones where estado='Activo'";
$resultalo = mysqli_query($miConex, $sqltalo) or die (mysql_error());
$talon_act = mysqli_fetch_array($resultalo);
$total_registros =0;
$prefijo ="";

if(isset($_REQUEST['ta'])) { 
	$ta=$_REQUEST['ta'];
	$sql4 = "select * from sellos where idtalon='".$ta."' limit $inicio, $registros";
	$sellaje = "select * from sellos where estado='Disponible' and idtalon='".$ta."' limit $inicio, $registros";
	$esta = $_REQUEST['est'];
	$sqlsello ="SELECT * FROM sellos WHERE idtalon='".$ta."'";
	$resultados = mysqli_query($miConex, $sqlsello) or die (mysql_error());
}else{
   $sql4 = "select * from sellos WHERE idtalon='".$talon_act['id']."' limit $inicio, $registros";
   $sellaje = "select * from sellos where estado='Disponible' limit $inicio, $registros";
   $esta ="Activo";
   $sqlsello ="SELECT * FROM sellos WHERE idtalon='".$talon_act['id']."'";
   $resultados = mysqli_query($miConex, $sqlsello) or die (mysql_error());
}

//Verificar si existen sellos disponibles, sino creo talones
$qsellaje = mysqli_query($miConex, $sellaje) or die(mysql_error());
$rowsella = mysqli_num_rows($qsellaje);


$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

$sqltalones ="SELECT * FROM talones";
$resultalon = mysqli_query($miConex, $sqltalones) or die (mysql_error());

$sqlsess ="SELECT * FROM sellos WHERE estado='Disponible'";
$ressess = mysqli_query($miConex, $sqlsess) or die (mysql_error());
$rowsess = mysqli_num_rows($ressess);

$result= mysqli_query($miConex, $sql4);
$totalsellos = mysqli_num_rows($result);
$ggg= base64_decode($sql4);

?>
<form action="" method="post" name="contel" id="contel">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="sellos.php" method="post" name="talona">
	<input name="ta" value="" type="hidden">
	<input name="est" value="" type="hidden">
</form>
<form action="" method="post" name="conted" id="conted">
	<input name="edit" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="" method="post" name="nuevo" id="nuevo">
	<input name="insert" value="1" type="hidden">
</form>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<SCRIPT language='javascript'>
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
	
</script>
<style type="text/css">
	.email{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -37px;
	}
	.pdf{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -117px;
	}
	.exel{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -97px;
	}
	.printer{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -17px;
	}
</style>
<script language="javascript">
	function cambiasello(estado,id,idobv) {
		if (estado=="Desechado") {
		  if (document.getElementById(id).style.display=='none') { 
			document.getElementById(id).style.display='block';
			document.getElementById(idobv).focus();
		  }else{
			document.getElementById(id).style.display='none';  
		  }		
	    }
	}
	function manda(valor,estado) {
	  document.talona.ta.value=valor;
	  document.talona.est.value=estado;
	  document.talona.submit();
	}
</script>
<?php 
    if(isset($_REQUEST['modificado'])){
		$idx=$_REQUEST['id'];
		$pestado=$_REQUEST['estado'];
		$observ=$_REQUEST['obsv'];
		$x=0;
		foreach($idx as $key){
			$upx ="update sellos set estado='".$pestado[$x]."',observ='".$observ[$x]."' WHERE id='".$key."'";
			$qupx =mysqli_query($miConex, $upx) or die(mysql_error());
			$x++;
		}
		?><script type="text/javascript">document.location='sellos.php';</script><?php
	}
?>
	<?php if($rowsess == 0) { ?>
	<br>
	<form name="frm1" method="post" action="">        
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
		<tr>
			<td width="90" align="center"><?php echo $sprefijo; ?>&nbsp;<input name="nros" id="nros" type="radio" value="<?php echo $nros;?>" style="cursor:pointer;" checked onclick="document.getElementById('mixto').checked=false; document.getElementById('digitos').style.display='none';"></td> 
			<td width="70" align="center"><?php echo $cprefijo; ?>&nbsp;<input name="mixto" id="mixto" type="radio" value="<?php echo $mixto;?>" style="cursor:pointer;" onclick="document.getElementById('nros').checked=false; document.getElementById('digitos').style.display='block';"></td>
			<td width="400"><span id="digitos" style="width:29%; position: absolute; margin-left: -1%; margin-top: 1px; display:none;">
				<input name="prefijo" id="prefijo" type="text" class="form-control" style="width: 60px;" maxlength="5" value="" placeholder="Prefijo">
					<select name="separador" id="separador" class="form-control" style="margin-top: -23px; width: 66px; margin-left: 64px;">
						<option value="-1">---</option>
						<option value="-">-</option>
						<option value=".">.</option>
					</select></span>
			</td>
		</tr>
		<tr>	
			<td><b><?php echo $btValor.'&nbsp;'.$Inicial; ?></b></td>
			<td><b><?php echo $btValor.'&nbsp;'.$vfinal; ?></b></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="147" class="Estilo2"><input name="vinicial" id="vinicial" type="text" maxlength="4" class="form-control" value="1" onblur="if(this.value =='') {this.value='1';}" onkeypress="return acceptNum(event); return handleEnter(this, event);" onclick="this.value='';" /></td>
			<td width="145" height="21"><input name="vfinal" id="vfinal" type="text" maxlength="4" class="form-control" value="" onkeyup="document.frm1.digitos.value=(this.value.length); return acceptNum(event);" onclick="this.value='';" /></td>
			<td><input name="digitos" id="vea" type="text" style="margin-top: -1px; width: 15%; background: rgb(77, 94, 108) none repeat scroll 0% 0%; color: rgb(246, 252, 252); padding: 0px 0px 0px 10px;" maxlength="3" value="4" class="mostrar" readonly>D&iacute;gitos</td>
		</tr>
		<tr align="center">
			<td colspan="3" valign="top"><hr>
				<input name="insertar" type="submit" class="btn"  value="<?php echo $btinsertar;?>" />
			</td> 
		</tr>
	</table>
	</form>		
					<?php	} ?>
			
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<?php } ?>
