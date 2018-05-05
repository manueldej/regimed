<?php 
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include ('connections/miConex.php');
class colores {
	public function ColorFila($i,$color1,$color2){
		if (($i % 2)== 0) {
			$this->ColorFondo = $color1;
		}else {
			$this->ColorFondo = $color2;
		}
		return $this->ColorFondo;
	}
}
$color1="#F1F2F3";
$color2="#E9EAEB";
$uCPanel = new colores();
$epdt="";
$epdt0="";
$epdt1="";
$Uact = "";

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$sql_bajas ="select * from bajas_aft";

$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}

///////navegador
		$inicio = 0; 
		$pagina = 1; 
		$registros = $cuantos;
		
	if(isset($_GET["registros"])) {
		$registros = $_GET["registros"];
		$inicio = 0; 
		$pagina = 1;
	}
	if(isset($_GET['pagina']))  { 
		$pagina=$_GET['pagina'];
		$inicio = ($pagina - 1) * $registros; 
	}
	if(isset($_GET["mostrar"])) {
		$registros = $_GET["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0; 
		$pagina = 1;
	}
///////////
$resultados = mysqli_query($miConex, "SELECT * FROM bajas_aft") or die(mysql_error());
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql_uactiva = "select * from datos_generales WHERE id_datos='".$_COOKIE['unidades']."'";
	}else{
		$sql_uactiva = "select * from datos_generales";
	}
	$result_uactiva= mysqli_query($miConex, $sql_uactiva);
	$ractiva = mysqli_fetch_array($result_uactiva);
	$Uact = $ractiva['id_datos'];
	$entidd = $ractiva['entidad'];

	//en uso
		if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$consulta  = "SELECT COUNT(estado) as enuso FROM aft WHERE  estado = 'A' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
		}else{
			$consulta  = "SELECT COUNT(estado) as enuso FROM aft WHERE  estado = 'A' AND categ='COMPUTADORAS'";
		}						
		$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
		$uso = mysqli_fetch_array($resultado1);
	
		//en red
		if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$consultared  = "SELECT COUNT(enred) as enred1 FROM aft WHERE enred = 's' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
		}else{
			$consultared  = "SELECT COUNT(enred) as enred1 FROM aft WHERE enred = 's' AND categ='COMPUTADORAS'";
		}						
			$resultado1red = mysqli_query($miConex, $consultared) or die("La consulta fall&oacute;: " . mysql_error());
			$enlared = mysqli_fetch_array($resultado1red);
			//internet
		if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$consultainternet  = "SELECT COUNT(conect) as internet FROM aft WHERE conect = 'Internet' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
		}else{
			$consultainternet  = "SELECT COUNT(conect) as internet FROM aft WHERE conect = 'Internet' AND categ='COMPUTADORAS'";
		}						
			$resultado1internet = mysqli_query($miConex, $consultainternet) or die("La consulta fall&oacute;: " . mysql_error());
			$internet = mysqli_fetch_array($resultado1internet);
			//intranet
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consultaintranet  = "SELECT COUNT(conect) as intranet FROM aft WHERE conect = 'Intranet' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
			}else{
				$consultaintranet  = "SELECT COUNT(conect) as intranet FROM aft WHERE conect = 'Intranet' AND categ='COMPUTADORAS'";
			}						
			$resultado1intranet = mysqli_query($miConex, $consultaintranet) or die("La consulta fall&oacute;: " . mysql_error());
			$intranet = mysqli_fetch_array($resultado1intranet);
			//ROTAS
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consultarotas  = "SELECT COUNT(estado) as irotas FROM aft WHERE estado = 'R' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
			}else{
				$consultarotas  = "SELECT COUNT(estado) as irotas FROM aft WHERE estado = 'R' AND categ='COMPUTADORAS'";
			}						
			$resultado1rotas = mysqli_query($miConex, $consultarotas) or die("La consulta fall&oacute;: " . mysql_error());
			$irotas = mysqli_fetch_array($resultado1rotas);
			//PROPUESTA BAJA
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consultapbajas  = "SELECT COUNT(estado) as ipbajas FROM bajas_aft WHERE estado = 'P' AND categ='".@strtoupper($name1)."' AND idunidades='".$Uact."'";
			}else{
				$consultapbajas  = "SELECT COUNT(estado) as ipbajas FROM bajas_aft WHERE estado = 'P' AND categ='".@strtoupper($name1)."'";
			}
				$resultado1pbajas = mysqli_query($miConex, $consultapbajas) or die("La consulta fall&oacute;: " . mysql_error());
				$ipbajas = mysqli_fetch_array($resultado1pbajas);

				$TG  = $uso['enuso'] + $irotas['irotas'] + $ipbajas['ipbajas']; 
