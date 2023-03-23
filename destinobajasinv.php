<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
session_start(); 
$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$ruta = $roo."/".substr($pht1,1);
$file = "RegistroBajasy.txt";
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');} 
		$i=0;
		$array = array();
		$array1 = array();
		$handlex=opendir('./df');
		$gg=0;		
		while ($filex = readdir($handlex)) { 
			$resto = strtoupper(substr ($file, 0, -3));    
			if ($filex != "." && $filex != "..") { 
				$exp = explode("_",$filex);
				if(($exp[1]) !=""){
					$array1[] = $filex;
					$gg++;
				}
			} 
		}
		closedir($handlex);				
		$total_registros=$gg;
		$handle=@fopen($ruta.$file,'r');
		$g=0;
		if(($handle) AND !empty($array1)){ ?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btDESTINO1;?></legend>
		<TABLE width="68%" BORDER='0' align="center" bordercolor='#AFCBCF' class='sgf1' align='center' >
					<tr>
						<td class="vistauser1"><b>INV</b></td>
						<td class="vistauser1"><b><?php echo $btAreas1;?></b></td>
						<td class="vistauser1"><b><?php echo strtoupper($Fecha);?></b></td>
						<td class="vistauser1"><b><?php echo $btDESTINO2;?></b></td>
						<td class="vistauser1"><b><?php echo $btcertifica2;?></b></td>
					</tr><?php
					while(!feof($handle)){
						$buffer=fgets($handle,4096);
						$array = explode(';', htmlspecialchars($buffer)); ?>
						<tr><?php
							$expl = explode("_",$array1[$g]); ?>
								<td><?php echo $array[1]; ?></td>
								<td><?php echo $array[2]; ?></td>
								<td><?php echo $array[3]; ?></td>
								<td><?php echo $array[4]; ?></td><?php 
							if(($expl[0]) !=""){ 					?>
								<td><a href="<?php echo "df/".$expl[0]."_".$expl[1];?>" target="_blank" title="<?php echo $click1.$descarg.$btcertifica1.": ".$expl[1];?>"><?php echo substr($expl[1],0,-4);?></td><?php
							} ?>
						</tr><?php
						$g++;					
					} ?>
					<tr>
						<td colspan="5" align="center"><span class="navegador"><?php echo $bttotalreg.": <font color='red'>".$total_registros."</font>";?></span></td>
					</tr><?php
					fclose($handle); ?>				
			</table> <?php
		} else{ 
			echo '<div align="center"><div class="message" align="center">'.$noregitro3.$btbajas.$enlinea3.'</div></div>';
		}?>
</fieldset>
