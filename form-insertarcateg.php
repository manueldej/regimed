<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                    #
# Version:  3.1.1                                                    		                            #
# Fecha:    24/03/2011 - 01/01/2023                                             	                    #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   							    #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)						    #
# Licencia: Freeware                                                				            #
#                                                                       			            #
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
<?php
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
 require_once('connections/miConex.php'); 
 $msg = "";
  if($_GET["e"]) {
   $msg = "Por favor escoja otro nombre, la Categor&iacute;a ".$_GET["e"]." ya existe";
 }
 ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript" >
// Check for a blank field
function submit_page() {
	// form validation check
	var formValid=false;
	var f = document.form1;
	if ( f.t2.value == '' ) {
		alert('Por favor, debe escribir el nombre de la nueva Categoria');
		f.t2.focus();
		formValid=false;
	} else if ( confirm('Es correcto en nombre de la Categoria?')) 
	  {	formValid=true;  }

	return formValid;
}
function retornar(form){
	document.form1.action="categ_medios.php";
}

//------------------------- funciones -------------------------------------------//
function isFieldBlank(theField){
	innStr = theField.value;
	innLen = innStr.length;
	
	if(theField.value == "" && innLen==0)
		return true;
	else
		return false;
}

function ctype_digit(theField){
	val = theField.value;
	Len = val.length;
 
	for(var i=0; i<Len; i++)  {
		var ch = val.substring(i,i+1)
		if(ch < "0" || "16"< ch)
			return true;
	}
}
//esta funcion comprobará que el No de carnet no tenga menos de 11 caracteres
function ci(theField)  {
	val = theField.value;
	Len = val.length;
	for(var i=0; i<Len; i++)
		var chh = val.substring(i,i+1)
	if(i < "16")
		return true;
}
//-----------------------  formulario  ----------------------------------//
</script>
<style type="text/css">
<!--
.Estilo2 {
	color: #0099CC;
	font-weight: bold;
}
.Estilo3 {color: #009999}
.Estilo4 {color: #336666; font-weight: bold; }

div.message {
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size : 14px;
	color : #c30;
	text-align: center;
	width: auto;
	background-color: #f9f9f9;
	border: solid 1px #d5d5d5;
	margin: 3px 0px 10px;
	padding: 3px 20px;
}
-->
</style>
<link href="css/template.css" rel="stylesheet" type="text/css">
<fieldset class="fieldset">
<table width="478" border=0 align="center" bgcolor='#FFFFFF' table >
<tr><td width="472" class="Estilo3"><?php echo $msg;?></td></tr>
    <tr>
      <td ><table width="473" border="0" align="left" bgcolor="#FFFFFF">
        <form name="form1" method="post" action="insertacateg.php" onsubmit="return submit_page();">          
          <tr>
            
          <td colspan="4"></td>
          </tr>
          <tr>
            <td><div align="right" class="contentheading">NOMBRE</div></td>
            <td colspan="2"><input name="t2" type="text" id="t22" size="35" maxlength="100"></td>
          </tr>
          <td width="74" align="right"><input type="submit" name="insertar" value="Guardar"></td>
		    <td width="389" align="left"><input type="submit" name="Submit2" value="VolVer" onClick="retornar(this.form)"></td>
          </tr>	 
        </form>	
      </table></td>
    </tr>
</table>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
