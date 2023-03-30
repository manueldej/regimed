<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    01/06/2016 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada (IN MEMORIAM)							         		            #
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
error_reporting( E_ALL );
@header ("Cache-Control: no-cache, must-revalidate");	 
@header ("Pragma: no-cache");	 
define( "_MOS_NOTRIM", 0x0001 );
define( "_MOS_ALLOWHTML", 0x0002 );
	function mosGetParam( &$arr, $name, $def=null, $mask=0 ) {
		$return = null;
		if (isset( $arr[$name] )) {
			if (is_string( $arr[$name] )) {
				if (!($mask&_MOS_NOTRIM)) {
					$arr[$name] = trim( $arr[$name] );
				}
				if (!($mask&_MOS_ALLOWHTML)) {
					$arr[$name] = strip_tags( $arr[$name] );
				}
				//if (!get_magic_quotes_gpc()) {
				//	$arr[$name] = addslashes( $arr[$name] );
				//}
			}
			return $arr[$name];
		} else {
			return $def;
		}
	}
	function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL){
		$ret = TRUE;
		if (is_dir($path)) {
			$dh = opendir($path);
			while ($file = readdir($dh)) {
				if ($file != '.' && $file != '..') {
					$fullpath = $path.'/'.$file;
					if (is_dir($fullpath)) {
						if (!mosChmodRecursive($fullpath, $filemode, $dirmode))
							$ret = FALSE;
					} else {
						if (isset($filemode))
							if (!@chmod($fullpath, $filemode))
								$ret = FALSE;
					} 
				} 
			} 
			closedir($dh);
			if (isset($dirmode))
				if (!@chmod($path, $dirmode))
					$ret = FALSE;
		} else {
			if (isset($filemode))
				$ret = @chmod($path, $filemode);
		} 
		return $ret;
	} 
?>