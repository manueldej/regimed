<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    01/06/2016 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada (IN MEMORIAM)							         		            #
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
	public function comprim($nomby1,$qc){
	
		$fichero=$nomby1.$qc; //"install.sql"
		$sip=$nomby1.".zip";  //"install.zip"
		$zip = new ZipArchive;
		
		if ($zip->open($sip, ZIPARCHIVE::CREATE) === TRUE) {
			  $zip->addFile($fichero);
			  $zip->close();	
			}else {
				exit ( "No se puede LEER el archivo zip.\n" );
				exit();
			}
		return true;

	}
}


?>