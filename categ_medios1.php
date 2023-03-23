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
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$qus = mysqli_query("select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($qus);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}

$ordena=@$_GET['ordena'];
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


$resultados = mysqli_query("SELECT id FROM tipos_medios");
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

$sql = "select* from tipos_medios limit $inicio, $registros";
$result= mysqli_query($sql);
?>

<?php include('barra.php');?>
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
<SCRIPT language='javascript'>
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
</script>
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $btcategmedios;?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div>
<?php
	if(isset($_GET['er'])){
		$dd = $strerror;
		$txtms = $noareac;?>
<div class="ContenedorAlert" id="cir"><div class="alert negro"><button class="close" type="button" onclick="cierrz();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $dd;?></b></font></div><div align="center"><b><?php echo $txtms;?>.</b></div></div></div>
<script language="javascript">
	$('.alert').fadeIn('slow');
	setTimeout(function(){$('.alert').fadeOut('slow')}, 3000);
</script>
<?php
}	?>
	<table width="712" border="0" align="center">
		<tr>
			<td align="CENTER" height="1px">
				<div id="imprime">
					<?php echo $btcategmedios; if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){?>
					<span class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=usuarios">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></span><?php } ?>&nbsp;&nbsp;&nbsp;<span class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=areas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></span>&nbsp;&nbsp;&nbsp;<span class="exel"><a class="tooltip" href="w.php?query=<?php echo $ggg;?>&tb=areas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></span>&nbsp;&nbsp;&nbsp;<span class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=usuarios" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></span></td></tr>
<tr>
<td>
	  
				</div>
			</td>
</tr>
		<tr>
			<td>
				<form name="form1" method="get" action="">
					<span ><?php echo $cantidadmost;?>:</span>
					<input name="pagina" type="hidden"  value="<?php echo $pagina;?>">
					<input name="mostrar" type="text" size="1" value="<?php if(isset($_GET["mostrar"])){ echo $_GET["mostrar"];}elseif(isset($_GET["registros"])){ echo $_GET["registros"];}elseif(!isset($_GET["registros"]) AND !isset($_GET['mostrar'])){ echo $rsel['visitas'];}elseif(($rsel['visitas']) ==""){ echo "5";}?>" onKeyPress="return acceptNum(event);" class="mostrar">
					<input name="mo"  type="submit" value="<?php echo $btver;?>" class="btn4">
					<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
					<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
					<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">		
				</form>
				<form name="frm1" method="post" action="v6.php">        
					<TABLE width="490" height="71" BORDER="0" cellpadding="0" cellspacing="0" class="table" align="center">
						<tr>
						  <td height="15" colspan="2" align="center"></td> 
						</tr> <?php  
						$p= 0; 
						$cta=0;
						$i=0;
						while($row=mysqli_fetch_array($result))    {	$i++;?>
							<tr id="cur_tr_<?php echo $p?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#DBE2D0');" <?php if(($row["id"]) >20){ ?> onClick="marca1(<?php echo $p;?>,'#ffffff');" <?php } ?>>							
								<td width="37" class="Estilo2"><?php   
									if(($row["id"]) >20){ $cta++; ?>
										<input name="marcado[]" type="checkbox" class="boton" id="marcado[<?php echo $p?>]" onClick="marca1(<?php echo $p;?>,'#ffffff');" value="<?php echo $row["id"]?>" /><?php  
									} ?>
								</td>
								<td width="453" height="21" class="Estilo2">&nbsp;&nbsp;<?php echo $row["nombre"];?></td>
							</tr><?php  		
							$p++;
						} if(($rus['tipo']) =="root"){	?>
							<tr align="center">
							  <td colspan="2" valign="top"><hr>
								<input name="insertar" type="submit" class="btn"  value="<?php echo $btinsertar;?>" /><?php
								if(($cta) !=0){ ?>
									<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
									<input type="hidden" name="crash">
									<input name="editar" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" class="btn" value="<?php echo $bteditar;?>" /><?php
								} ?>
							  </td> 
							</tr><?php 
						} ?>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td><?php include('navegador.php');?></td>
		</tr>
	</table>
<br>
<div id="footer" class="degradado" align="center">
	<div class="container">
		<p class="credit"><?php include ("version.php");?></p>
	</div>
</div>
</fieldset>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
