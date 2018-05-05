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
session_start(); 
include('header.php'); ?>

<?php include('barra.php'); ?>
<style type="text/css">
<!--
.Estilo2 {color: #000000}
.Estilo4 {color: #000000; font-weight: bold; }
-->
</style>
<div id="buscad">
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btDESTINO1;?></legend><?php 
$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$ruta = $roo."/".substr($pht1,1);
$file = "RegistroBajasy.txt";

$destinob = "select * from historial_bajas";
$qdestinob = mysqli_query($miConex, $destinob) or die(mysql_error());
$sihaydestinob = mysqli_num_rows($qdestinob);
$ggg=base64_encode($destinob);			
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');} 
		$i=0;
		$array = array();
		$array1 = array();
		$arrdf = array();
		$handlex=opendir('./df');
		$gg=0;		
		while ($filex = readdir($handlex)) { 
			$resto = strtoupper(substr ($file, 0, -3));  

			if ($filex != "." && $filex != "..") { 
				@$exp = explode("_",@$filex);
				if((@substr($exp[1],0,-4)) =="df"){
					$arrdf[]= @$filex;
				}
				if((@$exp[1]) !="" AND (@substr($exp[1],0,-4)) !="df"){
					@$array1[] = @$filex;
					$gg++;
				}
			} 
		}
		closedir($handlex);	include('pdf/creapdf.php');?>	
		<div id="imprime" style="float:right; margin-right:49px; margin-top:2px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="120%" class="pdf"><a class="tooltip" target="_blank" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=historial_bajas" onclick="<?php creapdfx('',$rqdestinob['inv'],$rqdestinob['idarea'],$rqdestinob['fecha'],$rqdestinob['organo']); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
				</tr>
			</table>	
		</div>
		<table width="68%" border='0' align="center" class='table' cellpadding="0" cellspacing="0" ><?php
		if(!empty($sihaydestinob)){
			$total_registros=$sihaydestinob;
			@$handle=fopen($ruta.$file,'r+'); ?>
					<tr>
						<td class="vistauser1"><b><span class="Estilo4">INV</span></b></td>
						<td class="vistauser1"><b><span class="Estilo4"><?php echo $btAreas1;?></span></b></td>
						<td class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></b></td>
						<td class="vistauser1"><b><span class="Estilo4"><?php echo $btDESTINO2;?></span></b></td>
						<td class="vistauser1"><b><span class="Estilo4"><?php echo $btdict;?></span></b></td>
						<td class="vistauser1"><b><span class="Estilo4"><?php echo $btcertifica2.$de.$btDESTINO2;?></span></b></td>
					</tr><?php $p=0;$explta = @explode("_",substr($array1[1],0,-4));
						while($rqdestinob = mysqli_fetch_array($qdestinob)){ $nom_dict = explode('/', $rqdestinob['titulo']); $nom_cert = explode('/', $rqdestinob['link']); ?>
					<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#DBE2D0');">
						<td><?php echo $rqdestinob['inv']; ?></td>
						<td><?php echo $rqdestinob['idarea']; ?></td>
						<td><?php echo $rqdestinob['fecha']; ?></td>
						<td><?php echo $rqdestinob['organo']; ?></td>
						<td><a href="<?php echo $rqdestinob['titulo'];?>" target="_blank" title="<?php echo $click1.$descarg.$btdict.": ".$rqdestinob['titulo'];?>"><?php print_r ($nom_dict[2]);?></td>
						<td><a href="<?php echo $rqdestinob['link'];?>" target="_blank" title="<?php echo $click1.$descarg.$btcertifica1.": ".$rqdestinob['link'];?>"><?php print_r ($nom_cert[2]); ?></td>
					    <?php 
							$p++;				
						} ?>
					</tr>
					<tr>
						<td colspan="6" align="center"><br><div align="center"><span class="navegador"><?php echo $bttotalreg.": <font color='red'>".$total_registros."</font>";?></span></div></td>
					</tr><?php
		} else{ ?>
				<tr> 
					<td ><br><div align="center"><div class="message" align="center"><?php echo $noregitro3.$btbajas.$enlinea3;?></div></div><br><br><br></td>
				</tr>
<?php
		}?>
		</table>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>