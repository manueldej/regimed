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
include('header.php');
include('script.php');

$sql_inc= mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysql_error());
$rowsql_inc= mysqli_fetch_array($sql_inc);
$codigorowsql_inc = $rowsql_inc['id_datos'];

$chmod_report = 'Los permisos del directorio y de los archivos no han podido ser cambiados.<br />Cambia los permisos de los archivos y directorios manualmente.';
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$sql_uactiva = "select * from datos_generales";
$result_uactiva= mysqli_query($miConex, $sql_uactiva);
$result_num= mysqli_num_rows($result_uactiva);

if (isset($_POST['idunidades'])){
	$sql_uaa = mysqli_query($miConex, "select * from datos_generales where id_datos='".$_POST['idunidades']."'") or die(mysql_error());
	$fectarr=mysqli_fetch_array($sql_uaa);
	$query_R = "SELECT * FROM areas where idunidades='".$fectarr['id_datos']."'";
}else{
	$query_R = "SELECT * FROM areas";
}

$Record = mysqli_query($miConex, $query_R) or die(mysql_error());
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

if (isset($_POST['idunidades']) AND isset($_POST['areaO'])){
	$sql_uaa = mysqli_query($miConex, "select * from datos_generales where id_datos='".$_POST['idunidades']."'") or die(mysql_error());
	$fectarr=mysqli_fetch_array($sql_uaa);
	$seare=mysqli_query($miConex, "select * from areas where idarea='".$_POST['areaO']."' AND idunidades='".$fectarr['id_datos']."'") or die(mysql_error());
	$rwseare = mysqli_fetch_array($seare);
	$query_AFT = "SELECT * FROM aft where id_area='".$rwseare['idarea']."' AND idunidades='".$fectarr['id_datos']."'";
}else{
	$query_AFT = "SELECT * FROM aft";
}

$RecordAFT = mysqli_query($miConex, $query_AFT) or die(mysql_error());
$totalRows_Recordset2AFT = mysqli_num_rows($RecordAFT);

	$roo = $_SERVER['DOCUMENT_ROOT'];
	$posicion = strripos($roo, "/");
	$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
	$ruta1 = $roo .$pht1;
	$ruta = substr($roo, 0, $posicion)."/tmp/"; 

	$rooZ = $_SERVER['DOCUMENT_ROOT'];
	$finZ =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$pht1Z = substr($finZ, 0, strlen($finZ)- strlen(basename($_SERVER['PHP_SELF'])));
	$rutaZ = $rooZ .$pht1Z."importar/";	

	$chmod_report = "Los permisos del directorio y de los archivos no han sido cambiados.";
	$file=$ruta1."incidencias_".$codigorowsql_inc.".sql";
	$filemode = 0777;
	$dirmode =0777;
	$chmodOk = TRUE;
	if (!mosChmodRecursive($file, 0777, 0777)) {
		$chmodOk = FALSE;
	}
	if ($chmodOk) {
		//echo 'Permisos del directorio y de los archivos cambiados.';
	} else {
	//	echo 'Los permisos del directorio y de los archivos no han podido ser cambiados.<br />Cambia los permisos de los archivos y directorios manualmente.';
	}

	function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL){
		$ret = TRUE;
				if (isset($filemode))
				$ret = @chmod($path, $filemode);
			return $ret;
	}			
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
		$err=array();
	if(isset($_POST['mete'])){	
		$metefecha = $_POST['fecha'];
		$meteincidencia = $_POST['incidencia'];
		$metearea = $_POST['area'];	
		$meteunidad = $_POST['idunidadesO'];	
		$meteinven = $_POST['medio'];	
		$inserinc = mysqli_query($miConex, "INSERT INTO incidencias value(NULL,'".$metefecha."','".$metearea."','".htmlentities($meteincidencia)."','".$meteinven."','".$meteunidad."')") or die(mysql_error());
		?><script type="text/javascript">document.location="incidencias.php";</script><?php		
	}
