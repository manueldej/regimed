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
include('mensaje.php');	
$sel = "select visitas FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$usx = mysqli_query($miConex, "select * FROM usuarios WHERE login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$russx = mysqli_fetch_array($usx);
$nrusx=mysqli_num_rows($usx);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$upload_extensions = array(".txt", ".zip", ".rar", ".pdf", ".doc", ".xls", ".xlsx", ".jpg", ".docx", ".odt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT");	
include('barra.php');?>
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
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<script type="text/javascript" src="ajax.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="buscad">
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($btentramite);?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
<?php
$e="";
$pendientes ="";
if(isset($_GET['noti']) !=""){ $pendientes = $_GET['noti'];}

	if(isset($_POST['restaurar'])){
		@$marcado = @$_POST['marcado'];
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btbajas.".","cancel","bajas.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		}	
		foreach($marcado as $rest){
			$sql1z = "select * FROM bajas_aft WHERE id='".$rest."'";
			$resultz = mysqli_query ($miConex, $sql1z) or die(MYSQL_ERROR());
			$area = mysqli_fetch_array($resultz);				
			@unlink("dt/".$area['link']);
			$sqlz = "insert into aft (id_area, inv, descrip, estado, idarea, sello, marca, no_serie, modelo, categ,tipo,custodio,t_AFT,idunidades) values ('".$area['id_area']."', '".$area['inv']."', '".$area['descrip']."', 'A', '".$area['idarea']."','".$area['sello']."', '".$area['marca']."','".$area['no_serie']."','".$area['modelo']."','".$area['categ']."','".$area['tipo']."','".$area['custodio']."','".$area['t_AFT']."','".$area['idunidades']."')";
			$resultvz = mysqli_query($miConex, $sqlz) or die(mysql_error());	
			
			$sql4v = "DELETE FROM bajas_aft WHERE  id='".$rest."'";
			$resultado4v = mysqli_query($miConex, $sql4v) or die(MYSQL_ERROR());

			//insertar  en exp		
			if((strtolower($area['categ'])) =="computadoras"){			
			$sql1e = "select * FROM bajas_exp WHERE inv='".$area['inv']."'";
			$resulte = mysqli_query ($miConex, $sql1e) or die(MYSQL_ERROR());
			$areaexp = mysqli_fetch_array($resulte);	

			$sqlaf = "insert into exp (idarea,id_area,inv,CPU,PLACA,CHIPSET,MEMORIA,MEMORIA2,GRAFICS,DRIVE1,DRIVE2,DRIVE3,DRIVE4,SONIDO,RED,RED2,OS,custodio,n_PC, idunidades) values ('".$areaexp['idarea']."','".$areaexp['id_area']."',  '".$areaexp['inv']."', '".$areaexp['CPU']."', '".$areaexp['PLACA']."', '".$areaexp['CHIPSET']."', '".$areaexp['MEMORIA']."','".$areaexp['MEMORIA2']."','".$areaexp['GRAFICS']."','".$areaexp['DRIVE1']."','".$areaexp['DRIVE2']."','".$areaexp['DRIVE3']."','".$areaexp['DRIVE4']."','".$areaexp['SONIDO']."','".$areaexp['RED']."','".$areaexp['RED2']."','".$areaexp['OS']."','".$areaexp['custodio']."','".$areaexp['n_PC']."', '".$areaexp['idunidades']."')";
			  $resultaf = mysqli_query($miConex, $sqlaf) or die(MYSQL_ERROR());
		
				$sql4 = "DELETE FROM bajas_exp WHERE inv='".$areaexp['inv']."'";
				$resultado4 = mysqli_query($miConex, $sql4) or die(MYSQL_ERROR());			
			}	
            // Buscar la categoria para agregar el total
			$ff="SELECT * FROM areas";
			$resulta = mysqli_query($miConex, $ff) or die(MYSQL_ERROR());
			if (!$resulta) {
				echo 'No se puede ejecutar la Consulta: ' . mysql_error();
				exit;
			}

			$num_campo = mysqli_num_fields($resulta);
			
			
			for ($ia=1; $ia<=$num_campo;$ia++) {
				 $fields = mysqli_fetch_field_direct ($resulta, $ia-1);
				 $nom_campo = $fields->name;
	
            	if ($nom_campo == strtolower($area['categ']))  {
					$sql2="Select ".strtolower($area['categ'])." FROM areas WHERE nombre='".$area['idarea']."'";
					$resultado1 = mysqli_query($miConex, $sql2)  or die("La consulta fall&oacute;: " . mysql_error());
					$linea = mysqli_fetch_array($resultado1);	
					
					$valor_col =$linea[strtolower($area['categ'])]+1;				  
					$sql3="UPDATE areas SET ".strtolower($area['categ'])."='".$valor_col."' WHERE nombre='".$area['idarea']."'";
					$result = mysqli_query($miConex, $sql3) or die("La consulta fall&oacute;: " . mysql_error()); 
				}
			}			
		} ?>
		<script type="text/javascript">document.location="registromedios1.php";</script><?php
	}
	if(isset($_GET['d'])){
		@$marcado = @$_GET['d'];
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btbajas.".","cancel","bajas.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		} ?>
		<div id="cira"> </div>
		<form action="bajas.php" method="post" enctype="multipart/form-data" name="form1x1" onsubmit="return alertab();";>
			<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">	<?php 		
		 		$delm1 = "select * FROM bajas_aft WHERE id='".$marcado."'";
		 		$qdelm1 = mysqli_query($miConex, $delm1) or die(mysql_error());
				$rdelm1 = mysqli_fetch_array($qdelm1);
				?>
				<tr> 
					<td align="center" colspan="2"/><div class="message"><?php echo $btnotabaja;?>.</div></td>
			    </tr>
				<tr> 
				  <td width="15%" align="right"><?php echo $btcertifica1;?>:</td>
				  <td width="15%"><input class="form-control" type="file" name="quy1x" id="quy1x"/>	</td>
			    </tr>				
				<tr> 
				<td height="25" align="right" valign="top">No. Inv:</td>
					<td><input name="invx" readonly class="form-control" id="invx" value="<?php echo $rdelm1['inv'];?>" size="23" maxlength="10" style="width: 25px;"/></td>
				</tr>
				<tr> 
				<td height="25" align="right" valign="top"><?php echo substr($btAreas,0,-1);?>:</td>
					<td><input name="idareax" readonly class="form-control" id="idareax" value="<?php echo $rdelm1['idarea'];?>" size="40"/></td>
				</tr>
				<tr>
				  <td align="right"><?php echo $Fecha;?>:</td>
				  <td><input name="fechax" readonly class="form-control" id="fechax" size="23" maxlength="10" style="width:20%"/> 
				  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fechax'));return false;" hidefocus="hidefocus"><img src="images/almana.png" name="popcal" width="25" height="22" border="0" align="absmiddle" id="popcal" title="fecha" style="position: absolute; margin-top: -25px; margin-left: 213px;" /></a></td>
				</tr>
				<tr>
					<td align="right"><?php echo $btdatosentidad4;?>:</td>
					<td><input name="organox" type="text" id="organox" size="40" class="form-control"><input name="idx" type="hidden" id="idx" value="<?php echo $rdelm1['id'];?>"></td>
				</tr>
				<tr> 
					<td colspan="2"><hr></td>
				</tr>
				<tr> 
					<td align="right"></td>
					<td><input type="submit" name="editadox" value="<?php echo $btaceptar;?>" class="btn">&nbsp;&nbsp;&nbsp;
					<input type="button" name="cancx" value="<?php echo $btcancelar;?>" onClick="document.location='bajas.php';" class="btn"></td>
				</tr>
			</table>
		</form><?php
	}
	if(isset($_POST['editadox'])){
			$idx = $_POST['idx'];
			$invx = $_POST['invx'];
			$idareax = $_POST['idareax'];
			$fechax = $_POST['fechax'];
			$organox = $_POST['organox'];
			
			$camino = array();
		    $camino = 'df/'.$organox.'/';
	
			if(!is_dir($camino)){
				mkdir($camino, 0777);
			} 
			
			if(is_uploaded_file($_FILES['quy1x']['tmp_name'])) {
				$li =  $_FILES['quy1x']['name'];
				$upload_ext = strrchr($li,".");
				if (in_array($upload_ext, $upload_extensions)) {				
					copy($_FILES['quy1x']['tmp_name'],$camino.$idx."_".$_FILES['quy1x']['name']);
				}else{ ?>
					<script type="text/javascript">alert('<?php echo $no_scr1." ".$li." ".$no_ext;?>'); document.location="bajas.php";</script> <?php					
				}				
			}			
			$fichero_destf = $idx."_".$_FILES['quy1x']['name']; 
			$seldo = "select * FROM bajas_aft WHERE id='".$idx."'";
			$qseldo = mysqli_query($miConex, $seldo) or die(mysql_error());
			$rseldo = mysqli_fetch_array($qseldo);
			$inv = $rseldo['inv'];
			$explot = explode("_",$rseldo['link']);
			$nfin = $explot[0];
			$uploext = strrchr($rseldo['link'],".");
			$nombrefinal = $explot[0]."_df".$uploext;
			//copy($camino.$rseldo['link'],"df/".$rseldo['link']);
			//rename($camino.$rseldo['link'],"df/".$nombrefinal);
			//@unlink($camino.$rseldo['link']);
			//@unlink("df/".$rseldo['link']);
			include('pdf/creapdf.php');		
			
			//creapdf($seldo);
			//creapdfx($invx,$idareax,$fechax,$organox);
			
			$delm = "DELETE FROM bajas_aft WHERE id='".$idx."'";
			$qdelm = mysqli_query($miConex, $delm) or die(mysql_error());
			
			$delm1 = "DELETE FROM bajas_exp WHERE inv='".$inv."'";
			$qdelm1 = mysqli_query($miConex, $delm1) or die(mysql_error());
			
			//insertar en el historial de las bajas para no perder la historia
			$inserhisto = "INSERT INTO historial_bajas (id_area, titulo, inv, fecha, idarea, tiene, link, organo, descrip, estado, sello, marca, no_serie, modelo, categ,tipo,custodio,t_AFT,idunidades) values ('".$rseldo['id_area']."','".$rseldo['link']."','".$rseldo['inv']."', '".$fechax."', '".$rseldo['idarea']."', 's','".$camino.$fichero_destf."','".$organox."','".$rseldo['descrip']."', 'B', '".$rseldo['sello']."', '".$rseldo['marca']."','".$rseldo['no_serie']."','".$rseldo['modelo']."','".$rseldo['categ']."','".$rseldo['tipo']."','".$rseldo['custodio']."','".$rseldo['t_AFT']."','".$rseldo['idunidades']."')";
			$histo = mysqli_query($miConex, $inserhisto) or die(mysql_error());
			
			
		
		?>
		<script type="text/javascript">document.location="destinobajas.php";</script><?php
	}
	if(isset($_POST['quitarf'])){
		$marcado = @$_POST['marcado'];
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btbajas.".","cancel","bajas.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		}	
		$lin = $_POST['link'];
		for($k=0; $k<count($marcado); $k++){
			$seldo = "select * FROM bajas_aft WHERE id='".$marcado[$k]."'";
			$qseldo = mysqli_query($miConex, $seldo) or die(mysql_error());
			$rseldo = mysqli_fetch_array($qseldo);
			@unlink($camino.$rseldo['link']);

			$delpv = "update bajas_aft set tiene= 'n' WHERE id='".$marcado[$k]."'";
			$qdelmv = mysqli_query($miConex, $delpv) or die(mysql_error());
			
			$delpv1 = "update bajas_aft set link= '' WHERE id='".$marcado[$k]."'";
			$qdelmv1 = mysqli_query($miConex, $delpv1) or die(mysql_error());
			
		}
	}
	if(isset($_POST['edit'])){
		$marcado = @$_POST['marcado'];
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btbajas.".","cancel","bajas.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		}	?>
		<form action="bajas.php" method="post" enctype="multipart/form-data" name="form1x">
			<table width="100%" border="0" cellspacing="2" cellpadding="2">	<?php 		
			for($k=0; $k<count($marcado); $k++){
		 		$delm1 = "select * FROM bajas_aft WHERE id='".$marcado[$k]."'";
		 		$qdelm1 = mysqli_query($miConex, $delm1) or die(mysql_error());
				$rdelm1 = mysqli_fetch_array($qdelm1);
				?>
				<tr> 
				  <td width="35%" align="right"><?php echo $ficher1;?>:</td>
				  <td width="65%"><?php if(($rdelm1['tiene']) =="s"){ echo "<b>".$rdelm1['link']."<b>&nbsp;&nbsp;&nbsp;&nbsp;"; } ?>
				    <input class="form-control" type="file" name="quy1[]" id="quy1<?php echo $k;?>" style="width: 250px;"/>
				  </td>
			    </tr>
				<tr> 
				<td height="25" align="right" valign="top">No. Inv :</td>
					<td><input name="inv[]" class="form-control" readonly id="inv[]" value="<?php echo $rdelm1['inv'];?>" size="23" maxlength="10" style="width: 90px;"/><td><input name="titulo[]" type="hidden" class="form-control" id="titulo[]" value="<?php echo $rdelm1['titulo']; ?>" size="40"></td></td>
				</tr>
				<tr> 
				<td height="25" align="right" valign="top"><?php echo substr($btAreas,0,-1);?> :</td>
					<td><input name="idarea[]" readonly class="form-control" id="idarea[]" style="width: 250px;" value="<?php echo $rdelm1['idarea'];?>" size="40" /></td>
				</tr>
				<tr>
				  <td align="right"><?php echo $Fecha;?>:</td>
				  <td><input readonly onClick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fecha<?php echo $k;?>'));return false;" name="fecha[]" class="form-control" id="fecha<?php echo $k;?>"  value="<?php echo $rdelm1['fecha'];?>" size="23" maxlength="10" style="width:25%" /> 
				  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fecha<?php echo $k;?>'));return false;" hidefocus="hidefocus"><img src="images/almana.png" name="popcal" width="25" height="22" border="0" align="absmiddle" id="popcal" title="fecha<?php echo $k;?>" style="position: absolute; margin-top: -25px; margin-left:213px;"/></a></td>
				</tr>
				<tr>
					<td align="right"><?php echo $btorganoemi;?>:</td>
					<td><input name="organo[]" class="form-control" id="organo[]" value="<?php echo $rdelm1['organo'];?>" onKeyUp="llamaorgano(this.value,'organo','organo[]','orgn');" size="23" maxlength="10" style="width: 250px;"/><span id="orgn" onClick="document.getElementById('orgn').style.display =='none';" class="mstra"></span></td>
				</tr>
				<tr> 
					<td colspan="2">
						<input name="id[]" type="hidden" value="<?php echo $rdelm1['id'];?>">
						<input name="link[]" type="hidden" value="<?php echo $rdelm1['link'];?>">
						<input name="tiene[]" type="hidden" value="<?php echo $rdelm1['tiene'];?>"><hr>
					</td>
				</tr>	<?php 
			} ?>
				<tr> 
					<td align="right"></td>
					<td><input type="submit" name="editado" value="<?php echo $btaceptar;?>" class="btn">&nbsp;&nbsp;&nbsp;
					<input type="button" name="canc" value="<?php echo $btcancelar;?>" onClick="document.location='bajas.php';" class="btn"></td>
				</tr>
			</table>
        </form>
		  <?php 		
	}
	if(isset($_POST['editado'])){
		$id = $_POST['id'];
		if ($_POST['titulo']!="sin Dictamen"){
			$titulo = $_POST['titulo'];
		}
		
		$inv = $_POST['inv'];
		$idarea = $_POST['idarea'];
		$fecha = $_POST['fecha'];
		$organo = $_POST['organo'];
		$link = $_POST['link'];
		$tiene = $_POST['tiene'];	
		$err=array();
		$camino = array();
		$camino = 'dt/'.$organo[0].'/';
	

		if(!is_dir($camino)){
			mkdir($camino, 0777);
		} 
		
		
		for($k=0;$k<count($id); $k++){
			if(is_uploaded_file($_FILES['quy1']['tmp_name'][$k])) {
				$titulo[$k] = $_FILES['quy1']['name'][$k];
				@copy($_FILES['quy1']['tmp_name'][$k],$camino.$id[$k]."_".$_FILES['quy1']['name'][$k]);
				$li[$k] =  $_FILES['quy1']['name'][$k];
				$upload_ext[$k] = strrchr($li[$k],".");
				if (in_array($upload_ext[$k], $upload_extensions)) {				
					$li[$k] = $_FILES['quy1']['name'][$k];
					$tiene[$k] = "s";
					$link[$k] = $id[$k]."_".$li[$k];
				}else{	  
					@unlink($camino.$organo[0].$id[$k]."_".$li[$k]);
					$tiene[$k] = "n";
					$link[$k] = "";
					$err[$k] = "El fichero: ".$li[$k].", tiene una extesi&oacute;n no v&aacute;lida<br>";
				}
				
			}
			if(($link[$k]) ==""){
				$vsa = "select link FROM bajas_aft WHERE id='".$id[$k]."'";
				$vs = mysqli_query($miConex, $vsa) or die(mysql_error());
				$rvs = mysqli_fetch_array($vs);
				@unlink($camino.$rvs['link']); 
				$tiene[$k] = "n";
				$link[$k] = "";
			}
			$delp = "update bajas_aft set titulo = '".htmlentities($titulo[$k])."', inv = '".$inv[$k]."', idarea = '".htmlentities($idarea[$k])."', fecha= '".$fecha[$k]."',organo= '".$organo[$k]."', tiene= '".$tiene[$k]."', link= '".htmlentities($camino.$link[$k])."' WHERE id='".$id[$k]."'";
			$qdelm = mysqli_query($miConex, $delp) or die(mysql_error());
		}  ?>
		<script type="text/javascript">document.location='bajas.php';</script>;<?php
	}
	if(isset($_POST['carg'])){
		$inv = @$_POST['inv'];
		$idarea = @$_POST['idarea'];
		$organo = @$_POST['organo'];
		$fecha = @$_POST['fecha'];
		$tiene = "n";
		$quy = "";
		$msg = "";
		$upload_extensions = array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt",".docx",".xls",".xlsx",".jpg",".tif",".png",".bmp",".gif", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT",".DOCX",".XLS",".XLSX",".JPG",".TIF",".PNG",".BMP",".GIF");		
		
		if(is_uploaded_file($_FILES['quy']['tmp_name'])) {
			@copy($_FILES['quy']['tmp_name'],$camino.$_FILES['quy']['name']);
			$quy1 =  $_FILES['quy']['name'];
			$upload_ext = strrchr($quy1,".");
			if (in_array($upload_ext, $upload_extensions)) {
				$quy = $_FILES['quy']['name'];
				$tiene = "s";
			}else{	  
				$msg = "<br>La extensi&oacute;n del fichero seleccionado no es&aacute; autorizada, s&oacute;lo se admiten <stron>.zip</stron>, <stron>.rar</stron>, <stron>.doc</stron>, <stron>.rtf</stron>, <stron>.txt</stron> y <stron>.pdf</stron>. Por favor seleccione otro fichero";
				@unlink($camino.$quy1);
				$e = "s";
			}
		}
		if((@$msg) ==""){ 
			$inre = "insert into bajas_aft (inv, idarea, tiene, link, organo, fecha) values ('".$inv."', '".htmlentities($idarea)."', '".$tiene."', '".$quy."', '".$organo."', '".$fecha."')";
			$qinre = mysqli_query($miConex, $inre) or die(mysql_error());
		}?>
		<script type="text/javascript">document.location='bajas.php';</script>;<?php
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

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !="") {
	$sql = "select * FROM bajas_aft WHERE idunidades='".$_COOKIE['unidades']."' limit ".$inicio.",".$registros;
}else{
	$sql = "select * FROM bajas_aft limit ".$inicio.",".$registros;
}

