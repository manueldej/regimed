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
//include('header.php'); 
if(isset($_GET['editar']) OR isset($_POST['new']) OR isset($_GET['n']) OR isset($_POST['mete'])){
	@session_start();
	require_once('connections/miConex.php');	
	include('chequeo.php');
}else{
	include('header.php');
}
include('script.php');
require("mensaje.php");
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$roo = $_SERVER['DOCUMENT_ROOT'];
$rutad= $roo.$pht1."res/";

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
$es="";
$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}

	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
if(isset($_GET['editar']) OR isset($_POST['new']) OR isset($_GET['n']) OR isset($_POST['mete'])){

}else{
		include('barra.php'); 
}?>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
<div id="buscad"> <?php

$e="";
	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		@$marcado = @$_POST['marcado'];
		$lin = @$_POST['link'];
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea1.$bteliminar.".","cancel","res.php");  			?>
			    <br> <?php include ("version.php");
	    	  exit;
			} 
		for($k=0; $k<count($marcado); $k++){
			$seldo = "select * from resoluciones where id='".$marcado[$k]."'";
			$qseldo = mysqli_query($miConex, $seldo) or die(mysql_error());
			$rseldo = mysqli_fetch_array($qseldo);
			@unlink("res/".$rseldo['link']);
			
			$delm = "delete from resoluciones where id='".$marcado[$k]."'";
			$qdelm = mysqli_query($miConex, $delm) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location='res.php';</script>;<?php
	}
	if(isset($_POST['quitarf'])){
		$marcado = @$_POST['marcado'];
		$lin = @$_POST['link'];
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea1.$quit.".","cancel","res.php");  			?>
			    <br>
				  <?php include ("version.php");
			  exit;
			}
		for($k=0; $k<count($marcado); $k++){
			$seldo = "select * from resoluciones where id='".$marcado[$k]."'";
			$qseldo = mysqli_query($miConex, $seldo) or die(mysql_error());
			$rseldo = mysqli_fetch_array($qseldo);
			@unlink("res/".$rseldo['link']);

			$delpv = "update resoluciones set tiene= 'n' where id='".$marcado[$k]."'";
			$qdelmv = mysqli_query($miConex, $delpv) or die(mysql_error());
		}?>
		<script type="text/javascript">document.location='res.php';</script> <?php
	}
	if(isset($_POST['edit']) OR isset($_GET['editar'])){
		if(isset($_POST['edit'])){ $marcado = $_POST['marcado'];}
		if(isset($_GET['editar'])){ $marcado = $_GET['marcado'];}
		$marca="";
		if((@$marcado) ==""){ 
			echo "<br><br>";
			show_message($strerror,$plea1.$bteditar.".","cancel","res.php");?>
			<br>
				<?php include ("version.php");
			 exit;
		}
		foreach($marcado AS $key){
			$marca .= "*".$key; 
		}
		$roo = $_SERVER['DOCUMENT_ROOT'];
		$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
		$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
		$rutac = $roo .$pht1;
		$orga = array();
		$handle = fopen($rutac."categorias.cat", "r");
		if ($handle){
			while (!feof($handle)) {
				$txt = trim(fgets($handle));
				$orga[]= $txt;
			}
		}
		fclose($handle);
		asort($orga);
			$marcado = $marca;
			$marcado = explode('*',$marcado); ?>
					<script language="JavaScript" >
		// Check for a blank field
							extArray = new Array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".pps", ".ppt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT", ".PPS", ".PPT",'.rtf','.RTF','.docx','.DOCX')
							function LimitAttach(file,igwt) {
								allowSubmit = false;
								if (!file) return;
								while (file.indexOf("\\") != -1)
								file = file.slice(file.indexOf("\\") + 1);
								ext = file.slice(file.indexOf(".")).toLowerCase();
								for (var i = 0; i < extArray.length; i++) {
									if (extArray[i] == ext) { allowSubmit = true; break; }
								}
								if (allowSubmit) {
									 document.getElementById(igwt).value =file;
								}else{
									alert("Solo se permiten las extenciones: txt, zip, rar, pdf, doc, rtf, odt, pps y ppt.\nPor favor, seleccione otro archivo.");
									document.getElementById(igwt).value ='';
								}
							}
				</script><?php
			if(isset($_POST['edit'])){ ?>
				<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($bteditar.' '.$btResoluciones);?></legend><?php
			} ?>
			<form action="" method="post" enctype="multipart/form-data" name="form1x" id="form1x">
				<table width="526" border="0" align="center" cellpadding="2" cellspacing="2">	<?php 		
					$k=0;
					foreach($marcado AS $k1){
						if(($k1) !=""){
							$delm1 = "select * from resoluciones where id='".$k1."'";
							$qdelm1 = mysqli_query($miConex, $delm1) or die(mysql_error());
							$rdelm1 = mysqli_fetch_array($qdelm1);
							?>
							<tr> 
								<td width="31%" align="right"><strong><?php echo $actual; ?>:</strong></td>
							  <td width="69%"><?php if(($rdelm1['tiene']) =="s"){ echo "<b><font color='red'>".$rdelm1['link']."</font></b>";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;
							  <input class="imputf" type="file" onblur="LimitAttach(this.value,'quy1<?php echo $k;?>');" name="quy1[]" id="quy1<?php echo $k;?>"/>						  </td>
							</tr>
							<tr> 
								<td align="right"><strong><?php echo  $title3; ?>:</strong></td>
								<td><input name="titulo[]" onkeypress="return handleEnter(this, event)" type="text" class="imput" id="titulo[]" value="<?php echo $rdelm1['titulo'];?>" size="40"></td>
							</tr>
							<tr> 
							<td height="39" align="right" valign="top"><strong><?php echo $DESCRIPCION; ?>:</strong></td>
								<td><textarea name="descripcion[]" cols="50" rows="2" class="imputtextarea" id="descripcion[]"><?php echo $rdelm1['descripcion'];?></textarea></td>
							</tr>
							<tr>
							  <td align="right"><strong><?php echo strtoupper ($Fecha); ?>:</strong></td>
							  <td><input name="fecha[]" type="text" class="imput" id="fecha<?php echo $k;?>"  value="<?php echo $rdelm1['fecha'];?>" size="23" maxlength="10" /> 
							  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fecha<?php echo $k;?>'));return false;" hidefocus="hidefocus"><img src="images/almana.png" name="popcal" width="25" height="22" border="0" align="absmiddle" id="popcal" title="fecha<?php echo $k;?>" /></a></td>
							</tr>
							<tr>
								<td align="right"><strong><?php echo $btorganoemi2; ?>:</strong></td>
								<td>
									<select name="organo[]" onkeypress="return handleEnter(this, event)" class="selectuno" id="organo[]"><?php 					
									$d=0;
									while($d< count($orga)){ ?>
										<option value="<?php echo $orga[$d];?>" <?php if(($rdelm1['organo']) ==$orga[$d]){ echo "selected";}?>><?php echo $orga[$d];?></option><?php 
										$d++;
									} ?>
								  </select>							</td>
							</tr>
							<tr> 
								<td colspan="2">
									<input name="id[]" type="hidden" value="<?php echo $rdelm1['id'];?>">
									<input name="link[]" type="hidden" value="<?php echo $rdelm1['link'];?>">
									<input name="tiene[]" type="hidden" value="<?php echo $rdelm1['tiene'];?>"><hr>							</td>
							</tr>	<?php 
							$k++;
						}
					} ?>
					<tr> 
						<td align="right"></td>
					  <td><input type="button" name="cancel" value="<?php echo $btcancelar;?>" onclick="window.parent.location='res.php';" class="btn">&nbsp;<input type="submit" name="editado" value="<?php echo $btaceptar;?>" class="btn">
					    <input type="hidden" name="uri" value="<?php if(isset($_POST['edit'])){ echo "n"; }else{ echo "p";} ?>"></td>
					</tr>
				</table>
			</form>
				</fieldset><?php
			        if(isset($_POST['edit'])){	?>
			   	<br><?php include ("version.php");?>
				<?php
			} ?>
		<iframe width="174" height="189" name="gToday:normal2:agenda1.js" id="gToday:normal2:agenda1.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe><?php 		
	}
		$upload_extensions = array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT");	
		if(isset($_POST['editado'])){
			$id = $_POST['id'];
			$urli = $_POST['uri'];
			$titulo = $_POST['titulo'];
			$descripcion = $_POST['descripcion'];
			$fecha = $_POST['fecha'];
			$organo = $_POST['organo'];
			$link = $_POST['link'];
			$tiene = $_POST['tiene'];
				
			for($k=0;$k<count($id); $k++){
				if(is_uploaded_file($_FILES['quy1']['tmp_name'][$k])) {
					@copy($_FILES['quy1']['tmp_name'][$k],"res/".$_FILES['quy1']['name'][$k]);
					$li[$k] =  $_FILES['quy1']['name'][$k];
					$upload_ext[$k] = strrchr($li[$k],".");
					if (in_array($upload_ext[$k], $upload_extensions)) {		
						$li[$k] = $_FILES['quy1']['name'][$k];
						$tiene[$k] = "s";
						@unlink("res/".$link[$k]);
					}else{	  
						@unlink("res/".$li[$k]);
					}
					$link[$k] = $li[$k];
				}
				if(($link[$k]) ==""){
					$vsa = "select link from resoluciones where id='".$id[$k]."'";
					$vs = mysqli_query($miConex, $vsa) or die(mysql_error());
					$rvs = mysqli_fetch_array($vs);
					@unlink("res/".$rvs['link']); 
					$tiene[$k] = "n";
					$link[$k] = "";
				}
				$delp = "update resoluciones set titulo = '".$titulo[$k]."', descripcion = '".$descripcion[$k]."', fecha= '".$fecha[$k]."',organo= '".$organo[$k]."', tiene= '".$tiene[$k]."', link= '".$link[$k]."' where id='".$id[$k]."'";
				$qdelm = mysqli_query($miConex, $delp) or die(mysql_error());
			} ?>
			<script type="text/javascript"><?php if(($urli) =='n'){ ?>document.location='res.php';<?php }else{ ?>window.parent.location='res.php';<?php }?></script><?php
		}

	$upload_extensions = array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT",".RTF",".rtf");	
	
	if(isset($_POST['mete'])){
		$titulo = @$_POST['titulo'];
		$descrip = @$_POST['descripcion'];
		$organo = @$_POST['organo'];
		$fecha = @$_POST['fecha'];
		$tiene = "n";
		$msg = "";
		$quy1="";
		if (is_uploaded_file($_FILES['quy']['tmp_name'])) {
			copy($_FILES['quy']['tmp_name'],$rutad.$_FILES['quy']['name']);		
			$quy1 =  $_FILES['quy']['name'];
			function mosChmodRecursive($path, $filemode=NULL){
				$ret = TRUE;
				if (isset($filemode))
					$ret = chmod($path, $filemode);
				return $ret;
			} 		
			$filePerms = '0777';
			$filemode = NULL;
			if ($filePerms != '') $filemode = octdec($filePerms);
			$chmodOk = TRUE;
			if (!mosChmodRecursive($rutad.$quy1, $filemode)) {
				$chmodOk = FALSE;
			}
			
			$upload_ext = strrchr($quy1,".");
			/*
			if (in_array($upload_ext, $upload_extensions)) {	
				$quy = $_FILES['quy']['name'];
				$tiene = "s";				
			}else{	  
				$msg = "<br>La extensi&oacute;n del fichero seleccionado no es&aacute; autorizada, s&oacute;lo se admiten <stron>.zip</stron>, <stron>.rar</stron>, <stron>.doc</stron>, <stron>.rtf</stron>, <stron>.txt</stron> y <stron>.pdf</stron>. Por favor seleccione otro fichero";
				unlink("res/".$quy1);
				$e = "s";
			}
			*/
		}

		if(($msg) ==""){ 
			$inre = "insert into resoluciones (titulo, descripcion, tiene, link, organo, fecha) values ('".htmlentities($titulo)."', '".htmlentities($descrip)."', '".$tiene."', '".$quy1."', '".strtoupper($organo)."', '".$fecha."')";		
			$qinre = mysqli_query($miConex, $inre) or die(mysql_error());
			$nuvoname = mysqli_insert_id($miConex);
			if (is_uploaded_file($_FILES['quy']['tmp_name'])) {
				rename($rutad.$quy1,$rutad.$nuvoname."_".$quy1);
				$inreup = "update resoluciones set link='".$nuvoname."_".$quy1."' where id='".$nuvoname."'";		
				$qinreup = mysqli_query($miConex, $inreup) or die(mysql_error());
			}
			//SI EL ORGANISMO QUE VIENE NO ESTA EN EL FICHERO, LO METO AGREGRO
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
			$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
			$rutac = $roo .$pht1;
			$orga = array();
			$handle = fopen($rutac."categorias.cat", "r");
			if ($handle){
				while (!feof($handle)) {
					$txt = trim(fgets($handle));
					$orga[]= $txt;
				}
			}
			fclose($handle);
			$HY ="n";
			if (!in_array($organo, $orga)) {
				$HY ="s";
			}

			if(($HY) =="s"){
				$logeo = fopen($rutac."categorias.cat", "a"); 
				fwrite($logeo,chr(10).strtoupper($organo));
				flock($logeo, 3);
				fclose($logeo);				
			}		
		}else{ ?>
			<script type="text/javascript">alert('Extension no soportada. no se insertara la resolucion.');window.parent.location='res.php';</script>;<?php 
		} ?>
		<script type="text/javascript">window.parent.location='res.php';</script>;<?php
	}
	if(isset($_POST['new']) OR isset($_GET['n'])){
		//$orga = array("MININT","MINAZ","MFP","MINBAS","SIME","CITMA","MITRANS","MINFAR","MINCULT","MIC","EMPRESA");?>
		<script language="JavaScript" >
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
			function dimesihay(file){
				varhay = "<?php echo $rutad;?>"+file;
				divResultaN = document.getElementById('ctado');
				ajaxN=objetoAjax();
			//	alert(varhay);
				ajaxN.open("GET", "sihay.php?h="+varhay,true);
				ajaxN.onreadystatechange=function() {

					if (ajaxN.readyState==4) {
						if((ajaxN.responseText) !=""){ 
							document.getElementById('quy').value=""; 
						//	divResultaN.innerHTML=ajaxN.responseText;
						//	var datosN=ajaxN.responseXML.documentElement;	
						}
					}				
				}
				ajaxN.send(null)
			}

			function check1() {
				// form validation check
				var formValid=false;
				var f = document.form1;
				if ( f.titulo.value == '' ) {
					alert('Por favor, debe escribir el Titulo de la Resolucion');
					f.titulo.focus();
					formValid=false;
				} else if ( f.descripcion.value == '' ) {
					alert('Por favor, debe escribir una vrebe descripcion de la Resolucion');
					f.descripcion.focus();
					formValid=false;
				} else if ( f.fecha.value == '' ) {
					alert('Por favor, debe seleccionar la Fecha');
					f.fecha.focus();
					formValid=false;
				} else if ( f.quy.value == '' ) {
					alert('Por favor, seleccione el Archivo a cargar');
					f.quy.focus();
					formValid=false;
				} else if ( f.quy.value !="" ) {
					extArray = new Array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".pps", ".ppt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT", ".PPS", ".PPT",'.rtf','.RTF','.docx','.DOCX');
					var file = f.quy.value;
					allowSubmit = false;
					if (!file) return;
					while (file.indexOf("\\") != -1)
					file = file.slice(file.indexOf("\\") + 1);
					ext = file.slice(file.indexOf(".")).toLowerCase();
					for (var i = 0; i < extArray.length; i++) {
						if (extArray[i] == ext) { allowSubmit = true; break; }
					}
					if (allowSubmit == false) {
						alert("Solo se permiten las extenciones: txt, zip, rar, pdf, doc, rtf, odt, pps y ppt.\nPor favor, seleccione otro archivo.");
						f.quy.value="";
						f.quy.focus();
						formValid=false;
					}else {	formValid=true;  }
				}			 

				return formValid;
			}
		</script><?php
		include("js/droparea.php"); ?>
		<script type="text/javascript" src="ajax.js"></script> 
		<div id="areas">
			<br>
			<form action="inserta_res.php" method="post" enctype="multipart/form-data" name="form1x" onSubmit="return check1();">
				<table width="47%" border="0" class="table" align="center" cellpadding="2" cellspacing="2" onClick="document.getElementById('orgn').style.display ='none';">
					<tr> 
						<td align="right" width="131"><strong>T&iacute;tulo:</strong></td>
						<td colspan="2"><input onKeyPress="return handleEnter(this, event)" required name="titulo" type="text" class="form-control" id="titulo" size="40"></td>
				    </tr>
					<tr> 
						<td align="right" valign="top"><strong>Descripci&oacute;n:</strong></td>
						<td colspan="2"><textarea required name="descripcion" cols="50" rows="2" class="imputtextarea" id="descripcion" style="width:351px; height:64px;"></textarea></td>
				    </tr>
					<tr>
						<td align="right"><strong>Fecha:</strong></td>
						<td width="275">
						<input name="fecha" readonly onKeyPress="return handleEnter(this, event)" type="text" required onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1x.fecha);return false;" class="form-control" style="width:101%" id="fecha"  value="" /></td>
						<td width="55"><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1x.fecha);return false;" hidefocus="hidefocus"><img src="images/almana.png" name="popcal" width="25" height="22" border="0" align="absmiddle" id="popcal" title="" /></a></td>
					
				    </tr>
					<tr>
						<td align="right"><strong>&Oacute;rgano Emisor:</strong></td>
						<td colspan="2">
							<input type="text" required autocomplete="off" class="form-control" name="organo" id="organo" onKeyUp="llamaorgano(this.value,'organo','organo','orgn');"><span id="orgn" onClick="document.getElementById('orgn').style.display =='none';" class="mstra" style="width:307px;"></span></td>
				    </tr>
					<tr> 
						<td valign="middle" align="right"><strong>Cargar Resoluci&oacute;n:</strong></td>
						<td colspan="2" valign="middle"><input class="imputf" type="file" name="quy" id="quy"/><span id="nambr"></span></td>
				    </tr>
					<tr> 
						<td align="right"></td>
						<td colspan="3">
							<input type="button" name="cancel" value="<?php echo $btcancelar;?>" onClick="window.parent.location='res.php';" class="btn">&nbsp;
							<input type="submit" onClick="return check1();" name="mete" value="<?php echo $strOK;?>" class="btn"></td>
					</tr>
				</table>			
			</form>
		</div>	
		<iframe width=174 height=189 name="gToday:normal2:agenda2.js" id="gToday:normal2:agenda2.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe><?php
	} ?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