if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
	$marcado=$_POST['marcado'];
	unlink($rutaZ.$marcado);
	$fih= $marcado; ?>
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bteliminar." ".$ficher." ".$btsalvare;?></legend>
		<table width="100%" border="0" cellspacing="10" cellpadding="0">				<tr> 
					<td align="center"><div class="message"><?php echo sprintf($bteliminado,$fih);?>.<br></div></td>
				</tr>
		</table>
			<br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>		
	</fieldset>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
   document.location="incidencias.php";
</script><?php
	exit;
}
	if(isset($_POST['eliminarus'])){
		$marcado = $_POST['marcado'];		
		foreach($marcado as $key) {
			$deleteinc = mysqli_query($miConex, "DELETE FROM incidencias where id='".$key."'") or die(mysql_error());
		}  ?>
		<script type="text/javascript">document.location='incidencias.php';</script><?php
	}
		if(isset($_POST['editauser'])){
			$metefecha = $_POST['fecha'];
			$meteincidencia = $_POST['incidencia'];
			$metearea = $_POST['area'];	
			$meteunidad = $_POST['idunidadesO'];	
			$meteinven = $_POST['medio'];
			$marcado = $_POST['marcado'];
			$g=0;
			$sql = "SET FOREIGN_KEY_CHECKS=0;";
			mysqli_query($miConex, $sql) or die(mysql_error());	
			foreach($marcado as $key){
				$deleteinc = mysqli_query($miConex, "UPDATE incidencias SET inv='".$meteinven[$g]."', fecha='".$metefecha[$g]."', incidencia='".htmlentities($meteincidencia[$g])."', id_area='".$metearea[$g]."', idunidades='".$meteunidad[$g]."' where id='".$key."'") or die(mysql_error());
				$g++;
			}
			$sql = "SET FOREIGN_KEY_CHECKS=1;";
			mysqli_query($miConex, $sql) or die(mysql_error());				?>
			<script type="text/javascript">document.location='incidencias.php';</script><?php
		}

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_RecUni = "SELECT * FROM datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$query_RecUni = "SELECT * FROM datos_generales";
}
$RecUni = mysqli_query($miConex, $query_RecUni) or die(mysql_error());
$nuRecUni = mysqli_num_rows($RecUni);

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if((@$rsel['visitas']) !=""){
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
// SQL para la búsqueda
		$sql = "select * from incidencias";
		$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);			
	$result= mysqli_query($miConex, $query_limit) or die(mysql_error());
	
		
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
	$ggg=base64_encode($sql);
//NAVEGADOR	FIN
?>
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
<script type="text/JavaScript">

/***********************************************
* Form Field Progress Bar- By Ron Jonk- http://www.euronet.nl/~jonkr/
* Modified by Dynamic Drive for minor changes
* Script featured/ available at Dynamic Drive- http://www.dynamicdrive.com
* Please keep this notice intact
***********************************************/

function textCounter(field,counter,maxlimit,linecounter) {
	// text width//
	var fieldWidth =  parseInt(field.offsetWidth);
	var charcnt = field.value.length;        

	// trim the extra text
	if (charcnt > maxlimit) { 
		field.value = field.value.substring(0, maxlimit);
	}

	else { 
	// progress bar percentage
	var percentage = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
	document.getElementById(counter).style.width =  parseInt((fieldWidth*percentage)/100)+"px";
	document.getElementById(counter).innerHTML="Limite: "+percentage+"%"
	// color correction on style from CCFFF -> CC0000
	setcolor(document.getElementById(counter),percentage,"background-color");
	}
}

function setcolor(obj,percentage,prop){
	obj.style[prop] = "rgb(80%,"+(100-percentage)+"%,"+(100-percentage)+"%)";
}

