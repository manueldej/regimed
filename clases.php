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

function Valores($result) {
    $value = false;
    for ($i = 0; $i <= 1; $i++) {
        $row = mysqli_fetch_assoc($result);
    }
    if (isset($row[0])) {
        $value = $row[0];
    }
    unset($row);
    return $value;
}
// TRADUCE
function traduce($frase, $idiom){

	if(($frase) =="Default engine as of MySQL 3.23 with great performance" AND ($idiom) =='es'){
		$frase1 ="Motor de Almacenamiento predefinido a partir de MySQL 3.23 con gran rendimiento";
	}elseif(($frase) =="Hash based, stored in memory, useful for temporary tables" AND ($idiom) =='es'){
		$frase1 ="Basado en Hash, guardado en memoria, &uacute;til para tablas temporales ";
	}elseif(($frase) =="Supports transactions, row-level locking, and foreign keys" AND ($idiom) =='es'){
		$frase1 ="Soporte de transacciones, row-level locking y llaves externas";
	}elseif(($frase) =="Supports transactions and page-level locking" AND ($idiom) =='es'){
		$frase1 ="Soporte de transacciones, row-level locking";
	}elseif(($frase) =="/dev/null storage engine (anything you write to it disappears)" AND ($idiom) =='es'){
		$frase1 ="/dev/null Motor de Almacenamiento (lo que usted escriba se eliminar&aacute;)";
	}elseif(($frase) =="Example storage engine" AND ($idiom) =='es'){
		$frase1 ="Motor de Almacenamiento de ejemplo";
	}elseif(($frase) =="Archive storage engine" AND ($idiom) =='es'){
		$frase1 ="Motor de Almacenamiento de archivo";
	}elseif(($frase) =="CSV storage engine" AND ($idiom) =='es'){
		$frase1 ="Motor de Almacenamiento CSV";
	}elseif(($frase) =="Clustered, fault-tolerant, memory-based tables" AND ($idiom) =='es'){
		$frase1 ="Clusterizada, fault-tolerant, tablas memory-based";
	}elseif(($frase) =="Federated MySQL storage engine" AND ($idiom) =='es'){
		$frase1 ="Motor de Almacenamiento Federal MySQL";
	}elseif(($frase) =="Collection of identical MyISAM tables" AND ($idiom) =='es'){
		$frase1 ="Cotejamiento id&eacute;nticos a las tablas MyISAM";
	}elseif(($frase) =="Obsolete storage engine" AND ($idiom) =='es'){
		$frase1 ="Motor de Almacenamiento obsoleto";
	}else{$frase1 =$frase;}
	
	return $frase1;
}
///////////////
function muestra_privilegios($row=''){
if(($_COOKIE["leng"]) =="es"){require('spanish.php');}
if(($_COOKIE["leng"]) =="en"){require('english.php');}
	$grants = array(
        array('Select_priv', 'SELECT',$lee_datos),
        array('Insert_priv', 'INSERT',$lee_datos1),
        array('Update_priv', 'UPDATE',$lee_datos2),
        array('Delete_priv', 'DELETE',$lee_datos3),
        array('File_priv', 'FILE',$lee_datos4),
        array('Create_priv', 'CREATE',$lee_datos5),
        array('Alter_priv', 'ALTER',$lee_datos6),
        array('Index_priv', 'INDEX',$lee_datos7),
        array('Drop_priv', 'DROP',$lee_datos8),
        array('Create_tmp_table_priv', 'CREATE TEMPORARY TABLES',$lee_datos9),
        array('Create_view_priv', 'CREATE VIEW',$lee_datos10),
        array('Show_view_priv', 'SHOW VIEW',$lee_datos11),
        array('Create_routine_priv', 'CREATE ROUTINE',$lee_datos12),
        array('Alter_routine_priv', 'ALTER ROUTINE',$lee_datos13),
        array('Super_priv', 'SUPER',$lee_datos16),
        array('Process_priv', 'PROCESS',$lee_datos17),
        array('Reload_priv', 'RELOAD',$lee_datos18),
        array('Shutdown_priv', 'SHUTDOWN',$lee_datos19),
        array('Show_db_priv', 'SHOW DATABASES',$lee_datos20),
        array('Lock_tables_priv', 'LOCK TABLES',$lee_datos21),
        array('References_priv', 'REFERENCES',$lee_datos22),
        array('Repl_client_priv', 'REPLICATION CLIENT',$lee_datos23),
        array('Repl_slave_priv', 'REPLICATION SLAVE',$lee_datos24),
        array('Create_user_priv', 'CREATE USER',$lee_datos25)
	);

	$privs = array();
    $allPrivileges = TRUE;
    foreach ($grants as $current_grant) {
        if ((!empty($row) && isset($row[$current_grant[0]])) || (empty($row) && isset($GLOBALS[$current_grant[0]]))) {
            if ((!empty($row) && $row[$current_grant[0]] == 'Y') || (empty($row) && ($GLOBALS[$current_grant[0]] == 'Y' || (is_array($GLOBALS[$current_grant[0]]) && count($GLOBALS[$current_grant[0]]) == $GLOBALS['column_count'] && empty($GLOBALS[$current_grant[0] . '_none']))))) {
                    $privs[] = '<dfn title="' . $current_grant[1]." ".$current_grant[2] . '">' . $current_grant[1] . '</dfn>';
                
            } elseif (!empty($GLOBALS[$current_grant[0]]) && is_array($GLOBALS[$current_grant[0]]) && empty($GLOBALS[$current_grant[0] . '_none'])) {

                    $priv_string = '<dfn title="' . $current_grant[2] . '">' . $current_grant[1] . '</dfn>';

                $privs[] = $priv_string . ' (`' . join('`, `', $GLOBALS[$current_grant[0]]) . '`)';
            } else {
                $allPrivileges = FALSE;
            }
        }
   }
    if (empty($privs)) { $privs[] = '<dfn title="'.$lee_datos32.'.">USAGE</dfn>';} 
	elseif ($allPrivileges && (!isset($GLOBALS['grant_count']) || count($privs) == $GLOBALS['grant_count'])) {
        $privs = array('<dfn title="'.$lee_datos31.' GRANT.">ALL PRIVILEGES</dfn>');}
  return $privs;
}
//
function slashes($caden = '')
{
        $caden = str_replace('\\', '\\\\', $caden);
    return $caden;
}
?>