function total($campo, $miConex){
//contar las PC propuestas a baja
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(estado) as valor_col1 FROM bajas_aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND estado = 'P' AND categ='COMPUTADORAS'"; 
			}else{
				$consulta  = "SELECT COUNT(estado) as valor_col1 FROM bajas_aft WHERE id_area = '".$_GET['exped']."' AND estado = 'P' AND categ='COMPUTADORAS'";
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(estado) as valor_col1 FROM bajas_aft where idunidades='".$_COOKIE['unidades']."' AND estado = 'P' AND categ='COMPUTADORAS'";
			}else{
				$consulta  = "SELECT COUNT(estado) as valor_col1 FROM bajas_aft WHERE id_area = '".$_GET['exped']."' AND estado = 'P' AND categ='COMPUTADORAS'";
			}
		}
 
	$resultado1 = mysqli_query($miConex, $consulta) or die(mysql_error());
	$linea2 = mysqli_fetch_array($resultado1);
   	settype($linea2['valor_col1'], "integer"); 
	$pbaja = $linea2['valor_col1']; //estas los la P
//contar las pc en uso
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas WHERE idarea = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."'"; 
			}else{
				$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas WHERE idarea = '".$_GET['exped']."'";
				
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where idunidades='".$_COOKIE['unidades']."'";
			}else{
				$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas";
			}
		}
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
	settype($linea['valor_col'], "integer"); //Estas son las A
	$estanenuso = $linea['valor_col'];