</script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
include('jquery.php'); ?>
<script language="JavaScript" >
	function aaa() {

		// form validation check
		var formValid=false;
		var f = document.noinc;
		
		if ( f.idunidadesO.value == '' ) {
			showAlert(3000,'<div class="alert negro"><button class="close" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Seleccione la Entidad.".</b></div></div>');
			formValid=false;} 
		else if (f.area.value == '') {
			showAlert(3000,'<div class="alert negro"><button class="close" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Seleccione el Area".</b></div></div>');
			formValid=false;} 
		else if (f.medio.value == '-1') {
			showAlert(3000,'<div class="alert negro"><button class="close" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Seleccione el Medio".</b></div></div>');
			formValid=false;} 
		else if (f.fecha.value == '') {
			showAlert(3000,'<div class="alert negro"><button class="close" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>El campo -Fecha- esta en blanco.".</b></div></div>');
			f.fecha.focus();
			formValid=false;} 
		else if ( f.incidencia.value == '' ) {
			showAlert(3000,'<div class="alert negro"><button class="close" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Escriba la Incidencia".</b></div></div>');
			f.incidencia.focus(); 
			formValid=false; 	} 
		else {
			f.submit();
		}
		return formValid;
	}
		// Check for a blank field
		function cheqe() {
			// form validation check
			var formValid=false;
			var f = document.form1;
			if ( f.fecha.value == '' ) {
				alert('Por favor, debe escribir la Fecha');
				f.fecha.focus();
				formValid=false;
			} else	if ( f.estado.value == '' ) {
				alert('Por favor, debe escribir el Estado');
				f.estado.focus();
				formValid=false;
			} else if ( confirm('Son correctos los Datos?')) 
			  {	formValid=true;  }

			return formValid;
		}
		function eliminarI(de){
			 document.getElementById('eliminarusuario').style.display='block';
			 document.removeuser.removeus.value=de;	
		}
	</script>
