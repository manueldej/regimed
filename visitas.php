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
require("mensaje.php");
class cdate{
	function formatDate($adate, $currTab, $futTab){
		if (!is_null($adate)){
			$sep = array();
			$sep = explode($currTab, $adate);
			return $sep[2].$futTab.$sep[1].$futTab.$sep[0];
		}else{
			return "";
		}
	}
}
$myDate = new cdate();
$palabra=""; ?>
<style type="text/css">
<!--
.Estilox {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 10px;
}
-->
</style>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>		
<script type="text/javascript">
	function no(){
	//alert('aborrar');
		document.getElementById('siborrar').style.display ="none";
	}
	function si(){
		document.getElementById('siborrar').style.display ="block";
	}
</script>
<script type="text/javascript" src="ajax.js"></script>
<?php include('barra.php');
	
		$sqluser = "SELECT tipo FROM usuarios where login='".$_SESSION['valid_user']."'";
		$resultuser = mysqli_query ($miConex, $sqluser) or die (mysql_error());
		$resultuser = mysqli_fetch_array($resultuser);
			
	if(isset($_REQUEST['crash'])){
		$marcado=@$_REQUEST['marcado'];
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea1.$bteliminar.".","cancel","visitas.php");  			?>
			    <br><br><div id="footer" class="degradado" align="center">
				    <div class="container">
					    <p class="credit"><?php include ("version.php");?></p>
				    </div>
			    </div><?php
			  exit;
			}
		foreach($marcado as $key){
			$deCon = "delete from visitas where id='".$key."'";
			$deq = mysqli_query($miConex, $deCon) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location="visitas.php";</script><?php
	}

	if(isset($_REQUEST['delet'])){
		$c_eli = $_REQUEST['c_eli'];
		$vist = mysqli_query($miConex, "select * from visitas") or die(mysql_error());
		$arra = array();
		
		while($rvist = mysqli_fetch_array($vist)){
			$arra[] = $rvist['id'];
		}
		$quit = array_splice($arra, 0, $c_eli); 
		
		foreach($quit as $ky){
			$dl = "delete from visitas where id = '".$ky."'";
			$qdl = mysqli_query($miConex, $dl) or die(mysql_error()); 
		}	 ?>
		<script type="text/javascript">document.location="visitas.php";</script><?php
	}
	
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if($_SESSION ["valid_user"]!='invitado' and $rsel['visitas'] !=""){
	$cuantos = $rsel['visitas'];
}
		$resux = "SELECT * FROM visitas";
		$result1 = mysqli_query($miConex, $resux) or die(mysql_error());
		$fields1 = mysqli_num_fields($result1);
		$rows1   = mysqli_num_rows($result1);
		//$nam  = mysql_field_name($result1, 2);
		
	//$orderby = $nam;
	$orderby = 'id';
	$asc="DESC";
	if(isset($_REQUEST['asc'])){ $asc = $_REQUEST['asc']; }
	if(isset($_REQUEST['asc'])){ $asc = $_REQUEST['asc']; }
	if(isset($_REQUEST['orderby'])){ $orderby = $_REQUEST['orderby']; }
	if(isset($_REQUEST['orderby'])){ $orderby = $_REQUEST['orderby']; }
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

// SQL para la busqueda
		if ($_SESSION ["valid_user"]!='invitado' and $resultuser["tipo"] =="root"){
			$sql = "SELECT * FROM visitas";
			$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
		}else{
			$sql="SELECT * FROM visitas where user='".$_SESSION['valid_user']."'";
			$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);			
		}

	if(isset($_REQUEST['query_limit'])){
      $query_limit = base64_decode($_REQUEST['query_limit']);
	}
    $result=mysqli_query($miConex, $query_limit) or die(mysql_error());
	
	//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros']))  {  
		$total_registros=$_REQUEST['total_registros'];
	} else { 
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);	
	}
	$total_paginas = ceil($total_registros / $registros);
