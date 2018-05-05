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
$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
@session_start();
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
$i=0;
$uCPanel = new colores();
if (isset($_REQUEST['ent'])) {
 $palabra=$_REQUEST['ent'];
}else{
  $palabra="";
}

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
 if ($_SESSION['valid_user']!="invitado") { 
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
	   $rsul = mysqli_query($sql_pref, $miConex) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
	   
	   $query = "SELECT * FROM usuarios WHERE login='".$_SESSION['valid_user']."'";
       $result = mysqli_query($query, $miConex) or die(mysql_error());
	   $rws = mysqli_fetch_array($result);
	   
    }else{
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='webmaster'";
	   $rsul = mysqli_query($sql_pref, $miConex) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
    } 

$cuantos = 15;
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
	{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$quer=" where idunidades='".$_COOKIE['unidades']."'";
		}else{
			$quer=" where ";
		}
	}	
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql="SELECT * FROM reg_claves where (equipo LIKE '%".$palabra."%' or login LIKE '%".$palabra."%' or usuario LIKE '%".htmlentities($palabra)."%') AND(idunidades='".$_COOKIE['unidades']."')";
	}else{
		$sql="SELECT * FROM reg_claves where equipo LIKE '%".$palabra."%' or login LIKE '%".$palabra."%' or usuario LIKE '%".htmlentities($palabra)."%'";
	}
	$query_limit = sprintf("%s ORDER BY usuario	LIMIT %d, %d",$sql, $inicio, $registros);
	$result=mysqli_query($query_limit,$miConex) or die(mysql_error());
	$num_resultados = mysqli_num_rows($result);
	
	//NAVEGADOR inicio
	if(isset($_GET['total_registros']))  {  
		$total_registros=$_GET['total_registros'];
	} else { 
		$all_rsDA = mysqli_query($sql,$miConex) or die(mysql_error());
		$total_registros = mysqli_num_rows($all_rsDA);	
	}
	if ($registros != 0) {
	 $total_paginas = ceil($total_registros / $registros);
	}
	
//NAVEGADOR	FIN
$us = mysqli_query("select * from usuarios where login='".$_SESSION ["valid_user"]."'",$miConex) or die(mysql_error());
$rus = mysqli_fetch_array($us);
if(($rus["tipo"]) =="root") { ?>
	<form id="frm1" name="frm1" method="post" action="">
		<table width="100%" border="0" align="center"cellspacing="0" cellpadding="0">
			<tr>
			  <td width="671" align="center"></td>
			</tr>
			<tr>
				<td align="center"><?php if ($num_resultados !=0){ ?>
						<table width="100%" border='0' align="center" cellspacing="0" class="table">
							<tr class="vistauser1"><?php if(($rus["tipo"]) =="root") { ?>
								<td width="20">
									<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
									<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
								</td><?php }?>
								<td width="216" align="center"><b><span class="Estilo4"><?php echo strtoupper($btCustodios);?></span></b></td>
								<td width="112" align="center"><b><span class="Estilo4">PC</span></b></td>
								<td width="144" align="center"><b><span class="Estilo4">LOGIN</span></b></td>
								<td width="138" align="center"><b><span class="Estilo4">SETUP</span></b></td>
								<td width="130" align="center"><b><span class="Estilo4"><?php echo strtoupper($btSistema);?></span></b></td>
								<td width="214" align="center"><b><span class="Estilo4"><?php echo strtoupper($btdatosentidad3);?></span></b></td>
							</tr><?php $p=0;
							while ($row=mysqli_fetch_array($result)){ $i++;
							  $sela = mysqli_query("select * from datos_generales where id_datos='".$row['idunidades']."'", $miConex) or die(mysql_error());
					          $rowsa = mysqli_fetch_array($sela);?>
							<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="exped('<?php echo $row['id'];?>'); marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["id"]?>');"> 
								<td width="5"><?php if(($rus["tipo"]) =="root") { ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /><?php }?></td>
								<td><?php echo $row["usuario"];?></td>
								<td><?php echo $row["equipo"];?></td>
								<td><?php echo $row["login"];?></td>
								<td><?php echo base64_decode($row["setup"]);?></td>
								<td><?php echo base64_decode($row["sistema"]);?></td>
								<td><?php echo $rowsa["entidad"];?></td>
							</tr><?php $p++;
							} 
							if(($rus["tipo"]) =="root") { ?>
							<tr>
								<td colspan="6">&nbsp;<input name="edit" type="submit" class="btn" id="edit" value="<?php echo $bteditar;?>" />&nbsp;&nbsp;
									<input name="del" type="submit" class="btn" id="del" value="<?php echo $bteliminar;?>" onClick="return confirm('Realmente desea Eliminar este registro?');"/>&nbsp;&nbsp;
								</td>
							</tr><?php
							}?>
						</table><?php 
					} ?>
				</td>
			</tr>
		</table>
	</form>
    <?php if ($num_resultados !=0){ include ("navegador.php");} ?>
	<?php }else{?>
	 <script type="text/javascript">document.location="expedientes.php";</script>
	<?php } ?>