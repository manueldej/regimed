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