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
@session_start();
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('esp.php');}else{include('eng.php');}
include ('connections/miConex.php');
		$sqluser = "SELECT tipo FROM usuarios where login='".$_SESSION['valid_user']."'";
		$resultuser = mysqli_query($miConex, $sqluser) or die (mysql_error());
		$resultuser = mysqli_fetch_array($resultuser);
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
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
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
if((@$rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$palabra = $_REQUEST['ent'];
		$resux = "SELECT * FROM visitas";
		$result1 = mysqli_query($miConex, $resux);
		$fields1 = mysqli_num_fields($result1);
		$rows1   = mysqli_num_rows($result1);
		
		$fields  = mysqli_fetch_field_direct ($result1, 2); 
		$nam = $fields->name;
	$orderby = $nam;
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
			$sql = "SELECT * FROM visitas WHERE  fecha LIKE '%".$palabra."%' or user LIKE '%".$palabra."%' or ip LIKE '%".$palabra."%' or hora LIKE '%".$palabra."%'";
			$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
		

	if(isset($_REQUEST['query_limit'])){ $query_limit = base64_decode($_REQUEST['query_limit']);}
    $result=mysqli_query($miConex, $query_limit) or die(mysql_error());
	//NAVEGADOR inicio

	if(isset($_REQUEST['total_registros']))  {  
		$total_registros=$_REQUEST['total_registros'];
	} else { 
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);	
	}
	$total_paginas = ceil($total_registros / $registros);
	    if(($total_registros)!=0){ ?>
			<form name="frm1" method="post" action="">
				<table width="100%" align="center" border='0' cellpadding="0" cellspacing="0" class="table">
					<tr  class="vistauser1"> 
						<?php if(@$resultuser['tipo']=="root"){ ?>
						<td width="40">
							<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
							<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					    </td>
						<?php } ?>
						<td width="124"><a href="visitas.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=user"><?php echo strtoupper(substr($new6,0,-1)); if(($orderby) =="user"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="98"><a href="visitas.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=fecha"><?php echo strtoupper($Fecha); if(($orderby) =="fecha"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
						<td width="88"><a href="visitas.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=hora"><?php echo strtoupper($h_hora); if(($orderby) =="hora"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td> 
						<td width="294"><a href="visitas.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&orderby=ip">IP<?php if(($orderby) =="ip"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="11" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="11" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
					</tr><?php $i=0;$p=0;
				while ($row=mysqli_fetch_array($result)){$i++;  ?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["id"]?>');"> 
						<td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /></td>	
						<td><?php echo $row["user"];?></td> 
						<td><?php echo $myDate->formatDate($row['fecha'],"-","/");?></td>
						<td><?php echo $row["hora"];?></td>
						<td><?php echo $row["ip"];?></td>
					</tr><?php $p++;			
				} ?>
					<tr>
					  <td colspan="5"><hr></td>
					</tr>
					<?php if ((@$resultuser['tipo']) =="root") { ?>
					<tr>
						<td colspan="5">
						   <input name="create" id="create-user" type="button" class="btn" onClick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
						   <input type="hidden" name="crash">
						</td>
					</tr>
					<?php } ?>
				</table>		
			</form>
			<form name="formd" method="post" action=""><?php
				if((@$resultuser["tipo"]) =="root"){ ?><hr>
					<table width="324" border="0" cellspacing="2" cellpadding="2">
					  <tr> 
						<td align="center" class="Estilox">						
							<?php
							if(($total_registros) >30){ ?>
								<br><br><?php echo $masvivistas;?><br>
								&iquest;<?php echo $realmente;?>?<br>
								Si<input type="radio" name="borra" value="s" id="borra" onclick="si();" class="boton">						
								&nbsp;&nbsp;&nbsp;No<input type="radio" name="borra" value="n" class="boton" id="borra" onclick="no();" checked><div id="siborrar">
								<?php echo $cantielimia;?>&nbsp;<input name="c_eli" id="c_eli" type="text" size="1" class="mostrar" onKeyPress="return acceptNum(event);" onblur="javascript:if((this.value) ==''){ alert('Si usted va a Eliminar Visitas,\ndebe escriba la cantidad.'); return false;};">
								&nbsp;&nbsp;&nbsp;</div>
								<input name="delet" type="submit" id="delet" value="<?php echo $btaceptar;?>" class="btn"  onclick="return confirm('Realmente desea Eliminar esta cantidad?');">
								<?php						
							}?>
						</td>
					  </tr>
					</table><?php
				} ?>
			</form>
		<?php include('navegador.php'); 
        }else{ ?> 
	   <br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btvisita ." ".$enlinea1." ".$quecoin." -->".$palabra;?>.</div></div><br>
<?php   } ?>
