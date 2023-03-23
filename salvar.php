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

	function salvar($i,$tbl,$adtabla,$sip){
			include('connections/miConex.php');
	
			if(($i) =="es"){
				include('esp.php');
			}else{ 
				include('eng.php');
			}
			$tiem = time();
			$seldg=mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysql_error());
			$rseldg = mysqli_fetch_array($seldg);
			
			$fecha= $adtabla."_".$rseldg['id_datos']."_".date("dmY");
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$posicion = strripos($roo, "/");
			$ruta = substr($roo, 0, $posicion)."/tmp/"; 

				if (file_exists($ruta."sql.sql")){
					@unlink($ruta."sql.sql");
					@unlink("salvas/sql.sql");
				}
						$arr_num=array("int", "real");
						$tiem = time();
						
						$total_tab=0;
						foreach($tbl AS $key=>$tabla){
							$total_tab++;	
						}
						if($total_tab < 50) { 
							$step=1;
						}else{ 
							$step =Round((100/$total_tab),2);
						}
						if((@$adtabla) =="esyda"){
							$export=1;$paso=$step;
						} 
						if((@$adtabla) =="estrut"){
							$export=2;$paso=$step*2;
						} 
						if((@$adtabla) =="dats"){
							$export=3;$paso=$step*2;
						}

						$fp = fopen($ruta."/sql.sql", "w");
						require ('clases3.php');
						$prog = new expcons();
						$prog->reset(1);

						if (($export==1)){
							//bloque de estructuras
							@$pasado=0;
							$todo="-- Datos generados con Regimed 3.0\r\n-- Fecha: ".date('d-m-Y')."\r\n\r\nUSE ".chr(96).$database_miConex.chr(96).";\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";

							foreach($tbl AS $key=>$tabla)	{
								$prog->barra_prog ( $exptr1." ".$estructra3."s...");
								@$pasado=@$pasado+$paso;	
								$fi = "show create table ".$tabla;				
								$fiq = mysqli_query($miConex, $fi) or die(mysql_error()); 												
								$fiq = mysqli_fetch_array($fiq);
								$o = $fiq[1];
								$fiche2= $o;
								$head="\r\n\r\n-- ".$estructra3.$dela.$tablasa."-> `".$tabla."`\r\n--\r\n";
								$todo.=@$head;
								$drop="DROP TABLE IF EXISTS ".chr(96).$tabla.chr(96)."; ".chr(10).chr(13);;
								$todo.=$drop;
								$todo.=$fiche2.';';
								
								$ff = "SELECT * FROM ".$tabla;
								$result=@mysqli_query($miConex, $ff);// or die(mysql_error($miConex));
								$trows=@mysqli_num_rows($result);
								$fields = @mysqli_num_fields($result);
								$head="\r\n-- ".$exptr1.$dela.$tablasa."-> `".$tabla."`\r\n-- ".$totalrecord.": ".$trows."\r\n-- ----------------------------------- \r\n";
								$todo .=$head;
								$tt=$tabla;
								$i1=0;
								$dato1="";
								while ($i1 < $fields){
									$field1 = mysqli_fetch_field_direct ($result, $i1);
									$name1  = $field1->name;
									$dato1 .=$name1.",";
										$i1++;								
								}
								$linea="INSERT INTO ".chr(96).$tabla.chr(96). " (".substr($dato1,0,-1).")  VALUES \r\n";
								$num=1;
								if(($trows) !=0){
									$todo .=$linea;
								}
								while($row = @mysqli_fetch_object($result)){
									$i = 0;
									$prog->barra_prog ( $exptr1." ".$estructra3."s".$dela.$tablasa."-> <b><font color=red>".$tabla."</font></b>");
									@$pasado=@$pasado+$paso;	
									$datos="(";
									$datof= "";
									$dato ="";
									while ($i < $fields){
										$field = mysqli_fetch_field_direct ($result, $i);
										$flags = $field->flags;
										$name  = $field->name;
										$rempz = str_replace(chr(39),chr(39).chr(39),$row->$name);
										$dato=chr(39).$rempz.chr(39);		

										if(in_array($field->type,$arr_num)){										
											$dato=str_replace(chr(39),"",$dato);
										}
										if ($i < $fields-1) { $dato .=",";}
										$i++;								
										$datos .=$dato;
										$datof= "";
									}
									
									if(($trows) ==$num ){
										$data=$datos.');';
									}else{
										$data=$datos.'),';										
									}							

									$todo.=$data."\r\n";	
									@$num++;
									@$num1++;
									if (@$pasado < 48){
										@$pasado=48-@$pasado;
									}
								}
							}
							fwrite($fp, $todo);		
							fwrite($fp, "\r\n\r\nSET FOREIGN_KEY_CHECKS=1;\r\n");
							flock($fp, 3);
						}
						if (($export==2)){
							//bloque de estructuras
							@$pasado=0;
							$todo="-- Datos generados con Regimed 3.0\r\n-- Fecha: ".date('d-m-Y')."\r\n\r\nUSE ".chr(96).$database_miConex.chr(96).";\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";
							foreach($tbl AS $key=>$tabla)	{
									$prog->barra_prog ( $exptr1." ".$estructra3."s ...");
									@$pasado=@$pasado+$paso;	
									$fi = "show create table ".$tabla;							
									$fiq = mysqli_query($miConex, $fi) or die(mysql_error()); 
									$fiq = mysqli_fetch_row($fiq);
									$o = $fiq[1];
									$fiche2= $o;
								
									$head="\r\n\r\n-- ".$estructra3.$dela.$tablasa."-> `".$tabla."`\r\n--\r\n";
									$todo.=@$head;
									$drop="DROP TABLE IF EXISTS ".chr(96).$tabla.chr(96)."; ".chr(10).chr(13);;
									$todo.=$drop;
									$todo.=$fiche2.';';
							}
							fwrite($fp, $todo);		
							fwrite($fp, "\r\n\r\nSET FOREIGN_KEY_CHECKS=1;\r\n");
							flock($fp, 3);
							$export=$export+2;
							if (@$pasado < 48){
								@$pasado=48-@$pasado;
							}
							$prog->barra_prog ( $exptr1." ".$estructra3."s ...");					
						}
						
						if($export==3){
							$todo="-- Datos generados con Regimed 3.0\r\n-- Fecha: ".date('d-m-Y')."\r\n\r\nUSE ".chr(96).$database_miConex.chr(96).";\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";
							$pasado = 0;
							foreach($tbl AS $key=>$tabla)	{
								$prog->barra_prog ( $exptr1." ".$estructra3."s ...");
								@$pasado=@$pasado+$paso;													
								$ff = "SELECT * FROM ".$tabla;
								$result=@mysqli_query($miConex, $ff);// or die(mysql_error($miConex));
								$trows=@mysqli_num_rows($result);
								$fields = @mysqli_num_fields($result);
								$head="\r\n-- ".$exptr1.$dela.$tablasa."-> `".$tabla."`\r\n-- ".$totalrecord.": ".$trows."\r\n-- ----------------------------------- \r\n";
								$todo .=$head;
								$tt=$tabla;
								$i1=0;
								$dato1="";
								while ($i1 < $fields){
									$field1 = mysqli_fetch_field_direct($result, $i1);
									$name1  = $field1->name;
									$dato1 .=$name1.",";
										$i1++;								
								}
								$linea="INSERT INTO ".chr(96).$tabla.chr(96). " (".substr($dato1,0,-1).")  VALUES \r\n";
								$num=1;
								if(($trows) !=0){
									$todo .=$linea;
								}							
								while($row = @mysqli_fetch_object($result)){
									$i = 0;
									$datos="(";
									$datof= "";
									$dato ="";
									while ($i < $fields){
										$field = mysqli_fetch_field_direct ($result, $i);
										$name  = $field->name;
										$rempz = str_replace(chr(39),chr(39).chr(39),$row->$name);
										$dato=chr(39).$rempz.chr(39);		

										if(in_array($field->type,$arr_num)){										
											$dato=str_replace(chr(39),"",$dato);
										}
										if ($i < $fields-1) { $dato .=",";}
										$i++;								
										$datos .=$dato;
										$datof= "";
									}
									
									if(($trows) ==$num ){
										$data=$datos.');';
									}else{
										$data=$datos.'),';										
									}							

									$todo.=$data."\r\n";	
									@$num++;
									@$num1++;
									if (@$pasado < 48){
										@$pasado=48-@$pasado;
									}
									$prog->barra_prog ( $exptr1." ".$estructra3."s ...");							
								}

							}
							fwrite($fp, $todo);
							fwrite($fp, "\r\n\r\nSET FOREIGN_KEY_CHECKS=1;\r\n");
							flock($fp, 3);
						}	
						fclose($fp);
						$prog->barra_prog ( $copiando.$ficher."s...");
						@copy($ruta."sql.sql","salvas/".$fecha.".sql");
						$prog->barra_prog ( $exptr2." ".$ficher." .sql");
						$prog->comprim("salvas/".$fecha,$fecha,".sql");	
						$prog->barra_prog ( $exptr3."sql");
						$prog->barra_prog ( $exptr3);
						$prog->elimina($ruta."sql.sql");
						$prog->elimina("salvas/".$fecha.".sql");
						$Tim = (time()-$tiem);
						if(($Tim) < 1 ){
							$Tim = 1; 
							$prog->barra_prog ( $strproceso2."<b><font color=red>".$Tim."</font></b>".$strproceso3);
						}elseif(($Tim) < 60){					
							$prog->barra_prog ( $strproceso2."<b><font color=red>".$Tim."</font></b>".$strproceso3);
						}elseif(($Tim) >= 60){
							$Tim =($Tim/60);
							$prog->barra_prog ( $strproceso2."<b><font color=red>".round($Tim)."</font></b>".$strproceso4);
						}
						$prog->reset ( 1000 );
	}

?>