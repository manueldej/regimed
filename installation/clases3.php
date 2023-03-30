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
		$a = str_replace('�','&aacute;',  $tra);
		$e = str_replace('�','&eacute;',  $a);
		$i = str_replace('�','&iacute;',  $e);
		$o = str_replace('�','&oacute;',  $i);
		$u = str_replace('�','&uacute;',  $o);
		$n = str_replace('�','&ntilde;',  $u);
		$A = str_replace('�','&Aacute;',  $n);
		$E = str_replace('�','&Eacute;',  $A);
		$I = str_replace('�','&Iacute;',  $E);
		$O = str_replace('�','&Oacute;',  $I);
		$U = str_replace('�','&Uacute;',  $O);
		$N = str_replace('�','&Ntilde;',  $U);
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