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
class importar{
		private $prog_total=1;
		private $prog_actual;
		
		//FUNCION PARA IMPORTAR ESTRUCTURA Y DATOS
		private function esydat($conn,$fichero,$DBname){			
			require('../esp.php');
			function pica_sql($sql) {
				$sql = trim($sql);
				$sql = @ereg_replace("\n#[^\n]*\n", "\n", $sql);

				$buffer = array();
				$ret = array();
				$in_string = false;

				for($i=0; $i<strlen($sql)-1; $i++) {
					if($sql[$i] == ";" && !$in_string) {
						$ret[] = substr($sql, 0, $i);
						$sql = substr($sql, $i + 1);
						$i = 0;
					}

					if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
						$in_string = false;
					}
					elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
						$in_string = $sql[$i];
					}
					if(isset($buffer[1])) {
						$buffer[0] = $buffer[1];
					}
					$buffer[1] = $sql[$i];
				}

				if(!empty($sql)) {
					$ret[] = $sql;
				}
				return($ret);
			}
			
			$sqlfile=$fichero;	
			$ruta= sys_get_temp_dir().'/';
				$mqr = @get_magic_quotes_runtime();
				@set_magic_quotes_runtime(0);
				$query = fread( fopen( $sqlfile, 'r' ), filesize( $sqlfile ) );
				@set_magic_quotes_runtime($mqr);
				$pieces  = pica_sql($query);
				
				for ($i=0; $i<count($pieces); $i++) {
							$pieces[$i] = trim($pieces[$i]);
							if(!empty($pieces[$i]) && $pieces[$i] != "#") {								
								mysqli_query($pieces[$i]);
								if (mysql_errno($conn) !="") {
									$errors[] = array(mysql_errno($conn)." -> ".str_ireplace("'","-",mysql_error($conn)));
									$merrors[]= array($pieces[$i]); ?>
									<fieldset class="fieldset"><legend class='vistauserx'><?php echo $strerror;?></legend>
										<table width="100%" border="0" cellspacing="10" cellpadding="0">
											<tr> 
												<td><?php echo $strerror2."<br>";
													$ll=0;
													foreach($errors as $error) {
														echo @$merrors[0][$ll];
															$muserr = str_ireplace("\'","'","Error: $error[0].");
															$ll++;
														}
														echo "<br><br>".$muserr;	?>
												</td>
											</tr>
										</table>
									</fieldset><?php 
									echo "<script>document.getElementById('tarea').innerHTML='".$proceso1."';</script>";
												
									@unlink("tmp.sql");
									@unlink($ruta.$fichero);
									@unlink($ruta."sql.zip");
									exit;
								}						
							}
						}				
			$this->elimina($fichero);
			$this->elimina($ruta.$fichero);
			$this->elimina($ruta.$fichero);
			return true;
		}

	//FUNCION PARA ELIMINAR TEMPORALES
		private function elimina($que_borro){
			require('../esp.php');
			
			$ruta= sys_get_temp_dir().'/';		
			@unlink($que_borro);
		}

		//FUNCION PARA LLAMAR AL IMPORTADOR
		function importar($conn,$fichero,$DBname) {
			require('../esp.php');
			$this->esydat($conn,$fichero,$DBname); 			
		}
	}
?>