if ($pendientes !=0) {
	$sql ="select * FROM bajas_aft WHERE titulo='Sin Dictamen' limit ".$inicio.",".$registros;
}
	
$result= mysqli_query($miConex, $sql) or die(mysql_error());
$totalbaj=mysqli_num_rows($result);
$ggg=base64_encode($sql);
	
?>
			<script type="text/javascript">
				function check1(){
					var formValid = false;
					var f = document.form1;
					if((f.titulo.value) ==""){
						alert("Por favor escriba el Titulo de la Resolucion.");
						f.titulo.focus();
						formValid = false;;
					} else if((f.descripcion.value) ==""){
						alert('Por favor esciba una peue�a descripcion sobre la Resolucion');
						f.descripcion.focus();
						formValid = false;;
					} else { formValid =true;}
					return formValid;
				}
			</script>
		<div>
 </div>
<?php if((@$msg) !=""){ echo "<div class='vistauser1'><font size='2' color ='red'>".@$msg."</font></div>"; }
    if(!isset($_POST['edit']) AND !isset($_GET['d'])){ 
        if(($totalbaj) !=0){ ?>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $cuidado2;?><hr><input id="ok" class="btn" onclick="bValid1('<?php echo @$_GET['v']?>');" value="<?php echo $btaceptar;?>">&nbsp;<input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>"></div></div>			
		</div>
	</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="80%">
		<form name="form2" method="get" action="">
			&nbsp;&nbsp;&nbsp;<span ><?php echo $cantidadmost;?>:</span>
			<input name="pagina" type="hidden"  value="<?php echo $pagina;?>">
			<input name="mostrar" type="text" size="1" value="<?php if(isset($_GET["mostrar"])){ echo $_GET["mostrar"];}elseif(isset($_GET["registros"])){ echo $_GET["registros"];}elseif(!isset($_GET["registros"]) AND !isset($_GET['mostrar'])){ echo $rsel['visitas'];}elseif(($rsel['visitas']) ==""){ echo "5";}?>" onKeyPress="return acceptNum(event);" class="mostrar">
			<input name="mo"  type="submit" value="<?php echo $btver;?>" class="btn4">
			<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
			<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
			<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
        </form>
	        </td>
			<td width="20%">
				<div id="imprime">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr><?php 
							if(($_SESSION['valid_user']) !="invitado" AND ($totalbaj) !=0){ ?>
							  <td width="17%" class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=bajas_aft&gt=bajas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td><?php
							} ?>
							  <td width="19%" class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=bajas_aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
							  <td width="21%" class="exel"><a class="tooltip" href="w.php?query=<?php echo $ggg;?>&tb=bajas_aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></td>
							  <td width="43%" class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=bajas_aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
						</tr>
					</table>	
				</div>
			</td>
		</tr>
	</table>
  <?php	} ?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">	
		<form name="frm1" action="" method="post"><?php 
			if(($totalbaj) !=0){ ?>		
				<tr class="vistauser1"> 
					<td colspan="2" class="vistauser1"></td>
					<td class="vistauser1"><strong><span class="Estilo4">Inv.</span></strong></td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo $btAreas;?></span></strong></td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo $Fecha;?></span></strong></td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo $btAprueba;?></span></strong> </td>
					<td class="vistauser1"><strong><span class="Estilo4"><?php echo strtoupper($ficher1);?></span></strong></td>
				    <td class="vistauser1"><strong><span class="Estilo4"><?php echo $btdatosentidad3;?></span></strong></td>
				    <?php if (($russx['tipo']) =="root") { ?><td class="vistauser1"><strong><span class="Estilo4"><?php echo $bteliminar;?></span></strong></td><?php } ?>
				</tr><?php
				$p=0;
				$i=0;
					while($rows=mysqli_fetch_array($result)){ $i++; 
						$sedge=mysqli_query($miConex, "select entidad FROM datos_generales WHERE id_datos='".$rows['idunidades']."'") or die(mysql_error());
						$rsedge=mysqli_fetch_array($sedge); 
						
						// Saber nombre de la PC 
						$sqlexp = "select * from bajas_exp WHERE inv = '".$rows['inv']."'";
						$result_exp= mysqli_query($miConex, $sqlexp) or die(mysql_error());
						$row_exp=mysqli_fetch_array($result_exp);
						
						?>
						
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#CCFFCC');"  <?php if(($russx['tipo']) =="root" ){ ?> onClick="detalles('<?php echo $rows["id"]?>'); marca1(<?php echo $p;?>,'#ffffff');  <?php if(($rows['link']) !=""){ ?>dele1();<?php } ?>"<?php } ?>> 
					    	<td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php if(($russx['tipo']) =="root" ){ ?><input name="marcado[]" type="checkbox" style="display:none;" class="form-control" id="marcado<?php echo $p?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); <?php if(($rows['link']) !=""){ ?>dele1();<?php } ?>" value="<?php echo $rows["id"]?>" /><?php } ?></td>
							<td width="28"><?php 
							 if((strtoupper($rows["categ"])) =="COMPUTADORA" OR (strtoupper($rows["categ"])) =="COMPUTADORAS" OR (strtoupper($rows["categ"])) =="PC"){ ?>
								&nbsp;&nbsp;&nbsp;<a href="javascript:ir('<?php echo $rows["inv"];?>','<?php echo $rows["idunidades"];?>','<?php echo @$palab;?>','rm');" class="tooltip" style="margin-left:-1px; position:absolute; margin-top:4px;"><img src="images/pc.png" width="24" height="24" align="absmiddle"><span onmouseover="this.style.cursor='pointer';"><?php echo $verdetalles1.$rows["inv"]." (".@$row_exp["n_PC"].")";?></span></a><?php } ?>
							</td>
							<td width="28"> <?php 
								if(($rows['tiene']) =="s") { ?>
									<a target="_blank" href="<?php echo $rows['link'];?>"><img src="images/090910_folder.png" width="24" height="24" border="0"/></a> <?php 
								}else{ ?>
									<img src="images/090819_folders.png" width="24" height="24" /> <?php 
								}?>							
							</td>
							<td width="83"><?php echo $rows['inv'];?></td>
							<td width="208"><?php echo $rows['idarea'];?>
						  <input name="link[]" type="hidden" value="<?php echo $rows['link'];?>"></td>
							<td width="85"><?php echo $rows['fecha'];?></td>
							<td width="96"><?php echo $rows['organo'];?></td>
							<td width="158"><?php echo $rows['titulo'];?></td>
						    <td width="198"><?php echo $rsedge['entidad'];?></td>
						     <?php if (($russx['tipo']) =="root") { ?>
							<td width="60"><?php 
								if(($rows['link']) !=""){ ?>
									<img src="images/vaciar.png" width="17" height="17" border="0"  title="<?php echo $bteliminar;?>" onclick="checkLength1('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d','<?php echo $rows['id'];?>');"><?php 
								}else{ ?>
									<img src="images/vaciar1.png" width="17" height="17" border="0"><?php 
								} ?></td><?php } ?>
						</tr>  <?php
						$p++;
					}
					if(($russx['tipo']) =="root"){ ?>
						<tr>
							<td colspan="10">
								<input name="edit" type="submit" value="<?php echo $bteditar;?>" class="btn" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="quitarf" type="submit" class="btn" id="quitarf" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$quit;?>','');" value="<?php echo $btborradict;?>" />&nbsp;&nbsp;&nbsp;
								<input name="restaurar" type="submit" class="btn" id="restaurar" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$btrestaurar;?>','');" title="Dejar sin Efecto el proceso de Baja" value="<?php echo $btrestaurar;?>" />
							</td>
						</tr><?php
					} 
					include('navegador.php');
			}  ?>		
		</form><?php	
		if(($totalbaj) ==0){ ?>
			<tr> 
				<td colspan="10" align="center"><br><div class="message"><?php echo $noregitro3." ".$btmedios." ".$enlinea4." ".$btbaja;?></div></td>
			</tr>
			<tr> 
				<td colspan="10"><br><br><br><br><br></td>
			</tr><?php	
		}  ?>
	</table>
	<div id="detalle"></div><?php 
    } ?>
	
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<iframe width="174" height="189" name="gToday:normal:js/agenda.js" id="gToday:normal:js/agenda.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe>
