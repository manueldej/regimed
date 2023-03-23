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
	function remmpl($texto){ 
		$a = str_ireplace("á","&aacute;",$texto);
		$e = str_ireplace("é","&eacute;",$a);
		$i = str_ireplace("í","&iacute;",$e);
		$o = str_ireplace("ó","&oacute;",$i);
		$u = str_ireplace("ú","&uacute;",$o);
		$n = str_ireplace("ñ","&ntilde;",$u);
		return $n; 
	}

	if(isset($_POST['ent']) OR isset($_GET['ent'])){
		if(isset($_REQUEST['ent'])){ $palabra = remmpl($_REQUEST['ent']); }
		if(isset($_REQUEST['ent'])){ $palabra = remmpl($_REQUEST['ent']); }
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		@session_start();
		include ('connections/miConex.php');
		include('script.php');
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
	}else{
		include('header.php'); 
		include('script.php');
		include('mensaje.php');
		include('barra.php');
		$palabra="";
		if(isset($_REQUEST['palabra'])){ $palabra = $_REQUEST['palabra'];}
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

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);

$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$russ = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
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
// SQL para la b�squeda
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql = "SELECT * FROM exp INNER JOIN (componentes) ON (exp.inv = componentes.idexp) WHERE  (CPU LIKE '%".$palabra."%') or (PLACA LIKE '%".$palabra."%') or (CHIPSET LIKE '%".$palabra."%') or (MEMORIA LIKE '%".$palabra."%') or (MEMORIA2 LIKE '%".$palabra."%') or (GRAFICS  LIKE '%".$palabra."%') or (DRIVE1  LIKE '%".$palabra."%') or (DRIVE2  LIKE '%".$palabra."%') or (DRIVE3  LIKE '%".$palabra."%') or (DRIVE4  LIKE '%".$palabra."%') or (SONIDO  LIKE '%".$palabra."%') or (RED  LIKE '%".$palabra."%') or (RED2  LIKE '%".$palabra."%') or (OS  LIKE '%".$palabra."%') or (n_PC  LIKE '%".$palabra."%') or (componentes.marca LIKE '%".$palabra."%') or (componentes.modelo LIKE '%".$palabra."%') or (componentes.no_serie LIKE '%".$palabra."%') or (componentes.fabricante LIKE '%".$palabra."%') or (componentes.capacidad LIKE '%".$palabra."%') or (componentes.cpuid LIKE '%".$palabra."%') or (componentes.socket LIKE '%".$palabra."%') or (componentes.cpucores LIKE '%".$palabra."%') or (componentes.tipo LIKE '%".$palabra."%') or (componentes.cache LIKE '%".$palabra."%') or (componentes.frecuencia LIKE '%".$palabra."%') or (componentes.tasa LIKE '%".$palabra."%') or (componentes.interfaz LIKE '%".$palabra."%') and idunidades='".$_COOKIE['unidades']."'"; 
}else{
	$sql = "SELECT * FROM exp INNER JOIN (componentes) ON (exp.inv = componentes.idexp) WHERE  (CPU LIKE '%".$palabra."%') or (PLACA LIKE '%".$palabra."%') or (CHIPSET LIKE '%".$palabra."%') or (MEMORIA LIKE '%".$palabra."%') or (MEMORIA2 LIKE '%".$palabra."%') or (GRAFICS  LIKE '%".$palabra."%') or (DRIVE1  LIKE '%".$palabra."%') or (DRIVE2  LIKE '%".$palabra."%') or (DRIVE3  LIKE '%".$palabra."%') or (DRIVE4  LIKE '%".$palabra."%') or (SONIDO  LIKE '%".$palabra."%') or (RED  LIKE '%".$palabra."%') or (RED2  LIKE '%".$palabra."%') or (OS  LIKE '%".$palabra."%') or (n_PC  LIKE '%".$palabra."%') or (componentes.marca LIKE '%".$palabra."%') or (componentes.modelo LIKE '%".$palabra."%') or (componentes.no_serie LIKE '%".$palabra."%') or (componentes.fabricante LIKE '%".$palabra."%') or (componentes.capacidad LIKE '%".$palabra."%') or (componentes.cpuid LIKE '%".$palabra."%') or (componentes.socket LIKE '%".$palabra."%') or (componentes.cpucores LIKE '%".$palabra."%') or (componentes.tipo LIKE '%".$palabra."%') or (componentes.cache LIKE '%".$palabra."%') or (componentes.frecuencia LIKE '%".$palabra."%') or (componentes.tasa LIKE '%".$palabra."%') or (componentes.interfaz LIKE '%".$palabra."%')";
}
$i = 0;
	$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	if(isset($_REQUEST['query_limit'])){ $query_limit = base64_decode($_REQUEST['query_limit']);}

	$result= mysqli_query($miConex, $query_limit) or die(mysql_error());
	$total_mm = mysqli_num_rows($result);
	$ggg = base64_encode($query_limit);

