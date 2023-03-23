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
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$russ = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);
$Uactbx=1;
						
if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$Uactb = $_COOKIE['unidades'];
	$Uactbx=$_COOKIE['unidades'];
	$sql_uactivabc = "select * from datos_generales where id_datos='".$Uactb."'";
	$result_uactivabc= mysqli_query($miConex, $sql_uactivabc) or die(mysql_error());
	if((mysqli_num_rows($result_uactivabc)) ==0){ ?>
		<script type="text/javascript">
			document.cookie = "unidades=1;";
			document.location="registromedios1.php";
		</script><?php
	}	
}  

	function COMP_exp($inv){
		include('connections/miConex.php');
		$existe = 0;

		$sql = "SELECT * FROM aft WHERE exp='".$inv."' AND categ='COMPUTADORAS'";
		$result= mysqli_query($miConex, $sql) or die(mysqli_error($miConex));	  
		$existe = mysqli_num_rows($result);
		if($existe!=0){
			return true;
		}
        return false;
	}

    
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<script type="text/javascript" src="js/scrolltopcontrol.js">

/***********************************************
* Scroll To Top Control script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Project Page at http://www.dynamicdrive.com for full source code
***********************************************/

</script> 
<?php include('jquery.php'); ?>	

<script type="text/javascript">
				var valor;
				var val="";
				var arreg = new Array("COMPUTADORAS","MONITOR","IMPRESORA","TECLADOS","MOUSE","ESCANNER","BOCINA","-1") ;

				function llena(val){		
					for(i=0; i<arreg.length; i++){
						if((arreg[i]) !=val){
							document.getElementById("resto").style.display = "block";
							document.getElementById("resto").innerHTML = '<input class="form-control" onblur="carga(this.value);" name="usb" id="usb" type="text" size="40">';
						}			
					}
					
					if((val) !=""){	
						if((val) =="COMPUTADORAS"){
								document.getElementById("tipoc1").style.display = "block";
								document.getElementById("tipoc2").style.display = "block";
						}else{
							document.getElementById("tipoc1").style.display = "block";
							document.getElementById("tipoc2").style.display = "block";
						}
						if (val=="-1") {
							document.getElementById("tipoc1").style.display = "none";
							document.getElementById("tipoc2").style.display = "none";
						}
						if((val) =="COMPUTADORAS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="PORT&Aacute;TIL">PORT&Aacute;TIL</option><option value="SERVIDOR NAS">SERVIDOR NAS</option><option value="ESCRITORIO">ESCRITORIO</option><option value="SERVIDOR">SERVIDOR</option><option value="CLIENTE LIGERO">CLIENTE LIGERO</option></select>';
						}else if((val) =="MONITOR"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="LCD">LCD</option><option value="LED">LED</option><option value="CRT">CRT</option></select>';
						}else if((val) =="TECLADOS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option></select>';
						}else if((val) =="PLOTER"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="DE PLUMA">DE PLUMA</option><option value="DE CHORRO">DE CHORRO</option></select>';
						}else if((val) =="SWITCH"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="CABLEADO">CABLEADO</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option></select>';
						}else if((val) =="MODEM"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="INTERNOEXTERNO">EXTERNO</option><option value="INTERNO">INTERNO</option></select>';
						}else if((val) =="ROUTER"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="USB">USB</option><option value="PUERTO COM">PUERTO COM</option></select>';
						}else if((val) =="MEMORIAS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="USB">USB</option></select>';
						}else if((val) =="MOUSE"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option><option value="DIMM">DIMM</option></select>';
						}else if((val) =="TECLADO"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option><option value="DIMM">DIMM</option></select>';
						}else if((val) =="IMPRESORA"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="Matricial">Matricial</option><option value="Laser">L&aacute;ser</option><option value="Chorro">Chorro de tinta</option><option value="T&eacute;rmica">T&eacute;rmica</option><option value="3d">3D</option></select>';
						}else if((val) =="ESCANNER"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="DE MESA">DE MESA</option><option value="DE TRAYECTORIA">DE TRAYECTORIA</option></select>';
						}else if((val) =="FOTOCOPIADORA"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="A COLOR">A COLOR</option><option value="BLANCO Y NEGRO">BLANCO Y NEGRO</option></select>';
						}else if((val) =="UPS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="CONVENSIONALES">CONVENSIONALES</option><option value="PARA SERVIDORES">PARA SERVIDORES</option></select>';
						}else if((val) =="BOCINA"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option value="-1">--</option><option value="PLUG">PLUG</option><option value="USB">USB</option></select>';
						}								
					}
				}
				function carga(valor){
					document.consulta.usb.value=valor;
				}
