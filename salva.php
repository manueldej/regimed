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
include('header.php');
include ('script.php');
$k=0;

//$result = array_column(mysqli_fetch_all("SHOW TABLES FROM ".$database_miConex),0);

function get_tables($miConex,$database_miConex, $u)
{
  $result = array();
  $res = mysqli_query($miConex, "SHOW TABLES FROM ".$database_miConex);
  while($cRow = mysqli_fetch_array($res))
  {
    $result[] = $cRow[0];
  }
   return $result[$u];
}

  $sql_cant_tablas = mysqli_query($miConex, "SHOW TABLES FROM ".$database_miConex);
  $cant_tablas = mysqli_num_rows ($sql_cant_tablas); 

$i = 0;
?>
<link href="css/template.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo3 {
	font-size: 12px;
	color: #846131;
	font-weight: bold;
	font-style: italic;
}
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}
-->
</style>
<div id="cira"> </div>
<script type="text/javascript">
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
function doSubmit(){	
	var cuta=0;
	for (i=0; i<document.busca.elements['tbl[]'].length; i++)			{				
		document.busca.elements['tbl[]'].options[i].selected = true;
		if((document.busca.elements['tbl[]'].options[i].value) !=""){
			cuta = cuta + 1;
		}
	}
	if((cuta) !=0){
		submit();
	}else{
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $selectscript1;?>.</b></div></div>';
		return false;
	}
}
</script>
<?php include('barra.php');?>
<div id="buscad"> 
<fieldset class="fieldset"><legend class='vistauserx'><?php echo $impo_exp2;?></legend>
<div <?php if(isset($_POST['exportat'])){ echo 'style="display:none"';}?>>
<form name="busca" method="post" action="salva1.php" onsubmit=" return doSubmit();">
  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="sgf1">
    <tr>
        <td>
			<fieldset class="fieldset"><legend class="vistauserx"><?php echo $seleccione." ".$selectDB4;?></legend><br>
				<table width="5%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td width="15%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
						<select name="slAF" size="6" multiple id="slAF" onclick='javascript:mE(document.busca.slAF,document.busca.elements["tbl[]"],0);'>
						  <?php 
							while (@$k < $cant_tablas) {
							$tb_names[$k] = get_tables($miConex,$database_miConex, $k);  
						
							 ?>
							    <option value="<?php echo $tb_names[$k]; ?>" onMouseOVer="this.style.cursor='pointer';"><?php echo $tb_names[$k];  ?></option>
							   <?php $k++;
							}?>
		
						</select>
						</font></td>
					  <td width="5%"><table width="35" border="0" cellspacing="3" cellpadding="3">
						  <tr><td><a href="javascript:mE(document.busca.slAF,document.busca.elements['tbl[]'],1);"><img src="images/b_lastpage.png" title="Seleccionar Todos..." width="16" height="16" border="0"></a></td>
						  </tr>
						  <tr><td><a href="javascript:mE(document.busca.elements['tbl[]'],document.busca.slAF,1);"><img src="images/b_firstpage.png" title="Quitar todos de la selecci&oacute;n..." width="16" height="16" border="0"></a></td>
						  </tr>
						</table></td>
					  <td width="80%"><select name="tbl[]" size="6" multiple onclick="javascript:mE(document.busca.elements['tbl[]'],document.busca.slAF,0);">
						</select></td>
					</tr>
				</table>
			</fieldset><br>
			<fieldset class="fieldset"> <legend class="vistauserx"><?php echo $optiones;?></legend>
				  <div><label class="Estilo3">    
					<input name="adtabla" type="radio" class="boton" value="esyda" checked>
					<?php echo $estructra3." ".$estructra4." ".$estructra2; ?></label>
					&nbsp;&nbsp; 
					<label class="Estilo3"> 
					<input name="adtabla" type="radio" class="boton" value="estrut">
					<?php echo $estructra3; ?></label>
					&nbsp;&nbsp; 
					<label class="Estilo3"> 
					<input name="adtabla" type="radio" class="boton" value="dats">
				   <?php echo $estructra2; ?></label>
				  </div>
				  <div>
					<input name="sip" type="hidden" id="sip" value="s"><br>
					<input type="submit" class="btn" name="exportat" value="<?php echo $btExportar;?>" />
				  </div>
			</fieldset>
        </td>
    </tr>
  </table>
</form>
</div>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>