//contar las pc en reparaciones
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consultarepar  = "SELECT COUNT(estado) as repar FROM aft WHERE idarea = 'Reparaciones' AND estado='R' AND idunidades='".$_COOKIE['unidades']."' AND id_area = '".$_GET['exped']."' AND categ = 'COMPUTADORAS'"; 
			}else{
				$consultarepar  = "SELECT COUNT(estado) as repar FROM aft WHERE idarea = 'Reparaciones' AND estado='R' AND id_area = '".$_GET['exped']."' AND categ = 'COMPUTADORAS'"; 
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consultarepar  = "SELECT COUNT(estado) as repar FROM aft where idunidades='".$_COOKIE['unidades']."' AND idarea = 'Reparaciones AND estado='R' AND id_area = '".$_GET['exped']."' AND categ = 'COMPUTADORAS'"; 
			}else{
				$consultarepar  = "SELECT COUNT(estado) as repar FROM aft where idarea = 'Reparaciones' AND estado='R' AND id_area = '".$_GET['exped']."' AND categ = 'COMPUTADORAS'"; 
			}
		}	

	$resultado1repar = mysqli_query($miConex, $consultarepar) or die("La consulta fall&oacute;: " . mysql_error());
	$linearepar = mysqli_fetch_array($resultado1repar);
	settype($linearepar['repar'], "integer"); //estas son las R
 
	$plinearepar = $linearepar['repar'];

	//suma de las p.bajas y las en uso
	echo $estanenuso + $pbaja + $plinearepar;   
}
function enuso($campo, $miConex){
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND estado = 'A' AND categ='COMPUTADORAS'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND estado = 'A' AND categ='COMPUTADORAS'";
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft where idunidades='".$_COOKIE['unidades']."' AND estado = 'A' AND categ='COMPUTADORAS'";
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND estado = 'A' AND categ='COMPUTADORAS'";
			}
		}
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
   
	echo $linea['valor_col'];
}
function rotas($campo, $miConex){
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND estado = 'R' AND categ='COMPUTADORAS'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND estado = 'R' AND categ='COMPUTADORAS'";
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft where idunidades='".$_COOKIE['unidades']."' AND estado = 'R' AND categ='COMPUTADORAS'";
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND estado = 'R' AND categ='COMPUTADORAS'";
			}
		}
 
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
   
	return $linea['valor_col'];
}
function pbajas($campo, $miConex){
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col1 FROM bajas_aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND estado = 'P' AND categ='COMPUTADORAS'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col1 FROM bajas_aft WHERE id_area = '".$_GET['exped']."' AND estado = 'P' AND categ='COMPUTADORAS'";
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col1 FROM bajas_aft where idunidades='".$_COOKIE['unidades']."' AND estado = 'P' AND categ='COMPUTADORAS'";
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col1 FROM bajas_aft WHERE id_area = '".$_GET['exped']."' AND estado = 'P' AND categ='COMPUTADORAS'";
			}
		}
 
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea2 = mysqli_fetch_array($resultado1);
   	settype($linea2['valor_col1'], "integer"); 
	return $linea2['valor_col1'];
}
function enred($campo, $miConex){
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND enred = 's'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND enred = 's'"; 
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft where idunidades='".$_COOKIE['unidades']."' AND enred = 's'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND enred = 's'"; 
			}
		}
 
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
   	settype($linea['valor_col'], "integer"); 
	return $linea['valor_col'];
}
function inter($campo, $miConex){
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND conect = 'Internet'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND conect = 'Internet'";
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft where idunidades='".$_COOKIE['unidades']."' AND conect = 'Internet'";
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND conect = 'Internet'";
			}
		}
 
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
   	settype($linea['valor_col'], "integer"); 
	return $linea['valor_col'];
}
function intra($campo, $miConex){
		if(isset($_GET['exped'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND idunidades='".$_COOKIE['unidades']."' AND conect = 'Intranet'"; 
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND conect = 'Intranet'";
			}
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft where idunidades='".$_COOKIE['unidades']."' AND conect = 'Intranet'";
			}else{
				$consulta  = "SELECT COUNT(".$campo.") as valor_col FROM aft WHERE id_area = '".$_GET['exped']."' AND conect = 'Intranet'";
			}
		}
 
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
   	settype($linea['valor_col'], "integer"); 
	return $linea['valor_col'];
}
	if(isset($_GET['ini'])){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$epdt= " WHERE (nombre !='Reparaciones') AND (idunidades='".$_COOKIE['unidades']."')";
		}else{
			$epdt= " WHERE (nombre !='Reparaciones') ORDER BY nombre";
		}
		$epdt1= " LIMIT ".$_GET['ini'].",".$_GET['reg'];

		$sql = "SELECT * FROM areas ".$epdt.$epdt1;
		$sql_bajas ="select * from bajas_aft";
		$result= mysqli_query($miConex, $sql) or die(mysql_error());
		$numero_reg= mysqli_num_rows($result);
		$result_bajas = mysqli_query($miConex, $sql_bajas) or die(mysql_error());
		$total_bajas=mysqli_num_rows($result_bajas);
	}else{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$epdt= " WHERE idunidades='".$_COOKIE['unidades']."' ";
		}else{
			$epdt= " ";
		}
		
		if(isset($_GET['exped'])){	
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$epdt .= " AND idarea = '".$_GET['exped']."'"; 
			}else{
				$epdt .= " WHERE idarea = '".$_GET['exped']."'"; 
			}
			$sql_bajas ="select * from bajas_aft WHERE id_area='".$_GET['exped']."'";
			$result_bajas = mysqli_query($miConex, $sql_bajas) or die(mysql_error());
		    $total_bajas=mysqli_num_rows($result_bajas);
			
		}
		
		$sql = "SELECT * FROM areas ".$epdt;
		
		
		$result= mysqli_query($miConex, $sql) or die(mysql_error());
		$row=mysqli_fetch_array($result);
		$numero_reg= mysqli_num_rows($result);
		
	
    }

	$resulti= mysqli_query($miConex, $sql_bajas) or die(mysql_error());
	$totalbaj=mysqli_num_rows($resulti);
	$ggg=base64_encode($sql_bajas); 
	$total_registros=$totalbaj;
	
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	if(!isset($_GET['a']) OR isset($_GET['marcado'])){ ?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<fieldset class='fieldset'>
<legend class="vistauserx"><?php echo strtoupper($otrosdet1)." "; 
	if(!isset($_REQUEST['ini']) AND (!isset($_COOKIE['unidades']))){ 		
		$sqla = "SELECT * FROM areas ".$epdt.$epdt1;
		$resulta= mysqli_query($miConex, $sqla) or die(mysql_error());
		$rowa=mysqli_fetch_assoc($resulta);
		$sedgs = mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$rowa['idunidades']."'") or die(mysql_error());
		$rsedgs=mysqli_fetch_assoc($sedgs);
		echo strtoupper($DEL).$btAreas1." -> <font color='red'>".$row['nombre']."</font>&nbsp;".$unidad."-><font color=red>".$rsedgs['entidad']."</font>";
	}elseif (!isset($_COOKIE['unidades'])){					
		echo strtoupper(" ".$de.$otrosdet2);
	}else {
		$sedgs = mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$_COOKIE['unidades']."'") or die(mysql_error());
		$rsedgs=mysqli_fetch_assoc($sedgs);	
		echo $unidad."-><font color=red>".$rsedgs['entidad']."</font>"; 
	} ?>