</script>
<script type="text/javascript">
	
		function objetoAjax(){
			var xmlhttp=false;
				try{
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}catch(e){
					try{
					   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}catch(E){
						xmlhttp = false;
					}
				}

				if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
					xmlhttp = new XMLHttpRequest();
				}
				return xmlhttp;
		}
		
		// generar lista de custodios según área seleccionada
		function listarcusto(valo){
			divcusto = document.getElementById('custoder');
			ajaxcusto=objetoAjax();
			ajaxcusto.onreadystatechange=function() {
				if (ajaxcusto.readyState==4) {
					divcusto.innerHTML=ajaxcusto.responseText;
					var datos=ajaxcusto.responseXML.documentElement;	
				}		
			}
			valores1="query_Re="+valo;
			ajaxcusto.open("POST", "custo.php", true);
			ajaxcusto.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			ajaxcusto.send(valores1);
			
		}

</script>		

<script type="text/javascript">
	function prueba()	{
		document.header.enable(); 
	}	
	function prueba2()	{
		document.header.disabled();  
	}	

 function seguro4(){
	document.wq.action='#modal6';
	document.wq.accion.value = accion;
	document.wq.submit();
 }
 
</script>
 <?php

$palabra="";
$msg="";
$m="";
$i=0;
$rp="";
$palab="";
$logi=$_SESSION["valid_user"];
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$logi."'") or die(mysql_error());
$russ1 = mysqli_fetch_array($us1);
if(isset($_POST['palabra'])){ $palabra = htmlentities($_POST['palabra']);}
if(isset($_REQUEST['palabra'])){ $palabra = htmlentities($_REQUEST['palabra']);}
if(isset($_REQUEST['rp'])){ $rp = $_REQUEST['rp'];}

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;

//SABER LOS TIPO DE MEDIOS
$query_Recordset3 = "SELECT * FROM tipos_medios ORDER BY nombre";
$Recordset3 = mysqli_query($miConex, $query_Recordset3) or die(mysql_error());
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

//SABER LOS CUSTODIOS
$query_Recordset1 = "SELECT * FROM usuarios ORDER By nombre ASC";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset41 = "SELECT * FROM datos_generales";
$Recordset41 = mysqli_query($miConex, $query_Recordset41) or die(mysql_error());

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_R = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."'";
}elseif (isset($_POST['idunidades'])){
	$query_R = "SELECT * FROM areas where idunidades='".$_POST['idunidades']."'";
}else{
	$query_R = "SELECT * FROM areas";
}

$Record = mysqli_query($miConex, $query_R) or die(mysql_error());


