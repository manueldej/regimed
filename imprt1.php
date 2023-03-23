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

$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));

$carpeta= $roo.$pht1."importar/";
$fecha=date("dmY");
$fichero = 'import_exp.txt';

	$upload_ext = strrchr($fichero,".");
	$nomfichero = substr($fichero,0,-4);
		

	$ctas=0;
	if(!isset($_POST['carpeta'])){
		$gestor = fopen($carpeta.$nomfichero.'.txt', "r");
		while(!feof($gestor)){
			$dato = fgets($gestor, 4096);
			$findme   = 'Computer:';
			$pos = strstr($dato, $findme);
			if(($pos) !=""){ $ctas++; fclose ($gestor); break;}
		}
		@fclose ($gestor);
	}else{
		$ctas=1;
	}
	
	if(($ctas) !=0){	
		$DBcreated	= "1";
		$destin = "form-insertarexp.php";
		$configArray['sitename'] = trim( mosGetParam( $_POST, 'sitename', '' ) );
			
		$configArray['DBhostname'] = $DBhostname;
		$configArray['DBuserName'] = $DBuserName;
		$configArray['DBpassword'] = $DBpassword;
		$configArray['DBname']	 = $DBname;
	
	
		function populate_db() {
			global $errors;

			$mqr = @get_magic_quotes_runtime();
			@set_magic_quotes_runtime(0);
			$query = fread( fopen( $carpeta.$sqlfile, 'r' ), filesize( $carpeta.$sqlfile ) );
			@set_magic_quotes_runtime($mqr);
			$pieces  = split_sql($query);
			for ($i=0; $i<count($pieces); $i++) {
				$pieces[$i] = trim($pieces[$i]);
				if(!empty($pieces[$i]) && $pieces[$i] != "#") {
					mysqli_query($pieces[$i]);
					if (mysql_errno($miConex) !="") {
						$errors[] = array(mysql_error($miConex) );
						$merrors[]= array($pieces[$i]);
					}
				}
			}
		}

		function split_sql($sql) {
			$sql = trim($sql);
			$sql = @ereg_replace("\n#[^\n]*\n", "\n", $sql);

			$buffer = array();
			$ret = array();
			$in_string = false;

			for($i=0; $i<strlen($sql)-1; $i++) {
				if($sql[$i] == ";" && !$in_string) {
					$ret[] = substr($sql, 0, $i);
					$sql = substr($sql, $i + 1);
					$i = 0;
				}

				if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
					$in_string = false;
				}
				elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
					$in_string = $sql[$i];
				}
				if(isset($buffer[1])) {
					$buffer[0] = $buffer[1];
				}
				$buffer[1] = $sql[$i];
			}

			if(!empty($sql)) {
				$ret[] = $sql;
			}
			return($ret);
		}
			populate_db();		
		 
	} ?>