</legend><?php
	        if(!isset($_GET['ini'])){ ?>
		<table width="100%" border='0' class='sgf1' align='center' >
			<tr> 
		       <td class="vistauser1"  align="center" ><b>
				<?php $fields = mysqli_fetch_field_direct ($result, 1); echo strtoupper($fields->name); ?></b>
				</td>
					<?php 				
						for($n=15; $n<=mysqli_num_fields($result)-2; $n++){ 
							$fields = mysqli_fetch_field_direct ($result, $n); 
							$name1 = $fields->name;
							$flags = $fields->flags;
					 ?>
							<td class="vistauser1" align="center"><b><?php if((strlen(strtoupper($name1))) >7){ echo substr(strtoupper($name1),0,-3);}else { echo strtoupper($name1);}?></b></td><?php 	
						} ?>
					</tr> <?php
						if(($row["nombre"]) !="Reparaciones"){   	?>	
							<tr>
							   <td align="center"><?php echo $row['nombre'];?></td><?php 
								for($n=15; $n<=mysqli_num_fields($result)-2; $n++){ 
									$fields = mysqli_fetch_field_direct ($result, $n); 
									$name1 = $fields->name;
									$flags = $fields->flags;?>
									<td align="center"><?php echo $row[$name1];?></td><?php 
								} ?>
							</tr><?php
						} ?>
		</table>
		<table width="100%" cellspacing="0" class="sgf1" align="center" >
			<tr>
				<td width="10%" align="center" class="vistauser1"><b><span>Total PC</span></b></td>
				<td width="8%"  align="center" class="vistauser1"><b><?php echo $btenuso;?></b></td>
				<td width="21%" align="center"class="vistauser1"><b><?php echo $btrotas;?></b></td>
				<td width="22%" align="center"class="vistauser1"><b><?php echo $btPBajas;?></b></td>
				<td width="10%" align="center"class="vistauser1"><b><?php echo $btenred;?></b></td>
				<td width="13%" align="center"class="vistauser1"><b>Internet</b></td>
				<td width="16%" align="center"class="vistauser1"><b>Intranet</b> </td>
			</tr> <?php
			    if(($row["nombre"]) !="Reparaciones"){ ?>	
			<tr>
			    <td align="center"><span class="badge"><b><?php echo total('computadoras',$miConex); ?></b></span></td>
				<td align="center"><span class="badge"><b><?php echo enuso('estado', $miConex);?></b></span></td>
                <td align="center"><span class="badge"><b><?php if((rotas('estado', $miConex)) !=0){ ?><a href="defectuosos.php"><?php echo rotas('estado', $miConex);?></a><?php }else{ echo rotas('estado', $miConex);} ?></b></span></td>
                <td align="center"><span class="badge"><b><a href="bajas.php"><?php echo pbajas('estado',$miConex);?></a></b></span></td>
                <td align="center"><span class="badge"><b><?php echo enred('id_area',$miConex);?></b></span></td>
                <td align="center"><span class="badge"><b><?php echo inter('id_area',$miConex);?></b></span></td>
                <td align="center"><span class="badge"><b><?php echo intra('id_area',$miConex);?></b></span></td>
			<tr><?php
			    } ?>
				</table><?php
			} else{ ?>	
				<table width="100%" BORDER='0' class='sgf1' align='center' cellpadding="0" cellspacing="0">
					<tr>
					    <td class="vistauser1"><b>
						<?php $field = mysqli_fetch_field_direct ($result, 1); echo strtoupper($field->name); ?></b>
						</td><?php 						
						for($n=15; $n<=mysqli_num_fields($result)-2; $n++){ 
							$field = mysqli_fetch_field_direct ($result, $n);
							$name1  = $field->name;
							$flags = $field->flags; ?>
							<td class="vistauser1" align="center"  ><b>
							<?php if((strlen(strtoupper($name1))) >7){ echo substr(strtoupper($name1),0,-4);}else { echo strtoupper($name1);}?></b>
							</td><?php 
						} ?>
					</tr><?php 	
					$id =0;
					$idd=0;
					$p=0;
					for ($g=0; $g<=$numero_reg; $g++){ $row=mysqli_fetch_array($result);$idd++;	
						if(($row["nombre"]) !="Reparaciones"){   	?>	
							<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#FCF8E2');">
							   <td><?php echo $row['nombre'];?></td><?php 
								for($n=15; $n<=mysqli_num_fields($result)-2; $n++){ 
									$field = mysqli_fetch_field_direct ($result, $n);
									$name1  = $field->name;
									$flags = $field->flags;  ?>
									<td align="center"><?php echo $row[$name1];?></td><?php 
								} ?>
							</tr><?php
						} $p++;
					}  ?>					   
				</table>
				<table width="100%" border="0" cellspacing="0" class="sgf1" align="center" >
					<tr>
						<td width="10%" align="center" class="vistauser1"><b><span>Total PC</span></b></td>
						<td width="8%"  align="center" class="vistauser1"><b>En Uso</b></td>
						<td width="21%" align="center"class="vistauser1"><b>Rotas</b></td>
						<td width="22%" align="center"class="vistauser1"><b>P. Bajas</b></td>
						<td width="10%" align="center"class="vistauser1"><b>En Red</b></td>
						<td width="13%" align="center"class="vistauser1"><b>Internet</b></td>
						<td width="16%" align="center"class="vistauser1"><b>Intranet</b> </td>
					</tr> <?php
						if(($row["nombre"]) !="Reparaciones"){?>	
					<tr>
						<td align="center"><span class="badge"><b><a href="registromedios1.php?pagina=1&mostrar=<?php echo $TG;?>&mo=Ir&total_paginas=6&palabra=computadoras&total_registros=<?php echo $TG;?>&orderby=id_area&asc=ASC&m=m"><?php echo $TG;?></a></b></span></td>
						<td align="center"><span class="badge"><b><a href="registromedios1.php?pagina=1&mostrar=<?php echo $uso['enuso'];?>&mo=Ir&total_paginas=6&palabra=computadoras&total_registros=<?php echo $uso['enuso'];?>&orderby=id_area&asc=ASC&m=m"><?php echo $uso['enuso'];?></a></b></span></td>
                        <td align="center"><span class="badge"><b><?php if(($irotas['irotas']) !=0){ ?><a href="defectuosos.php"><?php echo $irotas['irotas'];?></a><?php }else{ echo $irotas['irotas'];} ?></b></span></td>
                        <td align="center"><span class="badge"><b><a href="bajas.php"><?php echo $ipbajas['ipbajas'];?></a></b></span></td>
                        <td align="center"><span class="badge"><b><?php echo $enlared['enred1'];?></b></span></td>
                        <td align="center"><span class="badge"><b><?php echo $internet['internet'];?></b></span></td>
                        <td align="center"><span class="badge"><b><?php echo $intranet['intranet'];?></b></span></td>
					</tr><?php
						} ?>
				</table>
		<?php 
			}?>
		<?php if ($total_registros!=0) { ?>
		<fieldset class='fieldset'>
		<legend class="vistauserx"><?php echo strtoupper($mostrar1.$de.$btbajas)." "; 
			if(!isset($_REQUEST['ini']) AND (!isset($_COOKIE['unidades']))){ 		
				$sqla = "SELECT * FROM areas ".$epdt.$epdt1;
				$resulta= mysqli_query($miConex, $sqla) or die(mysql_error());
				$rowa=mysqli_fetch_assoc($resulta);
				$sedgs = mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$rowa['idunidades']."'") or die(mysql_error());
				$rsedgs=mysqli_fetch_assoc($sedgs);
				echo strtoupper($DEL).$btAreas1." -> <font color='red'>".$row['nombre']."</font>&nbsp;".$unidad."-><font color=red>".$rsedgs['entidad']."</font>";
			}elseif (!isset($_COOKIE['unidades'])){					
				echo strtoupper(" ".$de.$otrosdet2);
			}else {
				$sedgs = mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$_COOKIE['unidades']."'") or die(mysql_error());
				$rsedgs=mysqli_fetch_assoc($sedgs);	
				echo $unidad."-><font color=red>".$rsedgs['entidad']."</font>"; 
			} ?>
		</legend>
		
		<?php 
		$usx = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION["valid_user"]."'") or die(mysql_error());
		$russx = mysqli_fetch_array($usx);
		
		if(($russx['tipo']) =="root"){ 
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
			$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
			$ruta = $roo."/".substr($pht1,1);
			$file = "RegistroBajasy.txt";
			$i="es";
			if(isset($_COOKIE['seulang'])){
				if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
			}
		   if(($i) =="es"){include('esp.php');}else{ include('eng.php');} 
			$i=0;
			$array = array();
			$array1 = array();
			$gg=0;		
			$g=0;
		 ?>
		<link href="css/template.css" rel="stylesheet" type="text/css" />	
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">	
		<form name="frm1" action="" method="post"><?php 
			if(($totalbaj) !=0){ ?>		
				<tr class="vistauser1"> 
					<td colspan="2" class="vistauser1"></td>
					<td class="vistauser1"><strong><span class="Estilo4">INV</span></strong></td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo $btAreas;?></span></strong></td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></strong></td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo strtoupper($btAprueba);?></span></strong> </td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo strtoupper($ficher1);?></span></strong></td>
				    <td class="vistauser1"><strong><span class="Estilo4"><?php echo $btdatosentidad3;?></span></strong></td>  
				</tr><?php
				$p=0;
				$i=0;
					while($rows=mysqli_fetch_array($resulti)){ $i++; 
						$sedge=mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$rows['idunidades']."'") or die(mysql_error());
						$rsedge=mysqli_fetch_array($sedge); ?>
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  <?php if(($russx['tipo']) =="root" ){ ?> onClick="detalles('<?php echo $rows["id"]?>'); marca1(<?php echo $p;?>,'#ffffff');  <?php if(($rows['link']) !=""){ ?>dele1();<?php } ?>"<?php } ?>> 
							<td width="23">&nbsp;</td>
							<td width="28"> <?php 
								if(($rows['tiene']) =="s") { ?>
									<a target="_blank" href="<?php echo $rows['link'];?>"><img src="images/090910_folder.png" width="25" height="25" border="0"/></a> <?php 
								}else{ ?>
									<img src="images/090819_folders.png" width="25" height="25" /> <?php 
								}?>							</td>
							<td width="83"><?php echo $rows['inv'];?></td>
							<td width="208"><?php echo $rows['idarea'];?>
						  <input name="link[]" type="hidden" value="<?php echo $rows['link'];?>"></td>
							<td width="85"><?php echo $rows['fecha'];?></td>
							<td width="96"><?php echo $rows['organo'];?></td>
							<td width="158"><?php echo $rows['titulo'];?></td>
						    <td width="198"><?php echo $rsedge['entidad'];?></td>
						</tr>  <?php
						$p++;
					}
				  	include('navegador.php');
			}  ?>		
		</form>
	    </table>
			<?php 
		//} ?>
		</fieldset>
		<?php
		
	    }
	  } ?>
<?php } ?>