if ($_SESSION ["valid_user"]!='invitado' and $rsel['visitas'] !=""){
	$cuantos = $rsel['visitas'];
}

    if ($_SESSION['valid_user']!="invitado") { 
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
	   $rsul = mysqli_query($miConex, $sql_pref) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
	   
	   $query = "SELECT * FROM usuarios WHERE login='".$_SESSION['valid_user']."'";
       $result = mysqli_query($miConex, $query) or die(mysql_error());
	   $rws = mysqli_fetch_array($result);
	   
    }else{
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='webmaster'";
	   $rsul = mysqli_query($miConex, $sql_pref) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
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
		$resux = "SELECT * FROM aft";
		$result1 = mysqli_query($miConex, $resux);
		$fields1 = mysqli_num_fields($result1);
		$rows1   = mysqli_num_rows($result1);
		$fields  = mysqli_fetch_field_direct ($result1, 1); 
		$nam  = $fields->name;
		
	$orderby = $nam;
	$asc="ASC";
	if(isset($_POST['asc']) AND ($_POST['asc']) !=""){ $asc = $_POST['asc']; }
	if(isset($_REQUEST['asc']) AND (@$_REQUEST['asc']) !=""){ $asc = $_REQUEST['asc']; }
	if(isset($_POST['orderby']) AND ($_POST['orderby']) !=""){ $orderby = $_POST['orderby']; }
	if(isset($_REQUEST['orderby']) AND ($_REQUEST['orderby']) !=""){ $orderby = $_REQUEST['orderby']; }

	if(($palabra) =="") {
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "select * from aft WHERE idunidades = '".$_COOKIE['unidades']."'";
			$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
		}else{
			$sql = "select * from aft";
			$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);		
			$contx1 = "SELECT * FROM aft  kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;
		}
	}elseif(isset($_REQUEST['id_are'])){
			$id_are = $_POST['id_are'];
			$idunida = $_POST['idunida']; 
			$palabra = $_POST['palabra']; 
			$sql = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."'";
			$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
			$contx1 = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;
	        if (isset($_REQUEST['enred'])) {
				 $enred = $_POST['enred']; 
				if ($_REQUEST['conect']=="Internet") {
				   $enred = $_POST['enred']; 
				   $conect = $_POST['conect']; 			 
				   $sql = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."' AND enred ='".$enred."' AND conect ='".$conect."'";
				   $query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
				   $contx1 = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;   
		        }elseif ($_REQUEST['conect']=="Intranet"){
				   $sql = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."' AND enred ='".$enred."'";
				   $query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
				   $contx1 = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;   
				}else{
					$sql = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."'";
				    $query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
				    $contx1 = "SELECT * FROM aft WHERE categ ='".$palabra."' AND id_area ='".$id_are."' AND idunidades ='".$idunida."' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;   
				}
			}
			
	}else{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		   $sql = "SELECT * FROM aft WHERE idunidades ='".$Uactb."' AND descrip LIKE '%".$palabra."%' or sello LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or inv LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%' or marca LIKE '%".$palabra."%' or categ  LIKE '%".$palabra."%' or modelo  LIKE '%".$palabra."%' or sello  LIKE '%".$palabra."%'";
		}else{
			$sql = "SELECT * FROM aft WHERE descrip LIKE '%".$palabra."%' or sello LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or inv LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%' or marca LIKE '%".$palabra."%' or categ  LIKE '%".$palabra."%' or modelo  LIKE '%".$palabra."%' or sello  LIKE '%".$palabra."%'";
		}
		
		
		$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
		$contx1 = "SELECT * FROM aft WHERE  descrip LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or inv LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%' or marca LIKE '%".$palabra."%' or categ  LIKE '%".$palabra."%' or modelo  LIKE '%".$palabra."%' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;
	}
	
	if(isset($_POST['in'])){
		$sql = "SELECT * FROM aft WHERE  tipo LIKE '%".$palabra."%'";
		$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
		$contx1 = "SELECT * FROM aft WHERE  tipo LIKE '%".$palabra."%' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;
	}
	
	if(isset($_GET['noti'])){
		if ($_GET['noti']!=0) {
			if (strlen($_GET['noti']) >=4) {	 
			   $sql = "SELECT * FROM aft WHERE exp='' AND categ='COMPUTADORAS'";
		       $query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);		    
	     	}else{
				$sql = "SELECT * FROM aft WHERE sello='' AND categ='COMPUTADORAS' AND estado='A' ";
		        $query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);	
			}	
				    
		}
	}
	if(isset($_GET['notiex'])){
		if ($_GET['notiex']!=0) {
			$sql = "SELECT * FROM aft WHERE exp='' AND categ='COMPUTADORAS'";
		    $query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);						    
		}
	}
	
	if(isset($_REQUEST['consulta'])){
		if (($_REQUEST['tt']!=-1) && ($_REQUEST['flash']!=-1) && (isset($_REQUEST['ta10']) && $_REQUEST['ta10']!=-1) && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']!=-1) && ($_REQUEST['marca']!="")){
			// "Mostrar Todos<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."' AND custodio = '".htmlentities($_REQUEST['custo'])."' AND estado = '".$_REQUEST['estado']."' AND idunidades = '".$_REQUEST['idunidad']."' AND marca = '".$_REQUEST['marca']."'";
		}elseif (($_REQUEST['tt']!=-1) && ($_REQUEST['flash']!=-1) && (!isset($_REQUEST['usb'])) && (($_REQUEST['ta10']==-1) OR ($_REQUEST['ta10']=="--")) && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Categorias de un area no existe usb<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."'";
		}elseif (($_REQUEST['tt']!=-1) && ($_REQUEST['flash']!=-1) && (!isset($_REQUEST['ta10'])) && ($_REQUEST['usb']=="") && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Categorias de un area no existe ta10<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."'";
		}elseif (($_REQUEST['tt']!=-1) && $_REQUEST['flash']!=-1 && ((isset($_REQUEST['ta10'])) && ($_REQUEST['ta10']!=-1))  && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Una Categoria + Un tipo de un area<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."'";
		}elseif (($_REQUEST['tt']==-1) && $_REQUEST['flash']!=-1 && (isset($_REQUEST['usb']) && ($_REQUEST['usb']!="")) && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Una Categoria + Un tipo sin especificar un area<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['usb'])."'";
		}elseif (($_REQUEST['tt']!=-1) && $_REQUEST['flash']!=-1 && (isset($_REQUEST['usb'])) && $_REQUEST['usb']!="" && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Una Categoria + Un tipo de un area especifica<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['usb'])."'";
		}elseif (($_REQUEST['tt']==-1) && $_REQUEST['flash']!=-1 && !isset($_REQUEST['usb']) && $_REQUEST['ta10']!=-1 && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Una Categoria + Un tipo sin especificar un area va ta10<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."'";
		}elseif (($_REQUEST['tt']==-1) && $_REQUEST['flash']!=-1 && (isset($_REQUEST['ta10']) && $_REQUEST['ta10']!=-1) && $_REQUEST['custo']!=-1) {
			// " Una Categoria + Un tipo + Custodio sin especificar un area va ta10<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."' AND custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']!=-1 && $_REQUEST['ta10']==-1 && $_REQUEST['custo']!=-1) {
			// "-- Una Categoria, sin un tipo + Custodio, sin especificar un area va ta10 vacio<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif (($_REQUEST['tt']==-1) && $_REQUEST['flash']!=-1 && (isset($_REQUEST['usb']) && $_REQUEST['usb']=="") && $_REQUEST['custo']!=-1) {
			// "--- Una Categoria sin especificar tipo + Custodio, sin especificar un area va usb<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif ($_REQUEST['tt']!=-1 && $_REQUEST['flash']!=-1 && @$_REQUEST['ta10']!=-1 && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "--> Una Categoria + un tipo + estado, de un area va ta10<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."' AND estado = '".$_REQUEST['estado']."'";
		}elseif ($_REQUEST['tt']!=-1 && $_REQUEST['flash']==-1 && $_REQUEST['usb']==-1 && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "--> Un Custodio de un area especifica<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']==-1 && !isset($_REQUEST['ta10']) && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "un estado de todas las areas<br>";
			$sql = "SELECT * FROM aft WHERE estado = '".$_REQUEST['estado']."'";
		}elseif ($_REQUEST['tt']!=-1 && $_REQUEST['flash']==-1 && !isset($_REQUEST['ta10']) && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "De un area + estado<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND estado = '".$_REQUEST['estado']."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']!=-1 && isset($_REQUEST['ta10']) && $_REQUEST['ta10']!=-1 && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "De cualquier area, Una Categoria + un tipo + estado existe ta10<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."' AND estado = '".$_REQUEST['estado']."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']!=-1 && isset($_REQUEST['usb']) && $_REQUEST['usb']!=-1 && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "De cualquier area, Una Categoria + un tipo + estado existe usb<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['usb'])."' AND estado = '".$_REQUEST['estado']."'";
		}elseif ($_REQUEST['tt']!=-1 && $_REQUEST['flash']!=-1 && isset($_REQUEST['ta10']) && $_REQUEST['ta10']!=-1 && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "De un area, Una Categoria + un tipo + custodio + estado<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."' AND categ = '".$_REQUEST['flash']."' AND tipo = '".htmlentities($_REQUEST['ta10'])."' AND estado = '".$_REQUEST['estado']."' AND custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']!= -1 && $_REQUEST['ta10']==-1 && !isset($_REQUEST['usb']) && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Cualquier categoria sin nada mas no existe usb<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']!= -1 && !isset($_REQUEST['ta10']) && $_REQUEST['usb']=="" && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Cualquier categoria sin nada mas no existe ta10<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']==-1 && !isset($_REQUEST['ta10']) && $_REQUEST['usb']==-1 && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Cualquier cosa de un custodio especificado<br>";
			$sql = "SELECT * FROM aft WHERE custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']== -1 && !isset($_REQUEST['ta10']) && $_REQUEST['usb']==-1 && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']!=-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			$sql = "SELECT * FROM aft WHERE custodio = '".htmlentities($_REQUEST['custo'])."' AND estado = '".$_REQUEST['estado']."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']== -1 && !isset($_REQUEST['ta10']) && $_REQUEST['usb']==-1 && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']!="")) {
			$sql = "SELECT * FROM aft WHERE custodio = '".htmlentities($_REQUEST['custo'])."' AND marca = '".$_REQUEST['marca']."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']!= -1 && $_REQUEST['ta10']==-1 && ($_REQUEST['custo']!=-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']!="")) {
			// "Una categoria un custodio especificado<br>";
			$sql = "SELECT * FROM aft WHERE categ = '".$_REQUEST['flash']."' AND custodio = '".htmlentities($_REQUEST['custo'])."'";
		}elseif ($_REQUEST['tt']==-1 && $_REQUEST['flash']==-1 && $_REQUEST['usb']==-1 && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']!="")) {
			// "Buscar solo por marcas<br>";
			$sql = "SELECT * FROM aft WHERE marca = '".$_REQUEST['marca']."'";
		}elseif ($_REQUEST['tt']!=-1 && $_REQUEST['flash']==-1 && $_REQUEST['usb']==-1 && ($_REQUEST['custo']==-1) && ($_REQUEST['estado']==-1) && ($_REQUEST['idunidad']==1) && ($_REQUEST['marca']=="")) {
			// "Buscar todo en un area determinada<br>";
			$sql = "SELECT * FROM aft WHERE id_area = '".$_REQUEST['tt']."'";
		}else{
			$sql = "SELECT * FROM aft";
		}

		$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
		$contx1 = "SELECT * FROM aft WHERE  id_area = '".$_REQUEST['tt']."' kk ORDER BY ".$orderby." ".$asc." limit ".$inicio.",".$registros;
		$contx = base64_encode($contx1);
	}
	
	if(isset($_REQUEST['query_limit'])){ 
	  $query_limit = base64_decode($_REQUEST['query_limit']);
	}

	$result= mysqli_query($miConex, $query_limit) or die(mysql_error());
	$total_mm = mysqli_num_rows($result);
	$ggg = base64_encode($query_limit);
		
