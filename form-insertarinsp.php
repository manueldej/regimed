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
include('header.php'); 
include('script.php');
if (isset($_GET['u'])){
	$query_areas = "SELECT * FROM areas where idunidades='".$_GET['u']."'";
}else{
	$query_areas = "SELECT * FROM areas where idunidades='1'";
}

$query_RecUni ="SELECT * FROM datos_generales";
$RecUni = mysqli_query($miConex, $query_RecUni) or die(mysql_error());
$AreaT = mysqli_query($miConex, $query_areas) or die(mysql_error());
 
$nuRecUni = mysqli_num_rows($RecUni);
$roo = $_SERVER['DOCUMENT_ROOT'];
$posicion = strripos($roo, "/");
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$ruta1 = $roo .$pht1."inspecciones/";
$ruta = substr($roo, 0, $posicion)."/tmp/"; 

function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL){
	$ret = TRUE;
	if (isset($filemode))
		$ret = @chmod($path, $filemode);
	return $ret;
}
	if(isset($_POST['inserta'])){	
		$fecha = @$_POST['fecha'];
		$estado = @$_POST['estado'];
		$obser = @$_POST['observ'];	
		$undd = $_POST['unidades'];	
		$areasz = $_POST['tb'];
		$origen = $_POST['origen'];
		$aras = "";
		foreach($areasz as $key){
			$aras .=$key.", ";
		}
		if(is_uploaded_file($_FILES['observ']['tmp_name'])){
			$get_ext = $_FILES['observ']['name']; 
			$ext = strrchr($get_ext,".");
			copy($_FILES['observ']['tmp_name'],$ruta.$_FILES['observ']['name']);
		}
		$in = "insert into inspecciones values(NULL,'".$fecha."','".htmlentities($estado)."','".$obser."','".$origen."','".htmlentities(substr($aras,0,-2))."','".$undd."')";
		$qin = mysqli_query($miConex, $in) or die(mysql_error());
		$nunomr= mysqli_insert_id($miConex);
		rename($ruta.$_FILES['observ']['name'],$ruta.$nunomr."_".$undd.$ext);
		copy($ruta.$nunomr."_".$undd.$ext,$ruta1.$nunomr."_".$undd.$ext);
		@unlink($ruta.$nunomr."_".$undd.$ext);			
		$in1 = "update inspecciones set observ = '".$nunomr."_".$undd.$ext."' where id='".$nunomr."'";
		$qin1 = mysqli_query($miConex, $in1) or die(mysql_error());		
		$chmod_report = "Los permisos del directorio y de los archivos no han sido cambiados.";
		$file=$ruta1.$nunomr."_".$undd.$get_ext;
		$filemode = 0777;
		$dirmode =0777;
		$chmodOk = TRUE;
		if (!mosChmodRecursive($file, 0777, 0777)) {
			$chmodOk = FALSE;
		}
		if ($chmodOk) {
			//echo 'Permisos del directorio y de los archivos cambiados.';
		} else {
			//echo 'Los permisos del directorio y de los archivos no han podido ser cambiados.<br />Cambia los permisos de los archivos y directorios manualmente.';
		}
		?><script type="text/javascript">document.location="insp.php";</script><?php
	}

 ?>
<script language="JavaScript" >
							extArray = new Array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".pps", ".ppt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT", ".PPS", ".PPT",'.rtf','.RTF','.docx','.DOCX');
							function LimitAttach(file) {
								allowSubmit = false;
								if (!file) return;
								while (file.indexOf("\\") != -1)
								file = file.slice(file.indexOf("\\") + 1);
								ext = file.slice(file.indexOf(".")).toLowerCase();
								for (var i = 0; i < extArray.length; i++) {
									if (extArray[i] == ext) { allowSubmit = true; break; }
								}
								if (allowSubmit) {
									 document.form1.quy.value =file;
								}else{
									alert("Solo se permiten las extenciones: txt, zip, rar, pdf, doc, rtf, odt, pps y ppt.\nPor favor, seleccione otro archivo.");
								}
							}
// Check for a blank field
function cheqe() {
	// form validation check
	var formValid=false;
	var f = document.form1;
	var cuta=0;
	for (i=0; i<document.form1.elements['tb[]'].length; i++){				
		document.form1.elements['tb[]'].options[i].selected = true;
		if((document.form1.elements['tb[]'].options[i].value) !=""){
			cuta = cuta + 1;
		}
	}
	if((cuta) ==0){
		alert('Por favor, debe selecccionar el Area');
		f.slAF.focus();
		formValid=false;
	}else 	if ( f.fecha.value == '' ) {
		alert('Por favor, debe escribir la Fecha');
		f.fecha.focus();
		formValid=false;
	} else	if ( f.estado.value == '' ) {
		alert('Por favor, debe escribir el Estado');
		f.estado.focus();
		formValid=false;
	} else	if ( f.observ.value == '' ) {
		alert('Por favor, debe seleccionar el resultado de la Inspeccion');
		f.observ.focus();
		formValid=false;
	} else	if ( f.observ.value != '' ) {
		//	MostrarEstadoDeArchivo('/var/www/regimed/inspeccio/'+f.observ.value);
				LimitAttach(f.observ.value);
				f.observ.value="";
				f.observ.focus();
				formValid=false;
	} else  {
		formValid=true;
	}
	return formValid;
}
function mE(s,t,op){
	for (i=0; i<s.length; i++)	{
		if (op == 0)		{
			if (s.options[i].selected)			{
				newOptionName = new Option(s.options[i].text, s.options[i].value, false, false);
				t.options[t.length] = newOptionName;
				s.options[i] = null;
				i--;
			}
		}
		else		{
			newOptionName = new Option(s.options[i].text, s.options[i].value, false, false);
			t.options[t.length] = newOptionName;
			s.options[i] = null;			
			i--;
		}
	}	
}

