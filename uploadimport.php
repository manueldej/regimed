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
// LOG
$log = '=== ' . @date('Y-m-d H:i:s') . ' ===============================' . "\n"
        . 'FILES:' . print_r($_FILES, 1) . "\n"
        . 'POST:' . print_r($_POST, 1) . "\n";
$fp = fopen('upload-log.txt', 'a');
fwrite($fp, $log);
fclose($fp);


// Result object
$r = new stdClass();
// Result content type
header('content-type: application/json');

// Uploading folder
$folder = 'importar/';
// if (!is_dir($folder))
   // mkdir($folder);
// If specifics folder 
// $folder .= $_POST['folder'] ? $_POST['folder'] . '/' : '';
// if (!is_dir($folder))
   // mkdir($folder);


// If the file is an image
$upload_ext = strrchr($_FILES['fichero']['name'],".");
if (preg_match('/image/i', $_FILES['fichero']['type'])) {

    $filename = $_POST['value'] ? $_POST['value'] :
            $folder . sha1(@microtime() . '-' . $_FILES['fichero']['name']) . '.jpg';
} else {
	if(($upload_ext) !=".cpe"){
		$tld = explode($_FILES['fichero']['name'],3);
		$tld = $tld[count($tld) - 1];
		$filename =  $folder.$_FILES['fichero']['name'];
		move_uploaded_file($_FILES["fichero"]["tmp_name"], $filename);
		chmod($filename,0777);
		$path = str_replace('uploadimport.php', '', $_SERVER['SCRIPT_NAME']);
	}else{
		$r->error = "error";
	}
}
echo json_encode($r);
?>
