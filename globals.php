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

// no acceder directamente 
defined( '_VALID_MOS' ) or die( 'Acceso restringido' );

/**
 * Usar 1 para emular register_globals = on
 * Usar 0 para emular regsiter_globals = off
*/
 
define( 'RG_EMULATION', 1 );
function checkInputArray( &$array, $globalise=false ) {
	static $banned = array( '_files', '_env', '_get', '_post', '_cookie', '_serVer', '_session', 'globals' );

	foreach ($array as $key => $value) {
		$intval = intval( $key );
		// PHP GLOBALS injection bug 
		$failed = in_array( strtolower( $key ), $banned );
		// PHP Zend_Hash_Del_Key_Or_Index bug
		$failed |= is_numeric( $key );
		if ($failed) {
			die( 'Variable ilegal <b>' . implode( '</b> o <b>', $banned ) . '</b> pasado al script.' );
		}
		if ($globalise) {
			$GLOBALS[$key] = $value;
		}
	}
}

/**
 * emular register globals = off
 */
function unregisterGlobals () {
	checkInputArray( $_FILES );
	checkInputArray( $_ENV );
	checkInputArray( $_GET );
	checkInputArray( $_POST );
	checkInputArray( $_COOKIE );
	checkInputArray( $_SERVer );

	if (isset( $_SESSION )) {
		checkInputArray( $_SESSION );
	}

	$REQUEST = $_REQUEST;
	$GET = $_GET;
	$POST = $_POST;
	$COOKIE = $_COOKIE;
	if (isset ( $_SESSION )) {
		$SESSION = $_SESSION;
	}
	$FILES = $_FILES;
	$ENV = $_ENV;
	$SERVer = $_SERVer;
	foreach ($GLOBALS as $key => $value) {
		if ( $key != 'GLOBALS' ) {
			unset ( $GLOBALS [ $key ] );
		}
	}
	$_REQUEST = $REQUEST;
	$_GET = $GET;
	$_POST = $POST;
	$_COOKIE = $COOKIE;
	if (isset ( $SESSION )) {
		$_SESSION = $SESSION;
	}
	$_FILES = $FILES;
	$_ENV = $ENV;
	$_SERVer = $SERVer;
}

/**
 * Emulatar register globals = on
 */
function registerGlobals() {
	checkInputArray( $_FILES, true );
	checkInputArray( $_ENV, true );
	checkInputArray( $_GET, true );
	checkInputArray( $_POST, true );
	checkInputArray( $_COOKIE, true );
	checkInputArray( $_SERVer, true );

	if (isset( $_SESSION )) {
		checkInputArray( $_SESSION, true );
	}

	foreach ($_FILES as $key => $value){
		$GLOBALS[$key] = $_FILES[$key]['tmp_name'];
		foreach ($value as $ext => $value2){
			$key2 = $key . '_' . $ext;
			$GLOBALS[$key2] = $value2;
		}
	}
}

if (RG_EMULATION == 0) {
	// forzar register_globals = off
	unregisterGlobals();	
} else if (ini_get('register_globals') == 0) {
	// php.ini tiene register_globals = off y asignar = on
	registerGlobals();
} else {
	// php.ini tiene register_globals = on y dejamos = on
	// check para spoofing
	checkInputArray( $_FILES );
	checkInputArray( $_ENV );
	checkInputArray( $_GET );
	checkInputArray( $_POST );
	checkInputArray( $_COOKIE );
	checkInputArray( $_SERVer );

	if (isset( $_SESSION )) {
		checkInputArray( $_SESSION );
	}
}
?>