//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
	
//NAVEGADOR	FIN 

function act_aft(){
	include("connecion/miConex.php");
	$esta='SELECT aft.descrip as nroinv, aft.inv as invent, exp.inv, exp.descrip FROM exp INNER JOIN aft ON (aft.inv = exp.inv); ';
	$resuta = mysqli_query($miConex, $esta) or die(mysqli_error($miConex));
	$num_resu = mysqli_num_rows($resuta);
				
	while ($cual = mysqli_fetch_array($resuta)){ 
		$sqldq="UPDATE aft SET exp = '".$cual['invent']."' WHERE aft.inv='".$cual['invent']."'";
		$restd=mysqli_query($miConex, $sqldq) or die(mysqli_error($miConex));
	}
}

?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
            $(document).ready(function() {
			for(r=0;r<<?php echo $total_registros;?>;r++){		
				$("#tooltip"+r).mouseover(function(){
				  $("#tooltip"+r).mousemove(function(e){
				   $(this).next().css({left : e.pageX , top: e.pageY});
				  });
				eleOffset = $(this).offset();
				$(this).next().fadeIn("fast").css({
					left: eleOffset.left + $(this).outerWidth(),
					top: eleOffset.top
				});
					}).mouseout(function(){
						$(this).next().fadeOut("fast");
					});
			}
			});		
	function escribe(){
		if((document.header.palabra.value) =="<?php echo $bttextobuscar;?>..."){
			alert('Por favor escriba un criterio para buscar.');
			return false;
		}
	}
	function ir(inv,idun,ini,donde){
	   document.ir.inv.value = inv;
	   document.ir.idunidades.value = idun;
	   document.ir.palabra.value = ini;
	   document.ir.dde.value = donde;
	   document.ir.submit();
	}

	function limpia(){
		document.header.palabra.value ="";
		prueba();
	}
	