//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql) or die(mysql_error());
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN 
?>
<link href="css/template.css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo4 {color: #000000; font-weight: bold; }
-->
</style>
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
<script type="text/javascript">
	function limpia(){
		document.header.palabra.value ="";
		prueba();
	}
		function alertacomp(err,men,tipo) {
			var counx=0;
			for (i=0;i<frm1.elements.length;i++)   {
				if ((frm1.elements[i].type=="checkbox")&&(frm1.elements[i].checked==true))	 {
					counx = counx +1;
				}
			}
			if((counx) ==0){
				showAlert(4000,'<div class="alert negro"><button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.getElementById(\'cir\').innerHTML=\'\';">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
				return false;
			}
		}
</script>
<script type="text/javascript" src="ajax.js"></script>
<div id="buscad"><?php
if(isset($_REQUEST['n'])){ ?>
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($btregmedio);?></legend>
				<div align="center"><form action="" method="get" name="header" id="header" onSubmit=" return escribe();">
					<div><strong class="componentheading"><?php echo $filtr.substr($Por1,0,-1);?>: </b>
					<input name="palabra" type="text" id="palabra" size="10" autocomplete="off" class="imput" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="adjs(this.value,'s');"  onClick="limpia();"/>
				    </div>
				</form>
				</div>	
				<?php
}elseif (isset($_REQUEST['mostrar'])) { ?>
<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($btregmedio);?></legend>
 <div align="center">
	  <form action="" method="get" name="header" id="header" onSubmit=" return escribe();">
	    <div><b><?php echo $filtr.substr($Por1,0,-1);?>:</b>
	 	  <input name="palabra" type="text" id="palabra" size="10" autocomplete="off" class="imput" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="adjs(this.value,'s');"  onClick="limpia();"/>
	    </div>
	  </form>
	</div>	
<?php } ?>
<div id="paginac"><?php
		        if(($total_registros) !=0){ ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
								<form name="mst" method="post" action="detalleexp.php" id="mst">
									<span><?php echo $cantidadmost;?>:</span>
									<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
										<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
										<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
										<input name="mostrar" id="vers" type="text"  size="1" readonly  value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ echo $registros; } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
										<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
									</span>	
										<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
										<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
										<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
										<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
										<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
								</form></div>
							</td>
						    <td width="130">
								<div id="imprime" style="margin: 0px 65px;">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr><?php 
									if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
									  <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=areas&gt=expedientes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($s_email);?></span></a></td><?php
									} ?>
									  <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=areas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_pdf);?></span></a></td>
									  <td class="exel"><a class="tooltip" href="w.php?query=<?php echo $ggg;?>&tb=areas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_exel);?></span></a></td>
									  <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=areas" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($sav_print);?></span></a></td>
									</tr>
								  </table>				  
								</div>
							</td>
						</tr>
					</table>

					<form action="modificarexp.php" method="post" name="frm1">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
							<tr class="vistauser1">
								<td width="20"><?php if (($russ['tipo']) =="root") { ?>
									<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
									<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php }else {echo "&nbsp;"; } ?>
					            </td>
								<td><span><b><font color="black">&nbsp;&nbsp;INV</font><b></span></td>
								<td><span><b><font color="black">CPU</font><b></span></td>
								<td><span><b><font color="black">MOTHERBOARD</font><b></span></td>
								<td align="center"><span><b><font color="black"><?php echo $Memorias1;?></font><b></span></td>
								<td><span><b><font color="black"><?php echo $bttargeta;?></font><b></span></td>
								<td><span><b><font color="black">HDD1</font><b></span></td>
								<td><span><b><font color="black"><?php echo $btRED;?>1</font><b></span></td>
							</tr><?php 
							$p=0;
						while ($row=mysqli_fetch_array($result)){ $i++;?>
							<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual1(event,'<?php echo $row["id"]?>');"> 
				                <td width="5"><?php if (($russ['tipo']) =="root") { ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff');" value="<?php echo $row['inv']?>" style="cursor:pointer;" /><?php }else {echo "&nbsp;"; } ?></td>	
								<td>&nbsp;<?php echo $row['inv']; ?></td>
								<td>&nbsp;<?php echo $row['CPU']; ?></td>
								<td>&nbsp;<?php echo $row["PLACA"]; ?></td>
								<td>&nbsp;<?php echo $row["MEMORIA"]; ?></td>
								<td>&nbsp;<?php echo $row["GRAFICS"]; ?></td>
								<td>&nbsp;<?php echo $row["DRIVE1"]; ?></td>
								<td>&nbsp;<?php echo $row["RED"]; ?><input type="hidden" name="idunidades[]" value="<?php echo $row["idunidades"];?>"></td>
							</tr><?php
							$p++;
						} ?>
						<tr>
							<td colspan="8"><input name="editar" onclick="return alertacomp('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" class="btn" value="<?php echo $bteditar;?>" /></td>
						</tr>
						</table>
					</form><br><?php 
					if(($total_registros) !=0){ ?>
						<script type="text/javascript">
							function DoSubmit(){
								var emptyForm = true;
								with (document.navga){      
									emptyForm = (pagina.value == "");		
									if (!emptyForm)	{
										submit();	
									}	
								}
							}
						</script>
						<?php 
						include('navegador.php');
					}
				}else{ ?>
					<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1." ".$quecoin." -->".remmpl($palabra);?>.</div></div><br><?php
				}?>
			</div>
<div id="deta"></div>
</fieldset><?php
	if(!isset($_REQUEST['ent'])){ ?>
		<br>
		<?php include ("version.php");
	} ?>
</div>
<div id='deta1'><div id='deta'></div></div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>