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
class expcons{
	
	private $prog_total=1;
	private $prog_actual;
	
	//FUNCION PARA RESETAEAR EL CONTADOR
	public function reset($n) {
		$this->prog_total = $n;
		$this->prog_actual = 0;
	}
	//FUNCION PARA MOSRAR LA BARRA DE PROGRESO 1
	public function barra_prog($m) {
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		echo "<script> ap1('".$m."');\n</script>";
		flush ();
	}
	//FUNCION PARA MOSRAR LA BARRA DE PROGRESO 2
	public function barra_progg1($n) {
		echo "<script>apg1('$n);\n</script>";
		flush ();
	}

	//FUNCION PARA ELIMINAR TEMPORALES
	public function elimina($que_borro){
		@unlink($que_borro);		
	}
//REEMPLAZAR CARACTER
	public function html_ent($tra){
		$a = str_replace('á','&aacute;',  $tra);
		$e = str_replace('é','&eacute;',  $a);
		$i = str_replace('í','&iacute;',  $e);
		$o = str_replace('ó','&oacute;',  $i);
		$u = str_replace('ú','&uacute;',  $o);
		$n = str_replace('ñ','&ntilde;',  $u);
		$A = str_replace('Á','&Aacute;',  $n);
		$E = str_replace('É','&Eacute;',  $A);
		$I = str_replace('Í','&Iacute;',  $E);
		$O = str_replace('Ó','&Oacute;',  $I);
		$U = str_replace('Ú','&Uacute;',  $O);
		$N = str_replace('Ñ','&Ntilde;',  $U);
		return $N;		
	}

	//FUNCION PARA COMPRIMIR
	public function comprim($todoy1,$nomby1,$qc){
		$ruta=$todoy1.$qc;    //"salvas/sql",".sql"
		$fichero=$nomby1.$qc; //"sql",".sql"
        $sip=$todoy1.".zip";  //"salvas/sql" .zip
		$zip = new ZipArchive;
       
		if ($zip->open($sip, ZIPARCHIVE::CREATE )!== TRUE) {
			exit ( "No se puede crear el archivo .zip\n" );
		}else {
		$zip->addFile($ruta,$fichero);
		$zip->close();
			echo "<script>des1('".$todoy1.".zip','".$nomby1.".zip');\n</script>";
		}		
		return true;
	}
}
?>