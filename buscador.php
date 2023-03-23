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
require('mensaje.php');
if(isset($_GET['l'])){
	$sql = "TRUNCATE `buscador`";
	mysqli_query($miConex, $sql) or die(mysqli_error());	
}
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysqli_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
?>
<style type="text/css">
<!--
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}

.bodyText {
	font:12px Arial, Helvetica, sans-serif;
	color:#666666;
	line-height:20px;
	margin-top:0px;
	}
-->
</style>
<?php include('barra.php');?>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
	function escribe(){
		if((document.header.texto.value) =="<?php echo $bttextobuscar;?>..."){
			alert('Por favor escriba un criterio pra buscar.');
			return false;
		}else if((document.header.texto.value) ==""){
			alert('Por favor escriba un criterio pra buscar.');
			return false;		
		}
	}
	function limpia(){
		document.location="buscador.php?l=s";
	}
</script>
<div id="buscad">
<fieldset class='fieldset'><legend class="vistauserx"><strong><?php echo $btBuscadorGeneral;?>.</strong></legend>
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td class='bodyText' align='justify'>
<div id="buscad"><?php
	if (isset($_GET['palabra'])){
		$palabra=$_GET['palabra'];
	}else{
		$palabra="";
	}
	$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
	$qsel = mysqli_query($miConex, $sel) or die(mysqli_error());
	$rsel = mysqli_fetch_array($qsel);
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
				if ($palabra){
					$sql = "TRUNCATE `buscador`";
					mysqli_query($miConex, $sql) or die(mysqli_error());
				}
				if ($palabra !="")   { 					
					$palabra = htmlentities($palabra);
				if(($palabra) !=""){ 
					$palabra=$palabra;
					$buscar_CPU = "SELECT * FROM exp WHERE CPU LIKE '%".$palabra."%'";
					$qbuscar_CPU = mysqli_query($miConex, $buscar_CPU) or die(mysqli_error());
					$rbuscar_CPU = mysqli_fetch_assoc($qbuscar_CPU);
					$tbuscar_CPU = mysqli_num_rows($qbuscar_CPU);
						//
					$buscar_PLACA = "SELECT * FROM exp WHERE PLACA LIKE '%".$palabra."%'";
					$qbuscar_PLACA = mysqli_query($miConex, $buscar_PLACA) or die(mysqli_error());
					$rbuscar_PLACA = mysqli_fetch_assoc($qbuscar_PLACA);
					$tbuscar_PLACA = mysqli_num_rows($qbuscar_PLACA);
						//
					$buscar_MEMORIA = "SELECT * FROM exp WHERE MEMORIA LIKE '%".$palabra."%'";
					$qbuscar_MEMORIA = mysqli_query($miConex, $buscar_MEMORIA) or die(mysqli_error());
					$rbuscar_MEMORIA = mysqli_fetch_assoc($qbuscar_MEMORIA);
					$tbuscar_MEMORIA = mysqli_num_rows($qbuscar_MEMORIA);
						//
					$buscar_MEMORIA2 = "SELECT * FROM exp WHERE MEMORIA2 LIKE '%".$palabra."%'";
					$qbuscar_MEMORIA2 = mysqli_query($miConex, $buscar_MEMORIA2) or die(mysqli_error());
					$rbuscar_MEMORIA2 = mysqli_fetch_assoc($qbuscar_MEMORIA2);
					$tbuscar_MEMORIA2 = mysqli_num_rows($qbuscar_MEMORIA2);
						//
					$buscar_GRAFICS = "SELECT * FROM exp WHERE GRAFICS  LIKE '%".$palabra."%'";
					$qbuscar_GRAFICS = mysqli_query($miConex, $buscar_GRAFICS) or die(mysqli_error());
					$rbuscar_GRAFICS = mysqli_fetch_assoc($qbuscar_GRAFICS);
					$tbuscar_GRAFICS = mysqli_num_rows($qbuscar_GRAFICS);
						//
					$buscar_DRIVE1 = "SELECT * FROM exp WHERE DRIVE1  LIKE '%".$palabra."%'";
					$qbuscar_DRIVE1 = mysqli_query($miConex, $buscar_DRIVE1) or die(mysqli_error());
					$rbuscar_DRIVE1 = mysqli_fetch_assoc($qbuscar_DRIVE1);
					$tbuscar_DRIVE1 = mysqli_num_rows($qbuscar_DRIVE1);
						//
					$buscar_DRIVE2 = "SELECT * FROM exp WHERE DRIVE2  LIKE '%".$palabra."%'";
					$qbuscar_DRIVE2 = mysqli_query($miConex, $buscar_DRIVE2) or die(mysqli_error());
					$rbuscar_DRIVE2 = mysqli_fetch_assoc($qbuscar_DRIVE2);
					$tbuscar_DRIVE2 = mysqli_num_rows($qbuscar_DRIVE2);
						//
					$buscar_DRIVE3 = "SELECT * FROM exp WHERE DRIVE3  LIKE '%".$palabra."%'";
					$qbuscar_DRIVE3 = mysqli_query($miConex, $buscar_DRIVE3) or die(mysqli_error());
					$rbuscar_DRIVE3 = mysqli_fetch_assoc($qbuscar_DRIVE3);
					$tbuscar_DRIVE3 = mysqli_num_rows($qbuscar_DRIVE3);
						//
					$buscar_DRIVE4 = "SELECT * FROM exp WHERE DRIVE4  LIKE '%".$palabra."%'";
					$qbuscar_DRIVE4 = mysqli_query($miConex, $buscar_DRIVE4) or die(mysqli_error());
					$rbuscar_DRIVE4 = mysqli_fetch_assoc($qbuscar_DRIVE4);
					$tbuscar_DRIVE4 = mysqli_num_rows($qbuscar_DRIVE4);
						//
					$buscar_RED = "SELECT * FROM exp WHERE RED  LIKE '%".$palabra."%'";
					$qbuscar_RED = mysqli_query($miConex, $buscar_RED) or die(mysqli_error());
					$rbuscar_RED = mysqli_fetch_assoc($qbuscar_RED);
					$tbuscar_RED = mysqli_num_rows($qbuscar_RED);
						//
					$buscar_RED2 = "SELECT * FROM exp WHERE RED2  LIKE '%".$palabra."%'";
					$qbuscar_RED2 = mysqli_query($miConex, $buscar_RED2) or die(mysqli_error());
					$rbuscar_RED2 = mysqli_fetch_assoc($qbuscar_RED2);
					$tbuscar_RED2 = mysqli_num_rows($qbuscar_RED2);
						//
					$buscar_doct = "SELECT * FROM aft WHERE aft.inv LIKE '%".$palabra."%'";
					$qbuscar_doct = mysqli_query($miConex, $buscar_doct) or die(mysqli_error());
					$rbuscar_doct = mysqli_fetch_assoc($qbuscar_doct);
					$tbuscar_doct = mysqli_num_rows($qbuscar_doct);
					//
					$buscar_docono = "SELECT * FROM aft WHERE aft.descrip LIKE '%".$palabra."%'";
					$qbuscar_docono = mysqli_query($miConex, $buscar_docono);
					$rbuscar_docono = mysqli_fetch_assoc($qbuscar_docono);
					$tbuscar_docono = mysqli_num_rows($qbuscar_docono);
					//
					$buscar_doc = "SELECT * FROM aft WHERE aft.idarea LIKE '%".$palabra."%'";
					$qbuscar_doc = mysqli_query($miConex, $buscar_doc);
					$rbuscar_doc = mysqli_fetch_assoc($qbuscar_doc);
					$tbuscar_doc = mysqli_num_rows($qbuscar_doc);
					//
					$buscar_font = "SELECT * FROM aft WHERE aft.categ LIKE '%".$palabra."%'";
					$qbuscar_font = mysqli_query($miConex, $buscar_font);
					$rbuscar_font = mysqli_fetch_assoc($qbuscar_font);
					$tbuscar_font = mysqli_num_rows($qbuscar_font);
					//
					$buscar_sert = "SELECT * FROM aft WHERE aft.custodio LIKE '%".$palabra."%'";
					$qbuscar_sert = mysqli_query($miConex, $buscar_sert);
					$rbuscar_sert = mysqli_fetch_assoc($qbuscar_sert);
					$tbuscar_sert = mysqli_num_rows($qbuscar_sert);
				//	
					$buscar_ser = "SELECT * FROM aft WHERE aft.tipo LIKE '%".$palabra."%'";
					$qbuscar_ser = mysqli_query($miConex, $buscar_ser);
					$rbuscar_ser = mysqli_fetch_assoc($qbuscar_ser);
					$tbuscar_ser = mysqli_num_rows($qbuscar_ser);
					//	
					$buscar_sello = "SELECT * FROM aft WHERE sello LIKE '%".$palabra."%'";
					$qbuscar_sello = mysqli_query($miConex, $buscar_sello);
					$rbuscar_sello = mysqli_fetch_assoc($qbuscar_sello);
					$tbuscar_sello = mysqli_num_rows($qbuscar_sello);
				//
					$buscar_fon = "SELECT * FROM areas WHERE areas.nombre LIKE '%".$palabra."%'";
					$qbuscar_fon = mysqli_query($miConex, $buscar_fon);
					$rbuscar_fon = mysqli_fetch_assoc($qbuscar_fon);
					$tbuscar_fon = mysqli_num_rows($qbuscar_fon);
				//
					$buscar_ini = "SELECT * FROM exp WHERE exp.idarea LIKE '%".$palabra."%'";
					$qbuscar_ini = mysqli_query($miConex, $buscar_ini);
					$rbuscar_ini = mysqli_fetch_assoc($qbuscar_ini);
					$tbuscar_ini = mysqli_num_rows($qbuscar_ini);
				//
					$buscar_recoger = "SELECT * FROM exp WHERE exp.inv LIKE '%".$palabra."%'";
					$qbuscar_recoger = mysqli_query($miConex, $buscar_recoger);
					$rbuscar_recoger = mysqli_fetch_assoc($qbuscar_recoger);
					$tbuscar_recoger = mysqli_num_rows($qbuscar_recoger);
				//
					$buscar_conservar = "SELECT * FROM exp WHERE exp.cpu LIKE '%".$palabra."%'";
					$qbuscar_conservar = mysqli_query($miConex, $buscar_conservar);
					$rbuscar_conservar = mysqli_fetch_assoc($qbuscar_conservar);
					$tbuscar_conservar = mysqli_num_rows($qbuscar_conservar);
				//
					$buscar_servir = "SELECT * FROM exp WHERE exp.custodio LIKE '%".$palabra."%'";
					$qbuscar_servir = mysqli_query($miConex, $buscar_servir);
					$rbuscar_servir = mysqli_fetch_assoc($qbuscar_servir);
					$tbuscar_servir = mysqli_num_rows($qbuscar_servir);
				//
					$buscar_arti = "SELECT * FROM usuarios WHERE usuarios.nombre LIKE '%".$palabra."%'";
					$qbuscar_arti = mysqli_query($miConex, $buscar_arti);
					$rbuscar_arti = mysqli_fetch_assoc($qbuscar_arti);
					$tbuscar_arti = mysqli_num_rows($qbuscar_arti);
				//
					$buscar_novedades = "SELECT * FROM manuales WHERE manuales.manuales LIKE '%".$palabra."%'";
					$qbuscar_novedades = mysqli_query($miConex, $buscar_novedades);
					$rbuscar_novedades = mysqli_fetch_assoc($qbuscar_novedades);
					$tbuscar_novedades = mysqli_num_rows($qbuscar_novedades);
				//
					$buscar_creditos = "SELECT * FROM usuarios WHERE usuarios.login LIKE '%".$palabra."%'";
					$qbuscar_creditos = mysqli_query($miConex, $buscar_creditos);
					$rbuscar_creditos = mysqli_fetch_assoc($qbuscar_creditos);
					$tbuscar_creditos = mysqli_num_rows($qbuscar_creditos);
				//
					$buscar_resolT = "SELECT * FROM resoluciones WHERE titulo LIKE '%".$palabra."%'";
					$qbuscar_resolT = mysqli_query($miConex, $buscar_resolT);
					$rbuscar_resolT = mysqli_fetch_assoc($qbuscar_resolT);
					$tbuscar_resolT = mysqli_num_rows($qbuscar_resolT);
				//
					$buscar_resolD = "SELECT * FROM resoluciones WHERE descripcion LIKE '%".$palabra."%'";
					$qbuscar_resolD = mysqli_query($miConex, $buscar_resolD);
					$rbuscar_resolD = mysqli_fetch_assoc($qbuscar_resolD);
					$tbuscar_resolD = mysqli_num_rows($qbuscar_resolD);
					$size = strlen ($palabra);
					
					if (($tbuscar_doct) ==0 AND ($tbuscar_CPU) ==0 AND ($tbuscar_sello) ==0 AND ($tbuscar_MEMORIA) ==0 AND ($tbuscar_MEMORIA2) ==0 AND ($tbuscar_PLACA) ==0 AND ($tbuscar_GRAFICS) ==0 AND ($tbuscar_DRIVE1) ==0 AND ($tbuscar_DRIVE2) ==0 AND ($tbuscar_DRIVE3) ==0 AND ($tbuscar_DRIVE4) ==0 AND ($tbuscar_RED) ==0 AND ($tbuscar_RED2) ==0 AND ($tbuscar_docono) ==0 AND ($tbuscar_doc) ==0 AND ($tbuscar_font) ==0 AND ($tbuscar_sert) ==0 AND ($tbuscar_ser) ==0 AND ($tbuscar_fon) ==0 AND ($tbuscar_conservar) ==0 AND ($tbuscar_arti) ==0 AND ($tbuscar_novedades) ==0 AND ($tbuscar_creditos) ==0 AND ($tbuscar_resolD) ==0 AND ($tbuscar_resolT) ==0){ 
						$meng= $no_result;
					} else {
							if ($tbuscar_doct !=0){
							if(($rbuscar_doct['inv']) !=""){
								$busqdoct = $rbuscar_doct['inv'];
								$dominiodoct = stristr ($busqdoct, $palabra);
								$restodoct = substr ($dominiodoct, $size,40); 
									$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (INV)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_doct."</font>')";
									mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if ($tbuscar_CPU!=0) {
							$busqdCPU =$rbuscar_CPU['CPU'];
							$dominiodCPU = stristr ($busqdCPU, $palabra);
							$restodCPU = substr ($dominiodCPU, $size,40);
							
							if(($rbuscar_CPU['CPU']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (CPU)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_CPU."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
							//
						}	
						if ($tbuscar_PLACA!=0){
							$busqdPLACA =$rbuscar_PLACA['PLACA'];
							$dominiodPLACA = stristr ($busqdPLACA, $palabra);
							$restodPLACA = substr ($dominiodPLACA, $size,40);
							if(($rbuscar_PLACA['PLACA']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (PLACA)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_PLACA."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}	
							//
						if($tbuscar_MEMORIA!=0){
							$busqdMEMORIA =$rbuscar_MEMORIA['MEMORIA'];
							$dominiodMEMORIA = stristr ($busqdMEMORIA, $palabra);
							$restodMEMORIA = substr ($dominiodMEMORIA, $size,40);
							if(($rbuscar_MEMORIA['MEMORIA']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (MEMORIA)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_MEMORIA."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						
						//
						if($tbuscar_MEMORIA2!=0){
							$busqdMEMORIA2 =$rbuscar_MEMORIA2['MEMORIA2'];
							$dominiodMEMORIA2 = stristr ($busqdMEMORIA2, $palabra);
							$restodMEMORIA2 = substr ($dominiodMEMORIA2, $size,40);
							if(($rbuscar_MEMORIA2['MEMORIA2']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (MEMORIA1)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_MEMORIA2."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						
						//
						if($tbuscar_GRAFICS!=0){
							$busqdGRAFICS =$rbuscar_GRAFICS['GRAFICS'];
							$dominiodGRAFICS = stristr ($busqdMEMORIA2, $palabra);
							$restodGRAFICS = substr ($dominiodGRAFICS, $size,40);
							if(($rbuscar_GRAFICS['GRAFICS']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (GRAFICS)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_GRAFICS."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						
						//
						if($tbuscar_GRAFICS!=0){
							$busqdDRIVE1 =$rbuscar_GRAFICS['DRIVE1'];
							$dominiodDRIVE1 = stristr ($busqdDRIVE1, $palabra);
							$restodDRIVE1 = substr ($dominiodDRIVE1, $size,40);
							if(($rbuscar_DRIVE1['DRIVE1']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (HDD1)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_DRIVE1."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_DRIVE2!=0){
							$busqdDRIVE2 =$rbuscar_DRIVE2['DRIVE2'];
							$dominiodDRIVE2 = stristr ($busqdDRIVE2, $palabra);
							$restodDRIVE2 = substr ($dominiodDRIVE2, $size,40);
							if(($rbuscar_DRIVE2['DRIVE2']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (HDD2)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_DRIVE2."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_DRIVE3!=0){
							$busqdDRIVE3 =$rbuscar_DRIVE3['DRIVE3'];
							$dominiodDRIVE3 = stristr ($busqdDRIVE3, $palabra);
							$restodDRIVE3 = substr ($dominiodDRIVE3, $size,40);
							if(($rbuscar_DRIVE3['DRIVE3']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (HDD3)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_DRIVE3."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_DRIVE4!=0){
							$busqdDRIVE4 =$rbuscar_DRIVE4['DRIVE4'];
							$dominiodDRIVE4 = stristr ($busqdDRIVE4, $palabra);
							$restodDRIVE4 = substr ($dominiodDRIVE4, $size,40);
							if(($rbuscar_DRIVE4['DRIVE4']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (HDD4)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_DRIVE4."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_RED!=0){
							$busqdRED =$rbuscar_RED['RED'];
							$dominiodRED = stristr ($busqdRED, $palabra);
							$restodRED = substr ($dominiodRED, $size,40);
							if(($rbuscar_RED['RED']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (RED)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_RED."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_RED2!=0){
							$busqdRED2 =$rbuscar_RED2['RED2'];
							$dominiodRED2 = stristr ($busqdRED2, $palabra);
							$restodRED2 = substr ($dominiodRED2, $size,40);
							if(($rbuscar_RED2['RED2']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','detalleexp.php?registros=5&palabra=".$palabra."','Expediente--> (RED2)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_RED2."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_docono!=0){
							$busqdocono =$rbuscar_docono['descrip'];
							$dominiodocono = stristr ($busqdocono, $palabra);
							$restodocono = substr ($dominiodocono, $size,40);
							if(($rbuscar_docono['descrip']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (Descrip)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_docono."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_sello!=0){
							$busqdosello =$rbuscar_sello['sello'];
							$dominiodosello = stristr ($busqdosello, $palabra);
							$restodosello = substr ($dominiodosello, $size,40);
							if(($rbuscar_sello['sello']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (Sello)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_sello."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_doc!=0){
							$busqdoc =$rbuscar_doc['idarea'];
							$dominiodoc = stristr ($busqdoc, $palabra);
							$restodoc = substr ($dominiodoc, $size,40);
							if(($rbuscar_doc['idarea']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (&Aacute;rea)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_doc."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
							//
						if($tbuscar_font!=0){	
							$busqfont =$rbuscar_font['categ'];
							$dominiofont = stristr ($busqfont, $palabra);
							$restofont = substr ($dominiofont, $size,40);
							if(($rbuscar_font['categ']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (Categor&iacute;a)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_font."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						while($rbuscar_fon = mysqli_fetch_assoc($qbuscar_fon)){
							$busqfon =$rbuscar_fon['nombre'];
							$dominiofon = stristr ($busqfon, $palabra);
							$restofon = substr ($dominiofon, $size,40);
							if(($rbuscar_fon['nombre']) !=""){ 
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registroareas.php?registros=5&palabra=".$palabra."','&Aacute;reas--> (Nombre)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_fon."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_sert!=0){
							$busqsert =$rbuscar_sert['custodio'];
							$dominiosert = stristr ($busqsert, $palabra);
							$restosert = substr ($dominiosert, $size,40);
							if(($rbuscar_sert['custodio']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (Custodio)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_sert."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						
						//
						if($tbuscar_ser!=0){
							$busqser =$rbuscar_ser['tipo'];
							$dominioser = stristr ($busqser, $palabra);
							$restoser = substr ($dominioser, $size,40);
							if(($rbuscar_ser['tipo']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','registromedios1.php?registros=5&palabra=".$palabra."','Activo Fijo--> (Tipo)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_ser."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_conservar!=0){
							$busqconservar =$rbuscar_conservar['cpu'];
							$dominioconservar = stristr ($busqconservar, $palabra);
							$restoconservar = substr ($dominioconservar, $size,40);
							if(($rbuscar_conservar['cpu']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','expt.php?registros=5&palabra=".$palabra."','Expediente--> (CPU)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_conservar."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_arti!=0){
							$busqarti =$rbuscar_arti['nombre'];
							$dominioarti = stristr ($busqarti, $palabra);
							$restoarti = substr ($dominioarti, $size,40);
							if(($rbuscar_arti['nombre']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','ej1.php?registros=5&palabra=".$palabra."','Usuarios--> (Nombre)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_arti."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_creditos!=0){
							$busqcrd =$rbuscar_creditos['login'];
							$dominiocrd = stristr ($busqcrd, $palabra);
							$restocrd = substr ($dominiocrd, $size,40);
							if(($rbuscar_creditos['login']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','ej1.php?registros=5&palabra=".$palabra."','Usuarios--> (Login)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_creditos."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
							
						//
						if($tbuscar_novedades!=0){
							$busqnov =substr (strrchr($rbuscar_novedades['manuales'],'>'),1);
							$dominionov = stristr ($busqnov, $palabra);
							$restonov = substr ($dominionov, $size,40);
							if(($rbuscar_novedades['manuales']) !=""){
								$sql = "insert into buscador values (NULL,'".strip_tags($palabra)."','".$palabra."','manuales.php?registros=5&palabra=".$palabra."','Manual del Usuario--> (Manual)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_novedades."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}	
						//
						if($tbuscar_resolT!=0){
							$busqresolT =$rbuscar_resolT['titulo'];
							$dominioresolT = stristr ($busqresolT, $palabra);
							$restoresolT = substr ($dominioresolT, $size,40);
							if(($rbuscar_resolT['titulo']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','res.php?registros=5&palabra=".$palabra."','Resoluciones--> (T&iacute;tulo)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_resolT."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
						//
						if($tbuscar_resolD!=0){
							$busqresolD =$rbuscar_resolD['descripcion'];
							$dominioresolD = stristr ($busqresolD, $palabra);
							$restoresolD = substr ($dominioresolD, $size,40);
							if(($rbuscar_resolD['descripcion']) !=""){
								$sql = "insert into buscador values (NULL,'".$palabra."','".$palabra."','res.php?registros=5&palabra=".$palabra."','Resoluciones--> (Descripci&oacute;n)&nbsp;&nbsp;&nbsp;&nbsp;<font color=#BFCBD2>".$coincidencia.$tbuscar_resolD."</font>')";
								mysqli_query($miConex, $sql) or die(mysqli_error());
							}
						}
					}

				}

					$palabra = htmlentities($palabra);
					$palabra = $palabra;
					$resultados = mysqli_query($miConex, "select * from buscador") or die(mysqli_error());
					$total_registros = mysqli_num_rows($resultados);
					$total_paginas = ceil($total_registros / $registros); 
					if(($total_registros) !=0){ ?>
						<form name="form1" method="get" action="buscador.php">
							<span ><?php echo $cantidadmost;?>:</span>
							<input name="pagina" type="hidden"  value="<?php echo $pagina;?>">
							<input name="mostrar" type="text" size="1" value="<?php if(isset($_GET["mostrar"])){ echo $_GET["mostrar"];}elseif(isset($_GET["registros"])){ echo $_GET["registros"];}elseif(!isset($_GET["registros"]) AND !isset($_GET['mostrar'])){ echo $rsel['visitas'];}elseif(($rsel['visitas']) ==""){ echo "5";}?>" onKeyPress="return acceptNum(event);" class="mostrar">
							&nbsp;&nbsp;<input name="mo"  type="submit" value="<?php echo $btver;?>" class="btn4">
							<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
							<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
							<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
						</form>	<?php
					}
					$sql = "select * from buscador limit $inicio, $registros";
					$result = mysqli_query($miConex, $sql) or die(mysqli_error());
					$p=0;
					while($rbus=mysqli_fetch_assoc($result)){ $p++;?>
						<span style="background-color: #FCE8AD;"><?php echo $rbus['resultado'];?></span>
						<br><a href="<?php echo $rbus['link'];?>&resto=<?php echo $rbus['tabla'];?>"><?php echo $rbus['tabla'];?></a><br><?php 
					} 
					if(($total_registros) !=0){ include('navegador1.php'); }
				}else{
				  $meng= $no_result; ?>
				  <div class="alert alert-danger" style="z-index:9999;">
								<b>Oh!&nbsp;&nbsp;</b>
										<?php echo $no_result; ?>:&nbsp;<b></b><hr><span onclick="document.location='expedientes.php';" class="btn btn-default">Retornar</span>
							</div><?php 
				}
				?>
				</div>
			</td>
		</tr>
	</table>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
