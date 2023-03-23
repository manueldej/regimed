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
$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$rutac = $roo .$pht1;
$TX=$_REQUEST['tx'];
$quees = $_REQUEST['quecosa'];
$idcomp = $_REQUEST['idcomp'];
$iddiv = $_REQUEST['iddiv'];


if ($quees=="organo") {
	$orga = array();
	$handle = fopen($rutac."categorias.cat", "r");
	if ($handle){
		while (!feof($handle)) {
			$txt = trim(fgets($handle));
			$orga[]= $txt;
		}
	}
	fclose($handle);
	natcasesort($orga);

	foreach($orga as $key){
		if(($TX) !=""){
			if(stristr($key,$TX) !=""){ ?>
				<div onclick="document.getElementById('<?php echo $idcomp; ?>').value=this.innerHTML; document.getElementById('orgn').style.display ='none';"><?php echo $key;?></div><?php
			}else{ ?>
				<script>
					document.getElementById('orgn').style.display ='none';
					document.getElementById('orgn').className ='mstra1';
				</script><?php
			}
		}
	}

}else if ($quees=="marcas") {
    $marca = array();
	$handle = fopen($rutac."marcas.cat", "r");
	if ($handle){
		while (!feof($handle)) {
			$txt = trim(fgets($handle));
			$marca[]= $txt;
		}
	}
	fclose($handle);
	natcasesort($marca);

	foreach($marca as $key){
		if(($TX) !=""){
			if(stristr($key,$TX) !=""){ ?>
				<div onclick="document.getElementById('<?php echo $idcomp; ?>').value=this.innerHTML; document.getElementById('<?php echo $iddiv; ?>').style.display ='none';"><?php echo $key;?></div><?php
			}else{ ?>
				<script>
					document.getElementById('<?php echo $iddiv; ?>').style.display ='none';
					document.getElementById('<?php echo $iddiv; ?>').className ='mstra1';
				</script><?php
			}
		}
	}

}else if ($quees=="categ") {
    $catego = array();
	$handle = fopen($rutac."categ.cat", "r");
	if ($handle){
		while (!feof($handle)) {
			$txt = trim(fgets($handle));
			$catego[]= $txt;
		}
	}
	fclose($handle);
	natcasesort($catego);

	foreach($catego as $key){
		if(($TX) !=""){
			if(stristr($key,$TX) !=""){ ?>
				<div onclick="document.getElementById('<?php echo $idcomp; ?>').value=this.innerHTML; document.getElementById('<?php echo $iddiv; ?>').style.display ='none';"><?php echo $key;?></div><?php
			}else{ ?>
				<script>
					document.getElementById('<?php echo $iddiv; ?>').style.display ='none';
					document.getElementById('<?php echo $iddiv; ?>').className ='mstra1';
				</script><?php
			}
		}
	}

}
?>