?>
<form action="" method="post" name="contel" id="contel">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<script type="text/javascript">
function accion(id,q){
	if(confirm('Realmente desea Eliminar este registro?')){
		document.contel.marcado.value=id;
		document.contel.submit();
	}
}
function contextual(event,id){
		var iX = event.clientX;
		var iY = event.clientY;
		event.preventDefault();
		$('#divMenu').css({
			display:	'block',
			left:		iX,
			top:		iY
		});

		$('#divMenu').html('<ul><li onclick="accion(\''+id+'\',\'el\');"><a style="cursor:pointer; text-decoration:none;"><img align="asbmiddle" src="images/delete.png" width="16" height="16" title="Eliminar...">&nbsp;&nbsp;Eliminar</a></li></ul>');
}
</script>
<div id="divMenu"></div>
<div id="buscad"> 
<fieldset class='fieldset'>
<legend class="vistauserx"><?php echo $registr5.$de.$btvisita;?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div>
 <?php 
	if ($total_registros !=0){ ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
			    <td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
					<form name="mst" method="get" action="" id="mst">
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
					</form></div>
			    </td>
                <td width="63%"><b class="componentheading"><?php echo $filtr1;?>:&nbsp;</b>
                  <input name="texto" type="text" size="20" autocomplete="off" class="imput" maxlength="50" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="visitas(this.value);" onclick="this.value='';" />
			    </td>
            </tr>
        </table>
    <div class="sgf1" id="visitas">
		<form name="frm1" method="post" action="">
			<table width="100%" border="0" cellspacing="3" cellpadding="3">
				<tr>
					<td width="79%" valign="top">
						<table width="100%" align="center" border='0' cellpadding="0" cellspacing="0" class="table">
							<tr class="vistauser1">
								<td width="40"><?php if($_SESSION ["valid_user"]!='invitado' and @$rus['tipo'] =="root"){ ?>
									<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
									<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php }else{ echo "&nbsp;"; } ?>
					            </td>
								<td width="126"><a href="visitas.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=user"><?php echo strtoupper(substr($new6,0,-1)); if(($orderby) =="user"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
								<td width="100"><a href="visitas.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=fecha"><?php echo strtoupper($Fecha); if(($orderby) =="fecha"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
								<td width="90"><a href="visitas.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=hora"><?php echo strtoupper($h_hora); if(($orderby) =="hora"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
								<td width="241"><a href="visitas.php?registros=<?php echo $registros;?>&total_paginas=<?php echo $total_paginas;?>&=<?php echo $pagina;?>&total_registros=<?php echo $total_registros;?>&asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=ip"><?php echo "IP"; if(($orderby) =="ip"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
							</tr><?php 
							$i=0; $p=0;
							WHILE ($row=mysqli_fetch_array($result)){ $i++;	 ?>
								<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="<?php if (@$rus['tipo']=="root") {?>contextual(event,'<?php echo $row["id"]?>'); <?php } ?>"> 
				                    <td width="5"><?php if($_SESSION ["valid_user"]!='invitado' and @$rus['tipo'] =="root"){ ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /><?php }else{ echo "&nbsp;"; } ?></td>	
									<td><?php echo $row["user"];?></td>
									<td><?php echo $myDate->formatDate($row['fecha'],"-","/");?></td>
									<td><?php echo $row["hora"];?></td>
									<td><?php echo $row["ip"];?></td>
								</tr><?php 	
								$p++;
							}
							if ($_SESSION ["valid_user"]!='invitado' and $resultuser['tipo'] =="root") { ?>
								<tr>
									<td colspan="5"><input name="create" id="create-user" type="button" class="btn" onClick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
										<input type="hidden" name="crash">
									</td>
								</tr><?php 
							} ?>
					  </table>
				  </td>
				</tr>
			</table>
		</form>
		<form name="formd" method="post" action=""><?php
			if($_SESSION ["valid_user"]!='invitado' and $resultuser["tipo"] =="root"){ ?><hr>
				<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr> 
					<td align="center" class="Estilox">						
						<?php
						if(($total_registros) >30){ ?>
							<br><br><?php echo $masvivistas;?><br>
							<?php echo $btDesea;?><br>
							<label style="cursor:pointer;"><?php echo $SI;?><input type="radio" name="borra" value="s" id="borra" onclick="si();" class="boton"></label>
							&nbsp;&nbsp;&nbsp;<label style="cursor:pointer;">No<input type="radio" name="borra" value="n" class="boton" id="borra" onclick="no();" checked></label><div id="siborrar">
							<?php echo $btCantid;?>&nbsp;<input name="c_eli" id="c_eli" type="text" size="1" class="mostrar" onKeyPress="return acceptNum(event);" onblur="javascript:if((this.value) ==''){ alert('Si usted va a Eliminar Visitas,\ndebe escriba la cantidad.'); return false;};">
							&nbsp;&nbsp;&nbsp;<br><input name="delet" type="submit" onclick="if((document.getElementById('c_eli').value) ==''){ alert('Si usted va a Eliminar Visitas,\ndebe escriba la cantidad.'); return false;};" id="delet" value="<?php echo $btaceptar;?>" class="btn"></div>							
							<?php						
						}?>				</td>
				  </tr>
				</table><?php
			} ?>
		</form>
		<?php include('online.php'); ?>
		<?php include('navegador.php'); ?>
	</div><?php
}else{  ?> <br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btvisita ." ".$enlinea1." ".$quecoin." -->".$palabra;?>.</div></div><br><?php } ?>
</fieldset><br>
<?php include ("version.php");?>
<script type="text/javascript">no();</script>
<div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>