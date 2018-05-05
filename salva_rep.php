<?php
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Inform�ticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################

	class expcons{
		//FUNCION PARA ELIMINAR TEMPORALES
		public function elimina($que_borro){
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$posicion = strripos($roo, "/");
			$ruta = substr($roo, 0, $posicion)."/tmp/"; 
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
		public function comprim($todoy1,$nomby1,$qc){
			$ruta=$todoy1.$qc;
			$fichero=$nomby1.$qc;
			$sip=$todoy1.".zip"; 
			$zip = new ZipArchive;
			if ($zip->open ( $sip, ZIPARCHIVE::CREATE ) !== TRUE) {
					exit ( "No se puede crear el archivo zip.\n" );
				} else {
			$zip->addFile($ruta,$fichero);
			$zip->close();
			}
			return true;
		}
	}
	function creasalva($tabla){	
		include('connections/miConex.php');
			$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{include('eng.php');}
		$bd=$database_miConex;

		$fecha= $tabla."_".date("mY");

		$roo = $_SERVER['DOCUMENT_ROOT'];
		$posicion = strripos($roo, "/");
		$ruta = substr($roo, 0, $posicion)."/tmp/"; 

		@unlink($ruta.$fecha.".sql");
		@unlink("reparaciones/".$fecha.".sql");

		$arr_num=array("int", "real");


		$fp = fopen($ruta.$fecha.".sql", "w");

		$prog = new expcons();
			//bloque de estructuras
			$todo="";

				$fi = "show create table ".$tabla;							
				$fiq = mysqli_query($miConex, $fi) or die(mysql_error()); 
				$fif = mysqli_fetch_row($fiq);
				$nfr = mysqli_num_rows($fiq);
				$o = $fif[1];
				$fiche2= $o;
			
				$head="-- Bsa de Datos: ".$bd.".\r\n-- Estructura de la Tabla-> `".$tabla."`\r\n--\r\n";
				$todo.=$head;
				$todo.="\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";
				$drop="DROP TABLE IF EXISTS `".$bd."`.".chr(96).$tabla.chr(96)."; ".chr(10).chr(13);;
				$todo.=$drop;
				$repl = str_ireplace("CREATE TABLE `","CREATE TABLE `".$bd."`.`",$fiche2);
				$todo.=$repl.';';

			fwrite($fp, $todo);		
			fwrite($fp, "\r\n");
			flock($fp, 3);
			@$export=$export+2;



			$todo="";
				$ff = "SELECT * FROM ".$tabla;
				$result=mysqli_query($miConex, $ff);// or die(mysql_error());
				$trows=mysqli_num_rows($result);
				$fields = mysqli_num_fields($result);
				$head="\r\n-- Datos de la Tabla-> `".$tabla."`\r\n-- ".$bttotalreg.": ".$trows."\r\n--\r\n";
				$todo .=$head;
				$tt=$tabla;
				$linea="INSERT INTO ".chr(96).$tabla.chr(96)." VALUES (";
				$num=1;
				while($row = mysqli_fetch_object($result)){
					$i = 0;
					$datos="";
					while ($i < $fields){
						$field  = mysqli_fetch_field_direct ($result, $i); 
						$flags = $field->flags;
						
						$name  = $field->name;
						if(strpos($flags,"auto_increment")>0) {
							$dato= $num;
						}else{
							$dato=$row->$name;
							if(in_array($field->type, $arr_num)){										
								if(($row->$name) ==""){ $dato="NULL";}										
							}
							if(!in_array($field->type, $arr_num)){										
								$pos=strpos($dato,chr(39));
								while(!$pos==false) {
									$dato=substr($dato,0,$pos).chr(39).substr($dato,$pos,strlen($dato));
									$pos=strpos($dato,chr(39),$pos+2);
								}										
								$dato=chr(39).$dato.chr(39);										
							}
						}
						if ($i < $fields-1) { $dato .=",";}
						$i++;								
						$datos .=$dato;
					}
					$num++;
					$data=$linea.$datos.');';
					$todo .=$data."\r\n";
				}				

			fwrite($fp, $todo);
			fwrite($fp, "\r\nSET FOREIGN_KEY_CHECKS=1;");
			flock($fp, 3);
		//}	
		fclose($fp);

		@copy($ruta.$fecha.".sql","reparaciones/".$fecha.".sql");

		$prog->comprim("reparaciones/".$fecha,$fecha,".sql");	
		$prog->elimina($ruta.$fecha.".sql");
		$prog->elimina("reparaciones/".$fecha.".sql");
	}
	function creasalva1($tabla){	
		include('connections/miConex.php');
			$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{include('eng.php');}
		$bd=$database_miConex;

		$fecha= $tabla."_".date("mY");

		$roo = $_SERVER['DOCUMENT_ROOT'];
		$posicion = strripos($roo, "/");
		$ruta = substr($roo, 0, $posicion)."/tmp/"; 

		@unlink($ruta.$fecha.".sql");
		@unlink("reparaciones/".$fecha.".sql");

		$arr_num=array("int", "real");


		$fp = fopen($ruta.$fecha.".sql", "w");

		$prog = new expcons();
			//bloque de estructuras
			$todo="";
				$ff = "SELECT * FROM ".$tabla;
				$result=mysqli_query($miConex, $ff);// or die(mysql_error());
				$trows=mysqli_num_rows($result);
				$fields = mysqli_num_fields($result);
				$head="\r\n-- Datos de la Tabla-> `".$tabla."`\r\n-- ".$bttotalreg.": ".$trows."\r\n--\r\nSET FOREIGN_KEY_CHECKS=0;\r\nTRUNCATE `".$tabla."`;\r\n\r\n";
				$todo .=$head;
				$tt=$tabla;
				
				$num=1;
				$linea="";
				while($row = mysqli_fetch_array($result)){
					$i = 0;
					$datos="";
					$linea .="INSERT INTO ".chr(96).$tabla.chr(96)." (inv,fecha,estado,idunidades) VALUES ('".$row['inv']."','".$row['fecha']."','".$row['estado']."','".$row['idunidades']."');\r\n";
				}				
					$todo .=$linea;
					$todo .="\r\nSET FOREIGN_KEY_CHECKS=1;";

			fwrite($fp, $todo);
			flock($fp, 3);
		//}	
		fclose($fp);

		@copy($ruta.$fecha.".sql","reparaciones/".$fecha.".sql");

		$prog->comprim("reparaciones/".$fecha,$fecha,".sql");	
		$prog->elimina($ruta.$fecha.".sql");
		$prog->elimina("reparaciones/".$fecha.".sql");
	}
?>