<?php include('barra.php'); ?>	
	<div id="eliminarusuario" class="alert1 negro" style="display:none;">
		<div align="center">
			<form method="post" action="" name="removeuser" onSubmit="if((document.removeuser.directorio.value) ==''){ alert('Debe especificar un Directorio'); return false;}">
				<h1><img src="images/warning.png" border="0" width="20" height="20" align="absmiddle"><font color="red">ADVERTENCIA!!!</font> </h1>
				<div align="justify"><?php echo $seguro0 ;?></div><hr>
				<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
					<input type="hidden" name="removeus"/>
					<tr>
						<td>
							<div align="center">
								<input type="button" class="btn" name="cancela" onClick="document.getElementById('eliminarusuario').style.display='none';" value="<?php echo $btcancelar;?>">&nbsp;&nbsp;
								<input type="submit"  class="btn" name="eliminarus" value="<?php  echo $strOK;?>" />
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
<div id="buscad"> 
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bteditaunid0;?><span id="novo1"></span></legend><?php
	if(isset($_POST['edita'])){ 
	$marcado = $_POST['marcado'];	?>
		<div id="editausuario" style="display:block;"> 
			<div align="center">
				<form method="POST" action="" name="editaus" onSubmit="if((document.editaus.usernuevo.value) =='' OR (document.editaus.clavenueva.value) ==''){ alert('Debe llenar todos los campos'); return false;}">
					<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0"><?php
						$t=0;
						foreach($marcado as $key) { 
							$selinc = mysqli_query($miConex, "SELECT * FROM incidencias WHERE id='".$key."'") or die(mysql_error());
							$rselinc = mysqli_fetch_array($selinc);
							$sedg = mysqli_query($miConex, "SELECT * FROM datos_generales WHERE id_datos='".$rselinc['idunidades']."'") or die(mysql_error());
							$rsedg = mysqli_fetch_array($sedg);
							$searea = mysqli_query($miConex, "SELECT * FROM areas WHERE idarea='".$rselinc['id_area']."'") or die(mysql_error());
							$rsearea = mysqli_fetch_array($searea); ?>
							<tr>
								<td width="20%" align="right"><?php echo $btdatosentidad3;?>:</td>
								<td width="80%"><input name="idunidadesX[]" size="35" type="text" readonly class="imput" value="<?php echo $rsedg['entidad'];?>"><input name="idunidadesO[]" size="35" type="hidden" value="<?php echo $rsedg['id_datos'];?>"></td>
							</tr>
							<tr>
								<td align="right"><?php echo substr($btAreas,0,-1);?>:</td>
								<td><input name="areaX[]"  type="text" size="35" readonly class="imput" value="<?php echo $rsearea['nombre'];?>"><input name="area[]"  type="hidden" value="<?php echo $rsearea['idarea'];?>"></td>
							</tr>
							<tr>
								<td align="right">Inv:</td>
								<td><input name="medio[]"  type="text" size="35" readonly class="imput" value="<?php echo $rselinc['inv'];?>"></td>
							</tr>
							<tr>
								<td align="right"><?php echo $Fecha;?>:</td>
								<td>
									<input  name="fecha[]" required type="text" class="imput" id="fecha[<?php echo $t;?>]" value="<?php echo $rselinc['fecha'];?>">&nbsp;&nbsp;(dd/mm/aaaa  <font color="red">Ejmp: 01/01/2014</font>)
								</td>
							</tr>
							<tr>
								<td align="right" valign="top"><?php echo substr($Incidencias,0,-1);?>:</td>
								<td><script>textCounter(document.getElementById("incidencia"),"progressbar1",120)</script><textarea name="incidencia[]" id="incidencia" class="imputtextarea"  cols="70" rows="3" onKeyDown="textCounter(this,'progressbar1',120)" onKeyUp="textCounter(this,'progressbar1',120)" onFocus="textCounter(this,'progressbar1',120)" ><?php echo $rselinc['incidencia'];?></textarea></td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td><div id="progressbar1" class="progress-bar progress-bar-info"></div></td>
							</tr>
							<tr>
							  <td colspan="2"><hr><input name="marcado[]" type="hidden" value="<?php echo $rselinc['id'];?>"></td>
							</tr>
							<?php
							$t++;
						} ?>
						<tr>
							<td colspan="2">
								<div align="center"><input type="button" class="btn" name="cancela" onClick="document.location='incidencias.php';" value="<?php echo $btcancelar;?>">&nbsp;&nbsp;
								<input type="submit"  class="btn" name="editauser" value="<?php  echo $strOK;?>" /></div>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div><?php
	} ?><?php
	if(isset($_GET['m'])){ echo $chmod_report."<br>"; } ?>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div><?php
		if(isset($_REQUEST['palabra'])){ $palabra = $_REQUEST['palabra'];}
		    if(!isset($_POST['edita'])){  ?>
			<div id="cuerp"><?php
				if(($total_registros) >0){ ?>
					<div id="imprime" align="right">
						<table width="75px" border="0" cellspacing="2" cellpadding="1">
							<tr><?php 
							if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
							  <td class="email"><a class="tooltip" href="pdf/mail.php?tb=inci&gt=incidencias">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td><?php
							} ?>
							  <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?tb=inci">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
							  <td class="printer"><a class="tooltip" href="imprimir/index.php?registros=<?php echo $total_registros;?>&tb=inci" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
							</tr>
						 </table>	
					</div><br>
						<form name="frm1" method="post" action="">
							<table width="100%" BORDER='0' align="center" cellpadding="0" cellspacing="0"  class="table"> 
								<tr class="vistauser1"><?php 
									if (($rus1['tipo']) =="root"){ ?>
										<td width="1"></td><?php 
									} ?>
								  <td width="106"><span class="Estilo4"><b>INV.</b></span></td> 
									<td width="95"><span class="Estilo4"><b><?php echo strtoupper($Fecha);?></b></span></td>
									<td width="177"><span class="Estilo4"><b><?php echo $btAreas1;?></b></span></td>
									<td width="275"><span class="Estilo4"><b><?php echo strtoupper($Incidencias);?></b></span></td>
									<td width="224" align="left"><span class="Estilo4"><b><?php echo strtoupper($btdatosentidad3);?></b></span></td>
								</tr><?php
									$i=0;
								$p=0;
								WHILE ($row=mysqli_fetch_array($result)){ $i++;
									$seentid=mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$row["idunidades"]."'") or die(mysql_error());
									$rseentid=mysqli_fetch_array($seentid); 
									$searea=mysqli_query($miConex, "select * from areas where idarea='".$row["id_area"]."'") or die(mysql_error());
									$rsarea=mysqli_fetch_array($searea); ?>
									<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';"  onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $p;?>,'#ffffff');"><?php 
										if (($rus1['tipo']) =="root"){?>
											<td><input name="marcado[]" type="checkbox" class="boton" id="marcado[<?php echo $p;?>]" onClick="marca1(<?php echo $p;?>,'#ffffff')" value="<?php echo $row["id"]?>" /> </td><?php 
										} ?>
									  <td><a target="_parent" href='registromedios1.php?palabra=<?php echo $row["inv"];?>&rp=mt'><?php echo $row["inv"];?></a></td> 
										<td><?php echo $row["fecha"];?></td> 
										<td><?php echo $rsarea['nombre'];?></td>
										<td><?php echo $row["incidencia"];?></td>
										<td><?php echo $rseentid['entidad'];?></td>
									</tr><?php 
									$p++;		
								} ?>
								<tr>
									<td colspan="8"><hr></td>
								</tr><?php
								if (($rus1['tipo']) =="root"){ ?>
									  <tr> 
										<td colspan="6">
											<input name="eliminarus" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','');" type="submit" id="eliminarus" value="<?php echo $bteliminar;?>" class="btn">&nbsp;
											<input name="edita" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" id="edita" value="<?php echo $bteditar;?>" class="btn">&nbsp;
											<input name="nuevo" type="button" id="nuevo" value="<?php echo $new2.substr($Incidencias,0,-1);?>" class="btn"  onclick="document.getElementById('novo1').innerHTML='&nbsp;&nbsp;(<?php echo substr($new2,0,-1);?>)';document.getElementById('novo').style.display='block';document.getElementById('cuerp').style.display='none';">
										</td>
									  </tr>
									<?php
								} ?>
							</table>
						</form>
						<br>  <?php 
						include('navegador.php');
				}else{ ?>
					<table align="center" width="70%" border="0" cellspacing="2" cellpadding="2">
						<tr> 
							<td align="center">
								<br><div align="center"><div class="message" align="center"><?php echo $noregitro3.$btinsp;?></div></div><br><?php 
								if((@$rus1["tipo"]) =="root"){ ?>
									<input name="nuevo" type="button" id="nuevo" value="<?php echo $new2.substr($Incidencias,0,-1);?>" class="btn"  onclick="document.getElementById('novo1').innerHTML='&nbsp;&nbsp;(<?php echo substr($new2,0,-1);?>)';document.getElementById('novo').style.display='block';document.getElementById('cuerp').style.display='none';"><?php	
								} ?>
							</td>
						</tr>
					</table><?php 
				}  ?>
			</div><?php
			} ?><br>
	<div id="novo" style="display:none;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<form name="are" method="post" action=""><?php
				if(($result_num) ==1){ 
					$sql_uactivax = "select * from datos_generales";
					$result_uactivax= mysqli_query($miConex, $sql_uactivax);
					$rowentx = mysqli_fetch_array($result_uactivax); 	?>
					<tr>
						<td width="20%" align="right"><?php echo $btdatosentidad2;?>:</td>
						<td width="80%">&nbsp;&nbsp;<?php echo $rowentx['entidad'];?>
							<input name="idunidades" type="hidden" id="idunidades" value="<?php echo $rowentx['id_datos'];?>">
						</td>
					</tr><?php				
				}	else{ ?>
					<tr>
						<td width="20%" align="right"><?php echo $btdatosentidad2;?>:</td>
						<td width="80%">&nbsp;&nbsp;
							<select name="idunidades" class="combo_box" size="1" id="idunidades" onchange="if((this.value) !='-1'){ submit(); }">
								<option value="-1"><?php echo $seleccione.$LA.$btdatosentidad3;?></option><?php
								while($rowent = mysqli_fetch_array($result_uactiva)) {?>
										<option value="<?php echo $rowent['id_datos'];?>" <?php if(($rowent['id_datos']) ==@$_POST['idunidades']){ echo "selected";} ?>><?php echo $rowent['entidad']?></option><?php
								} ?>
							</select>
						</td>
					</tr>					
					<?php 
				} ?>
				<tr>
					<td align="right"><?php echo substr($btAreas,0,-1);?>:</td>
					<td>&nbsp;&nbsp;<?php
						if(($result_num) ==1){ 
							$query_R = "SELECT * FROM areas";
							$Record = mysqli_query($miConex, $query_R) or die(mysql_error());?>
							<select name="areaO" class="combo_box" size="1" id="areaO" onchange="if((this.value) !='-1'){ submit(); }">
								<option value="-1"><?php echo $plea8.substr($btAreas,0,-1);?></option><?php
									while ($row_R = mysqli_fetch_array($Record)) {
										if(($row_R['nombre']) !="Reparaciones"){?>
											<option value="<?php echo $row_R['idarea'];?>" <?php if((@$_POST['areaO']) ==$row_R['idarea']){ echo "selected";}?>><?php echo $row_R['nombre']?></option><?php
										}
									}  ?>
							</select><?php
						}else{  ?>
							<select name="areaO" class="combo_box" size="1" id="areaO" onchange="if((this.value) !='-1'){ submit(); }"><?php
								if(isset($_POST['idunidades'])){ ?><option value="-1"><?php echo $plea8.substr($btAreas,0,-1);?></option><?php
									while ($row_R = mysqli_fetch_array($Record)) {
										if(($row_R['nombre']) !="Reparaciones"){?>
											<option value="<?php echo $row_R['idarea'];?>" <?php if((@$_POST['areaO']) ==$row_R['idarea']){ echo "selected";}?>><?php echo $row_R['nombre']?></option><?php
										}
									}  
								} ?>
							</select><?php
						}?>
					</td>
				</tr>
			</form>
			<form name="noinc" id="noinc" method="post" action="">
				<tr>
					<td width="20%" align="right"><?php echo $btmedios;?>:</td>
					<td width="80%">&nbsp;&nbsp;
						<select name="medio" class="combo_box" size="1" id="medio"><?php
							if(isset($_POST['areaO'])){ ?>
								<option value="-1"><?php echo $plea8.substr($btmedios,0,-1);?></option><?php
								while ($row_AFT = mysqli_fetch_array($RecordAFT)) { ?>
									<option value="<?php echo $row_AFT['inv'];?>"><?php echo $row_AFT['descrip']." > ".$row_AFT['inv'];?></option><?php
								} 	
							}?>
							</select>
					</td>
				</tr>
				<tr>
					<td width="20%" align="right"><?php echo $Fecha;?>:</td>
					<td width="80%">
						<input onclick="if(self.gfPop)gfPop.fPopCalendar(document.noinc.fecha);return false;" name="fecha" required type="text" class="imput" readonly id="fecha">
						<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.noinc.fecha);return false;" hidefocus><img name="popcal" align="absmiddle" src="images/almana.png" width="25" height="22" border="0" title="" /></a>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><?php echo substr($Incidencias,0,-1);?>:</td>
					<td><textarea class="imputtextarea" name="incidencia" id="incidencia" cols="70" rows="3" onKeyDown="textCounter(this,'progressbar1',120)" onKeyUp="textCounter(this,'progressbar1',120)" required onFocus="textCounter(this,'progressbar1',120)"></textarea></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="progressbar1" class="progress-bar progress-bar-info"></div></td>
				</tr>
				<tr><td colspan="2"><hr><input name="area" id="area" type="hidden" value="<?php echo @$_POST['areaO'];?>"><input name="idunidadesO" id="idunidadesO" type="hidden" value="<?php echo @$_POST['idunidades'];?>"></td></tr>
				<tr>
					<td colspan="2"><input name="mete" id="mete" type="hidden">
						<input type="button" name="metea" value="Aceptar" class="btn" onclick="aaa();">&nbsp;
						<input name="cancel" type="button" class="btn" value="Cancelar" onclick="document.getElementById('novo1').innerHTML='';document.getElementById('novo').style.display='none';document.getElementById('cuerp').style.display='block';">
					</td>
				</tr>
			</form>	
		</table>		
	</div>
	<?php
	if(isset($_POST['idunidades'])){ ?>
		<script type="text/javascript">
			document.getElementById('novo1').innerHTML='&nbsp;&nbsp;(<?php echo substr($new2,0,-1);?>)';
			document.getElementById('novo').style.display='block';
			document.getElementById('cuerp').style.display='none';
		</script><?php
	}		?>
</fieldset><br><?php include ("version.php");?>
</div>
<iframe width="174" height="189" name="gToday:normal2:js/agenda2.js" id="gToday:normal2:js/agenda2.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<iframe width="174" height="189" name="gToday:normal1:agenda1.js" id="gToday:normal1:agenda1.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe>
