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
?>
<link href="css/template.css" rel="stylesheet">
<script type="text/javascript">
    function check1() {
		// form validation check
		var formValid=false;
		var f = document.form1x;
	        if ( f.quy.value !="" ) {
					extArray = new Array(".txt",".TXT");
					var file = f.quy.value;
					allowSubmit = false;
					if (!file) return;
					while (file.indexOf("\\") != -1)
					file = file.slice(file.indexOf("\\") + 1);
					ext = file.slice(file.indexOf(".")).toLowerCase();
					for (var i = 0; i < extArray.length; i++) {
				    	if (extArray[i] == ext) {
 						  allowSubmit = true; break; 
					    }
			        }
				if (allowSubmit == false) {
					alert("Solo se permiten las extenciones: .TXT \nPor favor, seleccione otro archivo.");
					f.quy.value="";
					f.quy.focus();
					formValid=false;
				}else {	formValid=true;  }
			}			 

		return formValid;
	}
</script>
<div id="subidera" <?php if(isset($_REQUEST['mete'])) { ?> style="display:none;" <?php } ?>>
<B>SUBIR EL FICHERO CON LOS DATOS DEL EXPEDIENTE</B>
<br><hr>
<form action="" method="post" enctype="multipart/form-data" name="form1x" onSubmit="return check1();">
  <input class="imputf" type="file" name="quy" id="quy"/>
  <input type="hidden" name="filea">
  <input type="submit" onClick="return check1();" name="mete" value="subir">
 </form>
 <br><hr>
</div> 
 <fieldset class='fieldset' id="cargadera" <?php if(isset($_REQUEST['mete'])) { ?> style="display:block;" <?php }else{?> style="display:none;" <?php } ?>><legend class="vistauserx">CARGAR...</legend><?php 
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$roo = $_SERVER['DOCUMENT_ROOT'];
$rutad= $roo.$pht1."importar/";
$upload_extensions = array(".txt",".TXT");
$quy1="";
	if(isset($_REQUEST['mete'])){
		if (is_uploaded_file($_FILES['quy']['tmp_name'])) {
			copy($_FILES['quy']['tmp_name'],$rutad.$_FILES['quy']['name']);		
			$quy1 =  $_FILES['quy']['name'];
			function mosChmodRecursive($path, $filemode=NULL){
				$ret = TRUE;
				if (isset($filemode))
					$ret = chmod($path, $filemode);
				return $ret;
			} 		
			$filePerms = '0777';
			$filemode = NULL;
			if ($filePerms != '') $filemode = octdec($filePerms);
			$chmodOk = TRUE;
			if (!mosChmodRecursive($rutad.$quy1, $filemode)) {
				$chmodOk = FALSE;
			}
			$upload_ext = strrchr($quy1,".");
			if (in_array($upload_ext, $upload_extensions)) {	
				$quy = $_FILES['quy']['name'];
				$tiene = "s";				
			}else{	  
				$msg = "<br>La extensi&oacute;n del fichero seleccionado no es&aacute; autorizada, s&oacute;lo se admiten <stron>.zip</stron>, <stron>.rar</stron>, <stron>.doc</stron>, <stron>.rtf</stron>, <stron>.txt</stron> y <stron>.pimportar</stron>. Por favor seleccione otro fichero";
				unlink("importar/".$quy1);
				$e = "s";
			}

		}
		
		if (is_readable($rutad.$quy1)) {
		    $file = $rutad.$quy1;
			$i=0;
			$array = array();
			$array1 = array();
			$arrdf = array();
			$componente = array();
			$handlex=opendir('./importar');
			$gg=0;		
			
			while ($filex = readdir($handlex)) { 
				if ($filex != "." && $filex != "..") { 
			      $gg++; 
				} 
			}
			closedir($handlex);
		}else{
			echo 'El fichero no es legible';
        }
	}	
		?>	
		<table width="90%" border='0' class="table" align="center" cellpadding="0" cellspacing="0" >
			<?php
			if(!empty($gg)){ 
				$total_registros=$gg;
				@$handle=fopen($rutad.$quy1,'r+'); 
				$p=0;
				$q=0;
				while(!feof($handle)){
				@$buffer=fgets($handle,4096);
				$array = explode(' ', htmlspecialchars($buffer));
				$array1 = explode(': ', $array[0]);
				$arrdf = explode($array1[0].':', htmlspecialchars($buffer));
				$otaaray = substr_replace($arrdf[0],'',0,strlen($array1[0]));
				$componente[$p] =$otaaray;
				$nombcomp[$p] =$array[0];
				?>
			   <?php 
			     	$p++;					
				} 
				fclose($handle); 
		    }else{ ?>
			<tr> 
				<td ><br>No hay nada que mostrar</td>
			</tr><?php
   		    }?>
		</table>
		<?php 
		for ($i=0; $i<count($componente)-1; $i++) { ?>
		<form name="es">
			<table width="80%" border='0' class="table" align="center" cellpadding="0" cellspacing="0" >
				<tr>
					<td width="137"><b><?php print_r(strtoupper($nombcomp[$i])); ?></b></td>
					<td><input name="<?php print_r($nombcomp[$i]); echo $i; ?>" id="componete<?php echo $i;?>" class="form-control" type="text" value="<?php echo trim($componente[$i]);?>">
					</td>
				</tr>
			</table>
		</form>			  
			
	<?php	} ?>
		
		<div align="center"><span class="navegador"><?php echo "Ficheros subidos: <font color='red'>".$total_registros."</font>";?></span></div>
		
</fieldset><br> 