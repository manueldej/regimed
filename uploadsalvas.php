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
$folder = 'salvas/';
//if (!is_dir($folder))
//    mkdir($folder);
// If specifics folder 
//$folder .= $_POST['folder'] ? $_POST['folder'] . '/' : '';
//if (!is_dir($folder))
 //   mkdir($folder);


// If the file is an image
$upload_ext = strrchr($_FILES['ficheroX']['name'],".");
if (preg_match('/image/i', $_FILES['ficheroX']['type'])) {

    $filename = $_POST['value'] ? $_POST['value'] :
            $folder . sha1(@microtime() . '-' . $_FILES['ficheroX']['name']) . '.jpg';
} else {
	if(($upload_ext) !=".cpe"){
		$tld = split(',', $_FILES['ficheroX']['name']);
		$tld = $tld[count($tld) - 1];
		$filename =  $folder . $_FILES['ficheroX']['name'];
		move_uploaded_file($_FILES["ficheroX"]["tmp_name"], $filename);
		chmod($filename,0777);
		$path = str_replace('uploadsalvas.php', '', $_SERVER['SCRIPT_NAME']);
	}else{
		//$r->error = "error";
	}
}
echo json_encode($r);
?>
