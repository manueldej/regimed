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
include ('script.php'); ?>

		
<?php include('barra.php'); ?>
<div id="buscad"> <?php
@define( "_VALID_MOS", 1 );
@define( "_VALID_MOS", 1 );
require_once( 'common.php' );

$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$carpeta= $roo.$pht1."importar/";

	if (isset($_POST['marcado'])){
	  $fichero = $_POST['marcado'];
	}else{ ?>
		<script type="text/javascript">
		   document.location="javascript:history.go(-1)"
		</script><?php 
	}
	
	$upload_ext = strrchr($fichero,".");
	$nomfichero = substr($fichero,0,-4);
	$ctas=0;
	
	if(!isset($_POST['importar'])){
		$gestor = fopen($carpeta.$nomfichero.'.txt', "r");
		while(!feof($gestor)){
			$dato = fgets($gestor, 4096);
			$findme   = 'Motherboard:';
			$pos = strstr($dato, $findme);
			if(($pos) !=""){ 
			  $ctas++; 
			  fclose ($gestor); 
			  break;
			}
		}
		@fclose ($gestor);
	}else{
		$ctas=1;
		$invent = $_POST['inv'];
		$unidad = $_POST['unidad']; 
		$id_area = $_POST['id_area']; 
		$custodio = $_POST['custodio'];
	}
	
	if(($ctas) !=0){
		
		function populate_db($txtfile, $carpeta) {
			$q=0;
			$campos=Array();
			$partes = Array('Computer','CPU','Motherboard','Chipset','Memory','Graphics','Drive','Drive','Sound','Network','OS');
			$query = fread(fopen($carpeta.$txtfile, 'r' ), filesize($carpeta.$txtfile));
			$pieces  = split_sql($query);
				
				for ($i=0; $i<count($pieces); $i++) {
					$pieces[$i] = trim($pieces[$i]);				
					if(!empty($pieces[$i]) && $pieces[$i] != "#") {				
					   $user[$i] = str_replace($partes, "", $pieces[$i]); 
					}
				}
				 
				for ($q=1; $q<count($partes); $q++){
					$valor[] = Array($user[$q]);          	
				}
				  
				array_push($valor, $user[10]);			
				
				$texto = $valor;
				
				return $texto; 
		}


		function split_sql($txt) {
			$txt = trim($txt);
			$txt = preg_replace("/(\w+) (\d+), (\d+)/i", "\n", $txt);			

			$buffer = array();
			$ret = array();
			$in_string = false;

			for($i=0; $i<strlen($txt)-1; $i++) {
				if($txt[$i] == ":" && !$in_string) {
					$ret[] = substr($txt, 0, $i);
					$txt = substr($txt, $i + 1);
					$i = 0;
				}

				if($in_string && ($txt[$i] == $in_string) && $buffer[1] != "\\") {
					$in_string = false;
				}
				elseif(!$in_string && ($txt[$i] == '"' || $txt[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
					$in_string = $txt[$i];
				}
				if(isset($buffer[1])) {
					$buffer[0] = $buffer[1];
				}
				$buffer[1] = $txt[$i];
			}

			if(!empty($txt)) {
				$ret[] = $txt;
			}
			return $ret;
		}
		
		$texto = populate_db($nomfichero.'.txt', $carpeta); 
		list ($computer, $cpu, $placa, $chipset,$memoria, $grafics,$driver1,$driver2, $sonido, $red, $os ) = $texto;
        
		$computer = implode(',', $computer);
		$cpu = implode(',', $cpu);
		$placa = implode(',', $placa);
		$chipset = implode(',', $chipset);
		$memoria = implode(',', $memoria);
		$grafics = implode(',', $grafics);
		$driver1 = implode(',', $driver1);
		$driver2 = implode(',', $driver2);
		$sonido = implode(',', $sonido);
		$red = implode(',', $red);
		//$os = implode(',', $os); ?>

		<form method="post" name="rellena" id="rellena" action="form-insertarexp.php" onsubmit="">
	        <input name="cpu" type="hidden" id="cpu" value="<?php echo $cpu; ?>">	
		    <input name="placa" type="hidden" id="placa" value="<?php echo($placa); ?>">
			<input name="chipset" type="hidden" id="chipset" value="<?php echo($chipset); ?>">
			<input name="memoria" type="hidden" id="memoria" value="<?php echo($memoria); ?>">	
			<input name="grafics" type="hidden" id="grafics" value="<?php echo($grafics); ?>">
			<input name="driver1" type="hidden" id="driver1" value="<?php echo($driver1); ?>">
			<input name="driver2" type="hidden" id="driver2" value="<?php echo($driver2); ?>">
			<input name="sonido" type="hidden" id="sonido" value="<?php echo($sonido); ?>">
			<input name="red" type="hidden" id="red" value="<?php echo($red); ?>">
			<input name="os" type="hidden" id="os" value="<?php echo($os); ?>">
			<input name="computer" type="hidden" id="computer" value="<?php echo($computer); ?>">
			<input name="inv" type="hidden" id="invent" value="<?php echo @$invent; ?>"> 
	        <input name="unidad" type="hidden" id="unidad" value="<?php echo @$unidad; ?>">
	        <input name="id_area" type="hidden" id="id_area" value="<?php echo @$id_area; ?>">
	        <input name="custodio" type="hidden" id="unidad" value="<?php echo @$custodio; ?>">
        </form>	
		<?php 
    }	?>


<script language="JavaScript" >
	function manda(){
		document.rellena.submit(); 
	}	
	manda();
</script> 