</script><?php
if(isset($_REQUEST["msg"])){ $msg = base64_decode($_REQUEST["msg"]);}
if(isset($_REQUEST["m"])){ $m = "&m=m";}
if(isset($_REQUEST["msg"])){ print'<meta http-equiv="refresh" content="4;URL=registromedios1.php?query_limit='.base64_encode($query_limit).'&palabra='.$_REQUEST["palabra"].'"><span align="center" class="vistauser1"><em><strong><font size="2" color="red">'.$msg.'</font></strong></em></span>';}

$leg = "REGISTRO DE MEDIOS";
if((@$_REQUEST['otras']) !=""){ $leg =$_REQUEST['otras'];}
if((@$_REQUEST['palabra']) !=""){ $leg = $_REQUEST['palabra'];} ?>
<?php include('barra.php');?>
<form action="et.php" method="post" name="ir" id="ir">
	<input name="inv" value="1" type="hidden">
	<input name="idunidades" type="hidden">
	<input name="idun" id="marcado" type="hidden">
	<input name="palabra" id="palabra" type="hidden">
	<input name="dde" id="dde" type="hidden">
</form>
<form action="#modal6" method="post" name="contel1" id="contel1">
	<input name="editar" value="1" type="hidden">
	<input name="idunidades" type="hidden" value="<?php echo $Uactbx;?>">
	<input name="marcado" id="marcado" type="hidden">
</form>
<form action="" method="post" name="wq" id="wq">
	<input name="accion" id="accion" type="hidden">
</form>
<form action="v3.php" method="post" name="contel" id="contel">
	<input name="editar" value="1" type="hidden">
	<input name="idunidades" type="hidden" value="<?php echo $Uactbx;?>">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="v2.php" method="post" name="conted" id="conted">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<script type="text/javascript">
function accion(id,q){
	if((q) =="ed"){
		document.contel.marcado.value=id;
		document.contel.submit();
	}else{
		if(confirm('<?php echo $cuidado;?>')){
			document.conted.marcado.value=id;
			document.conted.submit();
		}
	}
}

function contextual(event,id){
	var iX = event.clientX;
	var iY = event.clientY;
		event.preventDefault();
		$('#divMenu').css({
			display:	'block',
			left: iX,
			top: iY
		});

		$('#divMenu').html('<ul><li onclick="accion(\''+id+'\',\'ed\');"><a style="cursor:pointer; text-decoration:none;" ><img title="Editar..." align="asbmiddle" src="images/editar.png" width="16" height="16">&nbsp;&nbsp;Editar</a></li><li onclick="accion(\''+id+'\',\'el\');"><a style="cursor:pointer; text-decoration:none;" ><img align="asbmiddle" src="images/delete.png" width="16" height="16" title="Eliminar...">&nbsp;&nbsp;Eliminar</a></li></ul>');
}

