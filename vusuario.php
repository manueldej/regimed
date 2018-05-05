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
@session_start();
include ('connections/miConex.php');
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
$i=0;
$m="";
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
$palab="";
$logi=$_SESSION["valid_user"];
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$logi."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
$palabra=$_GET['ent'];
$idd=0;

$palabra=$_GET['ent'];

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
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
	if(($palabra) =="") 	{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "select * from usuarios WHERE idunidades = '".$_COOKIE['unidades']."'";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
		}else{
			$sql = "select * from usuarios";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);	
		}
	}else{
		$sql = "SELECT * FROM usuarios WHERE  login LIKE '%".$palabra."%' or nombre LIKE '%".$palabra."%' or idunidades = '".$palabra."'";
		$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	}

	$result= mysqli_query($miConex, $query_limit);
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN 
	if(($total_registros) !=0){ ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr><?php
			if((@$total_filas) >1){  ?>
            <td width="29%">
					<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
						<select name="unidades" id="unidades" class="boton" onchange="cambiaunidad(this.value,'ej1.php');">
							<option value="-1"><?php echo $btmostrartodo1?></option><?php 
								while ($row1=mysqli_fetch_array($reado)){ ?>					
									<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
								} ?>
						</select>
							<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
							<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
							<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">				
					</form>
			</td><?php 
			} ?>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
						<form name="mst" method="post" action="" id="mst">
							<span><?php echo $cantidadmost;?>:</span>
							<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
								<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
								<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
								<input name="mostrar" id="vers" type="text"  size="1" readonly  value="<?php if (@$rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
								<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
							</span>	
								<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
								<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
								<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
								<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
								<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
						</form></div>
					</td>
				</tr>
		</table>
		<form name="frm1" method="post" action="v1.php">
			<table width="100%" border='1' class='table' cellpadding="0" cellspacing="0">
				<tr class="vistauser1">
					 <td width="20">
						<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</td>
					<td width="50" align='center'><div align="left"><b>LOGIN</b></div></td>
					<td width="200" align='center'><div align="left"><b><?php echo strtoupper($btNombre);?></b></div></td>
					<td width="161" align='center'><div align="left"><b><?php echo strtoupper($btnCargo);?></b></div></td>
					<td width="198" align='center'><div align="left" ><b><?php echo strtoupper('E-mail');?></b></div></td>
					<td width="205" align='center'><div align="left"><b><?php  echo strtoupper('areas'); ?></b></div></td>
				  <td width="87" align='center'><div align="left"><b><?php echo strtoupper($Sexo);?></b></div></td>
				</tr>  
				<?php   	
				$i = 0;
				$p=0;
					//$arreg = array();
				while($row=mysqli_fetch_array($result))    {  $i++;
					$selent=mysqli_query($miConex, "select * from datos_generales where id_datos='".$row['idunidades']."'") or die(mysql_error()); 
					$rselun=mysqli_fetch_array($selent);
					$idf = $row["id"]; ?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $idf; ?>');"> 
				       <td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $idf; ?>" style="cursor:pointer;" /></td>	
						<td width="46"><?php echo $row["login"];?></td>
						<td><?php echo $row["nombre"];?></td>
						<td><?php echo $row["cargo"];?></td>
						<td><?php echo $row["email"];?></td>
						<td><?php echo $row["idarea"];?></td>
						<td align="center">&nbsp;&nbsp;<?php if(($row["sexo"]) =="m"){ echo "<img src='images/female.png' width='16' height='18'>";} elseif(($row["sexo"]) =="h"){ echo "<img src='images/admin.png' width='16' height='18'>";}else{ echo "-";}?> </td>						
					</tr>
			          <?php  	$p++;	 
				} ?>
					<tr>
					  <td colspan="8"></td>
					</tr>
			<tr>
				<td colspan="8">
					<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
					<input type="hidden" name="crash">&nbsp;&nbsp;
					<input name="editar" type="submit" class="btn" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" value="<?php echo $bteditar;?>" />
					&nbsp;&nbsp;
					<input name="insertar"  type="button" onclick="document.location='#modal4';" class="btn"  value="<?php echo $btinsertar;?>" />
				</td>
			</tr>
		</table>
			<?php include('navegador.php');?>
		</form><?php
	}else{ ?>
		<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$new6." ".$quecoin." -->".$palabra;?>.</div></div><br><?php 
	} ?>
		<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="js/main.js"></script>