function cambiaU(uni){
	document.location="?u="+uni;
}
</script>
<?php include('barra.php'); ?>
<div id="buscad"> 
<fieldset class="fieldset"><legend class="vistauserx">REGISTRAR INSPECCIONES</legend>
        <form name="form1" method="post" action="" onsubmit="return cheqe();" enctype="multipart/form-data">          
		<table width="60%" border="0" align="center">
			<tr>      
				<td colspan="2"></td>
			</tr>
			<tr>
				<td width="74"><div align="right" class="contentheading"><?php if(($nuRecUni) >1){ echo $btdatosentidad2;}else{ echo $btdatosentidad3;}?></div></td>
				<td>
					<select name="unidades" class="selectuno" id="unidades" onChange="cambiaU(this.value);"><?php
						while ($row_Uni = mysqli_fetch_array($RecUni)){ ?>
							<option value="<?php echo $row_Uni['id_datos'];?>" <?php if (isset($_GET['u'])){ if(($row_Uni['id_datos']) ==$_GET['u']){ echo "selected";} } ?>><?php echo $row_Uni['entidad'];?></option><?php
						} ?>
					</select>
				</td>
			</tr>
			<tr>
            <td><div align="right" class="contentheading">Fecha</div></td>
            <td colspan="2"><input onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.fecha);return false;" name="fecha" type="text" class="imput" readonly id="fecha" onKeyPress="return acceptNum1(event);" size="10" maxlength="10">
            <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.fecha);return false;" hidefocus><img name="popcal" align="absmiddle" src="images/almana.png" width="25" height="22" border="0" title="" /></a></td>
          </tr>
          <tr>
            <td><div align="right" class="contentheading">Estado</div></td>
            <td colspan="2"><select name="estado" size="1" class="selectuno" id="estado">
              <option value="MV" selected="selected">Muy Vulnerable</option>
              <option value="V">Vulnerable</option>
              <option value="NVCS">No Vulnerable C/Se&ntilde;alamientos</option>
              <option value="NV">No Vulnerable</option>
            </select></td>
          </tr>
		  <tr>
            <td><div align="right" class="contentheading">Origen</div></td>
            <td colspan="2"><select name="origen" size="1" class="selectuno" id="origen">
              <option value="Externa" title="Inspecciones hechas por otra Entidad">Origen Externa </option>
              <option value="Interna" title="Inspecciones hechas por la Entidad">Origen Interna</option>
            </select></td>
          </tr>
		    <tr>
            <td valign="top"><div align="right" class="contentheading">Resultados</div></td>
            <td colspan="2"><input name="observ" id="observ" class="imputf" type="file"></td>
          </tr>
		  <tr>
            <td><div align="right" class="contentheading">&Aacute;reas</div></td>
            <td colspan="2">
				<table width="1%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
						<td width="15%">
							<select name="slAF" class="selectuno" size="auto" multiple id="slAF" onclick='javascript:mE(document.form1.slAF,document.form1.elements["tb[]"],0);'><?php 
								while ($row_area = mysqli_fetch_array($AreaT)){
									if(($row_area['nombre']) !="Reparaciones"){ ?>
										<option value="<?php echo $row_area['nombre'];?>"><?php echo $row_area['nombre'];?></option><?php
									}
								}		?>
							</select>
						</td>
						<td width="5%">
							<table width="35" border="0" cellspacing="3" cellpadding="3">
								<tr><td><a href="javascript:mE(document.form1.slAF,document.form1.elements['tb[]'],1);"><img src="images/b_lastpage.png" title="Seleccionar Todos..." width="16" height="16" border="0"></a></td></tr>
								<tr><td><a href="javascript:mE(document.form1.elements['tb[]'],document.form1.slAF,1);"><img src="images/b_firstpage.png" title="Quitar todos de la selecci&oacute;n..." width="16" height="16" border="0"></a></td></tr>
							</table>
						</td>
						<td width="80%"><select class="selectuno" name="tb[]" id="tb" size="auto" multiple onclick="javascript:mE(document.form1.elements['tb[]'],document.form1.slAF,0);"></select></td>
					</tr>
				</table>
			</td>
          </tr>
		  <tr>
            <td colspan="2" align="right"><hr /></td>
          </tr>	 
		  <tr>
          <td width="74" align="right"><input name="inserta" type="submit" class="btn" value="Guardar"></td>
		    <td width="389" align="left"><input name="cancel" type="button" class="btn" onClick="javascript:document.location='expedientes.php';" value="Cancelar"></td>
          </tr>
      </table>       
	 </form>	
</div>
<br>
<?php include ("version.php");?>
</fieldset>
<iframe width=174 height=189 name="gToday:normal2:js/agenda2.js" id="gToday:normal2:js/agenda2.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