</script>
<div id="divMenu"></div>
<div id="modal6" class="modalmask">
<div class="modalbox resize" style="width: 32%; height: 295px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 104%; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
    <h2 class="pos"><?php echo strtoupper($cr_filtro);?></h2></div>
   
	<form action="registromedios1.php" method="POST" name="consulta">
       <table width="100%" border="0" align="center" class="table">
		<tr>
	      <td width="29%" align="center"><div align="right" class="contentheading"><?php echo substr($btAreas,0,-1);?></div></td>
		    <td colspan="2" align="left">
				<select name="tt" class="form-control" size="1" id="tt" onChange="listarcusto(this.value);">
						<option value="-1"><?php echo "--";?></option><?php
						while ($row_R = mysqli_fetch_array($Record)) {
							if(($row_R['nombre']) !="Reparaciones"){ $areacust = $row_R['idarea']; ?>
								<option value="<?php echo $row_R['idarea'];?>" <?php if((@$_POST['tt']) ==$row_R['idarea']){ echo "selected";}?>><?php echo $row_R['nombre']?></option><?php
							}
						} 
					?>
                </select>		    
			</td>
	    </tr>
		<tr>
		  <td width="29%" align="center"><div align="right" class="contentheading"><?php echo $btcategmedios2;?></div></td>
			<td colspan="2" align="left">
				<select onkeypress="return handleEnter(this, event)" name="flash" size="1" class="form-control" id="flash" onChange="llena(this.value); if (this.value !=-1) { document.getElementById('isert').style.display='block'; }else{ document.getElementById('isert').style.display='none'; }">
					<option value="-1"><?php echo "--"; ?></option>   <?php
						while ($row_Recordset3 = mysqli_fetch_array($Recordset3)){  ?>
						  <option value="<?php echo $row_Recordset3['nombre']?>"><?php echo $row_Recordset3['nombre']?></option> <?php
						} ?>
		        </select>		 
	        </td>
	    </tr>
		<tr>
		  <td width="29%" align="center"><div id="tipoc2" style="display:none;" align="right" class="contentheading"><?php echo strtoupper($bttipo);?></div></td>
		    <td colspan="2">
			<div id="tipoc1" style="display:none;" ><?php
					if(isset($_GET['u'])){ ?>								
						<input name="usb" class="form-control" readonly type="text" id="usb" size="20" value="USB"><?php
					}else{ ?>
						<div id="resto"><select onkeypress="return handleEnter(this, event)" class="form-control" onChange="carga(this.value);" name="usb" id="usb"><option value="-1">--</option></select></div><?php
					} ?></div></td>   
	    </tr>
		<tr>
		  <td><div align="right" id="custon1" class="contentheading"><?php echo strtoupper($btCustodios);?></div></td>
            <td colspan="2"><div id="custoder"><label>
              <select onkeypress="return handleEnter(this, event)" name="custo" size="1" class="form-control" id="custo">
				  <option value="-1"><?php echo "--"; ?></option><?php
					while ($row_Recordset1 = mysqli_fetch_array($Recordset1)){   ?>
						<option value="<?php echo $row_Recordset1['nombre']?>"><?php echo $row_Recordset1['nombre']?></option><?php
					} 
				?> 
              </select>
            </label></div></td>
	    </tr>
		<tr>
            <td><div align="right" class="contentheading"><?php echo strtoupper($btestado);?></div></td>
            <td colspan="2"><label>
              <select onkeypress="return handleEnter(this, event)" name="estado" size="1" id="estado" class="form-control">
                <option value="-1" selected><?php echo "--"; ?></option>
				<option value="A"><?php echo $btActivo;?></option>
                <option value="R"><?php echo $btRoto;?></option>
                <option value="T"><?php echo $btTaller;?></option>
              </select>
            </label></td>
        </tr>
		<tr>
            <td><div align="right" class="contentheading"><?php echo strtoupper($btMARCA);?></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="marca" id="marca" class="form-control" style="width:71%;" onKeyUp="llamaorgano(this.value,'marcas','marca','orgn');"><span id="orgn" onClick="document.getElementById('orgn').style.display ='none';" class="mstra" style="width:50%" ></span></td>
        </tr>
