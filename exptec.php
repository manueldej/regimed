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
include('header.php'); 
include('script.php');
$us = mysqli_query("select * from usuarios where login='".$_SESSION ["valid_user"]."'",$miConex) or die(mysql_error());
$russ = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us); ?>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
	function prueba()	{
		document.header.enable(); 
	}	
	function prueba2()	{
		document.header.disabled();  
	}		
</script>
<?php
$palabra="";
$msg="";
$m="";
$i=0;
$rp="";
$logi=$_SESSION["valid_user"];
$us1 = mysqli_query("select * from usuarios where login='".$logi."'",$miConex) or die(mysql_error());
$russ1 = mysqli_fetch_array($us1);
if(isset($_POST['palabra'])){ $palabra = htmlentities($_POST['palabra']);}
if(isset($_GET['palabra'])){ $palabra = htmlentities($_GET['palabra']);}
if(isset($_GET['rp'])){ $rp = $_GET['rp'];}

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel,$miConex) or die(mysql_error());
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
			$sql = "SELECT * from exp WHERE idunidades = '".$_COOKIE['unidades']."'";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
		}else{
			$sql = "SELECT * from exp";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);	
		}
	}else{
		$sql = "SELECT * FROM exp WHERE  CPU LIKE '%".$palabra."%' or PLACA LIKE '%".$palabra."%' or CHIPSET LIKE '%".$palabra."%' or MEMORIA LIKE '%".$palabra."%' or MEMORIA2 LIKE '%".$palabra."%' or GRAFICS  LIKE '%".$palabra."%' or DRIVE1  LIKE '%".$palabra."%' or DRIVE2  LIKE '%".$palabra."%' or DRIVE3  LIKE '%".$palabra."%' or DRIVE4  LIKE '%".$palabra."%' or SONIDO  LIKE '%".$palabra."%' or RED  LIKE '%".$palabra."%' or RED2  LIKE '%".$palabra."%' or OS  LIKE '%".$palabra."%' or n_PC  LIKE '%".$palabra."%'";
		$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	}
	if(isset($_GET['query_limit'])){ $query_limit = base64_decode($_GET['query_limit']);}
	$result= mysqli_query($query_limit,$miConex) or die(mysql_error());
	$total_mm = mysqli_num_rows($result);
	$ggg = base64_encode($query_limit);
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($sql,$miConex) or die(mysql_error());
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN 

if(isset($_GET["msg"])){ $msg = base64_decode($_GET["msg"]);}
if(isset($_GET["m"])){ $m = "&m=m";}
if(isset($_GET["msg"])){ print'<meta http-equiv="refresh" content="4;URL=registromedios1.php?query_limit='.base64_encode($query_limit).'&palabra='.$_GET["palabra"].'"><span align="center" class="vistauser1"><em><strong><font size="2" color="red">'.$msg.'</font></strong></em></span>';}
$i=0;
include('barra.php');?>
<div id="buscad">
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btEXPEDIENTE1;?></legend> <?php
				if(($total_registros) !=0){ ?>
						<TABLE BORDER='0' cellpadding="0" cellspacing="0" class="table" >
							<tr>
								<td class="vistauser1">&nbsp;</td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">CPU</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">MOTHERBOARD</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $Memorias1;?></font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $Memorias1;?></font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $bttargeta;?></font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD1</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD2</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD3</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD4</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $btRED;?>1</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $btRED;?>2</font><strong></span></td>
							</tr><?php 
							$p=0;
						WHILE ($row=mysqli_fetch_array($result)){ $i++;?>
							<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $p;?>,'#ffffff')"> <?php 
								if($russ['tipo']=="root"){ ?>
									<td>
										<input name="marcado[]" type="checkbox" class="boton" id="marcado[<?php echo $p;?>]" onclick="marca1(<?php echo $p;?>,'#ffffff')" value="<?php echo $row["id"]?>" /> 
									</td><?php 
								} ?>
								<td>&nbsp;<?php echo $row['CPU'] ?></td>
								<td>&nbsp;<?php echo $row["PLACA"] ?></td>
								<td>&nbsp;<?php echo $row["MEMORIA"] ?></td>
								<td>&nbsp;<?php echo $row["MEMORIA2"] ?></td>
								<td>&nbsp;<?php echo $row["GRAFICS"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE1"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE2"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE3"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE4"] ?></td>
								<td>&nbsp;<?php echo $row["RED"] ?></td>
								<td>&nbsp;<?php echo $row["RED2"] ?></td>
							</tr><?php
							$p++;
						} ?>
						</TABLE><?php 
					echo "</p>";
					if(($total_registros) !=0){  include('navegador.php'); }					
				}else{ ?>
					<div class='Estilo10'><?php echo $btconformado;?>.</div>
					<input name="cance" type="button" value="<?php echo $btcancelar;?>" class="btn" onclick="document.location='registromedios1.php';">
					<input name="crea" type="button" value="<?php echo $btCreate;?>" class="btn" onclick="document.location='form-insertarexp.php?inv=<?php echo @$categ;?>&marcado=<?php echo @$marcado;?>&idunidades=<?php echo $idunddes;?>';"><?php
				}?>
	<br>
<div id="footer" class="degradado" align="center">
<div class="container">
  <p class="credit">
    <?php include ("version.php");?>
    </p>
  </div>
</div>
</fieldset>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>