`		<tr>
            <td><div align="right" class="contentheading"><?php echo strtoupper($unidad);?></div></td>
            <td colspan="2"><label>
              <select onkeypress="return handleEnter(this, event)" name="idunidad" size="1" id="idunidad" class="form-control">
			    <?php 
                    while ($row_Recordset41 = mysqli_fetch_array($Recordset41)){   ?>
						<option value="<?php echo $row_Recordset41['id_datos']?>"><?php echo $row_Recordset41['entidad']?></option><?php
					} ?>
              </select>
            </label></td>
            </tr>  		
		<tr>
		  <td align="right"><input name="consulta" type="hidden"></td>
		  <td width="50%" align="right"><input name="acepta" value="<?php echo $btaceptar;?>" class="btn" style="float: right;" type="submit"></td>
		  <td width="21%" align="right"><input type="button" onClick="document.location='registromedios1.php';" name="cancelar" value="<?php echo $btcancelar; ?>" class="btn"></td>
	    </tr>
		</table>
	</form>	
</div>
</div>
<div id="modal5" class="modalmask">
<div class="modalbox resize" style="width: 54%; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo strtoupper($bteditar);?> AFT</h2></div>
		<p><iframe src="v2.php?marcado[]=<?php echo $_POST['marcado'];?>&idunidades=<?php echo $_POST['idunidades'];?>&editar" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 543px; height: 460px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -18px; margin-top: -2px; width: 105%; border-radius: 5px 5px 0px 0px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo strtoupper($new3.$btregmedio1);?></h2></div>
		<p><iframe src="form-insertaraft.php" name="b" scrolling="Auto" width="102%" height="400" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="buscad"> 
<fieldset class='fieldset'>
<legend class="vistauserx"><?php echo strtoupper($btregmedio);?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>	
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div>
	 <?php 
	$consulta_unidades ="SELECT * FROM datos_generales";
	$resultado = mysqli_query($miConex, $consulta_unidades) or die(mysql_error());
	$total_filas = mysqli_num_rows($resultado);
	?>
	<table width="100%" border="0" align="center">
		<tr><?php
	        if(($total_filas) >1){ ?>
			<td>
					<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
						<select name="unidades" id="unidades" class="form-control"  style="margin-top: -20px; margin-left:73px;<?php if ($total_registros !=0) { ?>width:57%;<?php }else{ ?>width:19%; <?php } ?>"  onchange="cambiaunidad(this.value,'registromedios1.php');">
							<option value="-1"><?php echo $btmostrartodo1?></option><?php 
							WHILE ($row1=mysqli_fetch_array($reado)){ ?>					
								<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
							} ?>
						</select>
						<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
						<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
						<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">				
					</form>
		    </td><?php 
		    } 
			if(($total_filas) ==1){  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";}
			if(($total_registros) !=0){  ?> 
		    <td>
				<form action="" method="post" name="header" id="header" onSubmit="return escribe();">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b><?php echo $filtr.substr($Por1,0,-1);?>: </b></span>
					<input name="palabra" type="text" id="palabra" size="20" autocomplete="off" class="imput" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="if((this.form.componente.checked) ==true){ adjs(this.value,'s');}else{ adjs(this.value,'');}"  onClick="limpia();"/>
					<div id="chequeaderax" style="cursor:pointer; background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; float: left; margin-left: 323px; position: absolute; margin-top:-26px;" onClick="selecciona(); if((getElementById('componente').checked) ==true){ document.getElementById('imprime').style.display='none'; }else{ document.getElementById('imprime').style.display='block'; }">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><label style="cursor:pointer; color: rgb(161, 165, 168);" onClick="selecciona(); if((getElementById('componente').checked) ==true){ document.getElementById('imprime').style.display='none'; }else{ document.getElementById('imprime').style.display='block'; }">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $componentes; ?></label><input name="componente" style="display:none;" type="checkbox" id="componente" />
				</form>
		    </td>
			<td width="22%" align="right">
					<div id="imprime" style="margin-left:45px; margin: 0px 65px;">
					  <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
						
						<?php 
						if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
						  <td width="17%" class="filtro"><a class="tooltip" href="#seguro4();" onclick="seguro4();" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_filtro);?></span></a></td>
						  <td width="17%" class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=aft&gt=registromedios1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($s_email);?></span></a></td>
						  <?php
						} ?>
						  <td width="19%" class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_pdf);?></span></a></td>
						  <td width="21%" class="exel"><a class="tooltip" href="expregmedios.php?query=<?php echo $ggg;?>&tb=aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_exel);?></span></a></td>
						  <td width="43%" class="printer"><a class="tooltip" href="imprimir/index.php?query=<?php echo $ggg;?>&tb=aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($sav_print);?></span></a></td>
						</tr>
					  </table>	
					</div>
		    </td><?php 
			} ?>
		</tr>
	</table>

	<div id="paginac"><?php 
	 if(($total_registros) !=0){ ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
						<form name="mst" method="post" action="" id="mst">
							<span><?php echo $cantidadmost;?>:</span>
							<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
								<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
								<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
								<input name="mostrar" id="vers" type="text" maxlength="3" value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ if ($_REQUEST['mostrar']>$total_registros) { echo $total_registros; }else{ echo $_REQUEST['mostrar'];} if($_REQUEST['mostrar']<1) { echo "1"; } } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
								<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
							</span>	
								<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
								<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
								<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
								<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
								<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
								<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
								<input type="hidden" name="asc" value="<?php echo $asc;?>">
								<input type="hidden" name="m" value="m">
						</form></div>
					</td>
				</tr>
			</table>
		<?php 
	} ?>
		<form action="v3.php" method="post" enctype="multipart/form-data" name="frm1">
			<table width="100%" border='0' class='table' align='center' cellpadding="0" cellspacing="0"> <?php 
				if(($total_registros) !=0){ ?>
					<tr class="vistauser1">
					    <td width="10"> <?php if (($_SESSION ["valid_user"]!='invitado' and $russ['tipo']) =="root") { ?>
						  <div id="cheque1" onClick="document.getElementById('deta').style.display='block'; det2('<?php echo base64_encode($query_limit);?>'); marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						  <div id="cheque2" onClick="ocul(); desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php } ?>
					    </td>
						<td width="40">&nbsp;</td>
						<td width="84"  align="center"><a href="registromedios1.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=inv">INV<?php if(($orderby) =="inv"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="197" align="center"><a href="registromedios1.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=descrip"><?php echo $DESCRIPCION; if(($orderby) =="descrip"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="176" align="center"><a href="registromedios1.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=idarea"><?php echo $btAreas1;	if(($orderby) =="idarea"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="96"  align="center"><a href="registromedios1.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=categ">CATEG.<?php if(($orderby) =="categ"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="77" align="center"><a href="registromedios1.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=tipo"><?php echo 	strtoupper($bttipo);	if(($orderby) =="tipo"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="177" align="center"><a href="registromedios1.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=custodio"><?php echo strtoupper($btCustodios); if(($orderby) =="custodio"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
					</tr><?php
					$id = 0;
					$p=0;
					while($row=mysqli_fetch_array($result)) { $i++;
						$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
						$qsedg = mysqli_fetch_array($sedg);	
						$rowid=$row["id"]; 
						
						// Saber nombre de la PC 
						$sqlexp = "select * from exp WHERE inv = '".$row['inv']."'";
						$result_exp= mysqli_query($miConex, $sqlexp) or die(mysql_error());
						$row_exp=mysqli_fetch_array($result_exp);

						?>
						<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="if ((document.getElementById('marcado<?php echo $p;?>').type =='checkbox') && (document.getElementById('marcado<?php echo $p;?>').checked ==false)) { document.getElementById('deta').style.display='block'; det('<?php echo $rowid; ?>'); marca1(<?php echo $p;?>,'#ffffff'); }else{ marca1(<?php echo $p;?>,'#ffffff'); document.getElementById('deta').style.display='none'; }" onContextMenu="<?php if (($russ['tipo']) =="root") {  ?>contextual(event,'<?php echo $row["id"]?>'); <?php } ?>"> 
						   <td width="15"><?php if ($_SESSION ["valid_user"]!='invitado' and $russ['tipo'] =="root") { ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php } ?></td>			 
							<td><?php 
									if ($_SESSION ["valid_user"]!='invitado' and $russ['tipo'] =="root") { ?>
										<input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff');" value="<?php echo $row['id']?>" style="cursor:pointer;" /><?php 
									}  
																			
									if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
									  &nbsp;&nbsp;&nbsp;<a href="javascript:ir('<?php echo $row["inv"];?>','<?php echo $row["idunidades"];?>','<?php echo $palab;?>','rm');" class="tooltip" style="margin-left:12px;"><img src="images/pc.png" width="24" height="24" align="absmiddle"><?php if(COMP_exp($row["inv"])==true){ ?><span onmouseover="this.style.cursor='pointer';"><?php echo $verdetalles1.$row["inv"]." (".$row_exp["n_PC"].")"; ?></span><?php }else{ ?><span onmouseover="this.style.cursor='pointer';"><?php echo $row["inv"]." (Sin ".$btEXPEDIENTE1.")"; ?></span><?php } ?></a><?php 
									} ?>							
							</td>
							<td class="Estilo2"><?php  echo $row["inv"];?></td>
							<td class="Estilo2"> <?php  echo $row["descrip"];?></td>
							<td class="Estilo2"><?php  echo $row["idarea"];?></td>
							<td class="Estilo2"><?php  echo $row["categ"];?></td>
							<td class="Estilo2"> <?php  echo $row["tipo"];?></td>
							<td class="Estilo2"><?php  echo $row["custodio"];?></td>
						</tr><?php 
						$p++;
					}?>
					<tr><td colspan="2"></td></tr>
					<tr>
						<td class="Estilo2">&nbsp;</td>
						<td colspan="7" class="Estilo2"><?php 
							if ($_SESSION ["valid_user"]!='invitado' and $russ['tipo'] =="root") {   
								if(($total_registros) !=0){ ?>
									<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
									<input type="hidden" name="eliminar"/>
									<input type="hidden" name="crash"/>
									<input name="editar" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" class="btn" value="<?php echo $bteditar;?>" /><?php 
								} ?>
								<input name="insertar" type="button" onclick="document.location='form-insertaraft.php';" class="btn"  value="<?php echo $btinsertar;?>" /><?php 
							} ?>
						</td>
					</tr><?php 
				}else{ ?>
					<tr>
						<td width="76" colspan="13"><br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1;?>.</div></div><?php if(($_SESSION['valid_user']) !="invitado"){?><br><div align="center"><input name="insertar" type="button"  onclick="document.location='form-insertaraft.php';" class="btn"  value="<?php echo $btinsertar;?>" /></div><?php } ?></td>
					</tr> <?php 
				} ?>
			</table>
		</form>	<?php 
	if(($total_registros) !=0){  include('navegador.php'); } ?>
	<div id='deta1'><div id='deta' style="display:block;"></div></div>
	</div>
<a href="#top"></a>	
</fieldset><br>
   <?php include("version.php");?>
<div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

