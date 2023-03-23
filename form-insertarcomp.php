<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					              		            #
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
@session_start();
require_once('connections/miConex.php');
		include('chequeo.php');
 	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
?>
<script language="JavaScript" >

// CHEQUEO QUE NINGUN CAMPO QUEDE EN BLANCO 

function submit_page(){
 foundError = false;
 var form=form1;
  if(isFieldBlank(form.t2)) {
  alert("El campo 'Inv' está en blanco.");
  form.t2.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t3)) {
  alert("El campo 'CPU' está en blanco.");
  form.t3.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t4)) {
  alert("El campo 'PLACA' está en blanco.");
  form.t4.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t5)) {
  alert("El campo 'CHIPSET' está en blanco.");
  form.t5.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t6)) {
  alert("El campo 'MEMORIA' está en blanco.");
  form.t6.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t8)) {
  alert("El campo 'GRAFICS' está en blanco.");
  form.t8.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t9)) {
  alert("El campo 'DRIVE-1' está en blanco.");
  form.t9.focus();
  foundError = true;
 }else
 if(isFieldBlank(form.t16)) {
  alert("El campo 'SO' está en blanco.");
  foundError = true;
 }else
   
 if(foundError == false ){
  return true; }
   return false;
}

function retornar(form){
 document.form1.action="registromedios1.php";
}

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
 
  for(var i=0; i<Len; i++)
  {
   var ch = val.substring(i,i+1)
   if(ch < "0" || "16"< ch)
     return true;
  }
}

</script>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
<div id="buscad">
	<table width="570" height="482" border="0" align="center" cellspacing="2" cellpadding="2">
        <form action="insertarcomp.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return submit_page();">          
          <tr>
            <td colspan="4"><div align="center"></div></td>
          </tr>
          <tr>
            <td width="60"><div align="center"><img src="images/idarea.png" width="50" height="30" /></div></td>
            <td width="161"><div align="right"><strong><?php echo $btdatosentidad3;?></strong></div></td>
            <td width="335" colspan="2"> <input onkeypress="return handleEnter(this, event)" name="bentidad" class="form-control" type="text" readonly id="t1" size="40" value="<?php echo strtoupper($rowx['entidad']); ?>">              </td>
          </tr>
          <tr>
            <td width="60"><div align="center"><img src="images/unidades.png" width="38" height="30" /></div></td>
            <td width="161"><div align="right"><strong><?php echo substr($btAreas,0,-1);?></strong></div></td>
            <td colspan="2"> <input onkeypress="return handleEnter(this, event)" name="id_area" id="id_area" class="form-control" type="text" readonly size="40" value="<?php echo $row['idarea']; ?>"></td>
          </tr>
          <tr>
            <td><div align="center"><img src="images/inv.png"  width="53" height="30"  /></div></td>
            <td><div align="right"><strong>Inv</strong></div></td>
            <td colspan="2"><label>
            <input onkeypress="return handleEnter(this, event)" name="inv" type="text" id="inv" class="form-control" readonly value="<?php echo $row['inv']; ?>">
            </label></td>
          </tr>
          
          <tr>
            <td><div align="center"><img src="images/cpu.png"  width="53" height="30"  /></div></td>
            <td><div align="right"><strong>CPU</strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="cpu" class="form-control" type="text" id="cpu" ></td>
          </tr>
          <tr>
            <td><div align="center"><img src="images/placa.png" alt="Board" width="54" height="37" /></div></td>
            <td><div align="right"><strong><?php echo $btPLACA;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="placa" type="text" id="placa" class="form-control"></td>
          </tr>
          <tr>
		  <td><div align="center"><img src="images/chipset.png" alt="Chipset" width="55" height="38" /></div></td>
            <td><div align="right"><strong>CHIPSET</strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="chiset" type="text" id="chiset" class="form-control"></td>
          </tr>
          <tr>
		  <td><div align="center"><img src="images/ram.png" alt="RAM" width="60" height="34" /></div></td>
            <td><div align="right"><strong><?php echo $Memorias1;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="mem" type="text" id="mem" class="form-control"><i id="masmem1" onclick="document.getElementById('menmem1').style.display='block'; masmemo(this.id,'divmem1','divmem2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divmem1" style="display:none;"><div align="right"><strong><?php echo $Memorias1;?></strong></div></div></td>
            <td colspan="2"><div id="divmem2" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="mem2" type="text" id="mem2" class="form-control"><i id="masmem2" onclick="document.getElementById('menmem2').style.display='block'; masmemo(this.id,'divmem3','divmem4');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><i id="menmem1" onclick="document.getElementById('masmem1').style.display='block'; menmemo(this.id,'divmem1','divmem2','mem2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divmem3" style="display:none;"><div align="right"><strong><?php echo $Memorias1;?></strong></div></div></td>
            <td colspan="2"><div id="divmem4" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="mem3" type="text" id="mem3" class="form-control" /><i id="masmem3" onclick="document.getElementById('menmem3').style.display='block'; masmemo(this.id,'divmem5','divmem6');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><i id="menmem2" onclick="document.getElementById('masmem2').style.display='block'; menmemo(this.id,'divmem3','divmem4','mem3');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divmem5" style="display:none;"><div align="right"><strong><?php echo $Memorias1;?></strong></div></div></td>
            <td colspan="2"><div id="divmem6" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="mem4" type="text" id="mem4" class="form-control" /><i id="menmem3" onclick="document.getElementById('masmem3').style.display='block'; menmemo(this.id,'divmem5','divmem6','mem4');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          </tr>
          <tr>
		  <td><div align="center"><img src="images/video.png" alt="Video" width="45" height="38" /></div></td>
            <td><div align="right"><strong><?php echo $bttargeta;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="grafic" type="text" id="grafic" class="form-control"></td>
          </tr>
          <tr>
		  <td><div align="center"><img src="images/HDD.png" alt="hdd" width="40" height="40"  /></div></td>
            <td><div align="right"><strong>HDD</strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="drive1" type="text" id="drive1" class="form-control"><i id="mashdd" onclick="document.getElementById('menhdd').style.display='block'; masmemo(this.id,'divhdd1','divhdd2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          <tr>
	        <td colspan="2"><div id="divhdd1" style="display:none;"><div align="right"><strong>HDD</strong></div></div></td>
            <td colspan="2"><div id="divhdd2" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="drive2" type="text" id="drive2" class="form-control"><i id="menhdd" onclick="document.getElementById('mashdd').style.display='block'; menmemo(this.id,'divhdd1','divhdd2','drive2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
		  <td><div align="center"><img src="images/DriveDVD.png" alt="drive" width="40" height="40" /></div></td>
            <td><div align="right"><strong><?php echo $btdevice;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="drive3" type="text" id="drive3" class="form-control"><i id="masdvd" onclick="document.getElementById('mendvd').style.display='block'; masmemo(this.id,'divdvd1','divdvd2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          <tr>
            <td colspan="2"><div id="divdvd1" style="display:none;"><div align="right"><strong><?php echo $btdevice;?></strong></div></div></td>
            <td colspan="2"><div id="divdvd2" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="drive4" type="text" id="drive4" class="form-control"><i id="mendvd" onclick="document.getElementById('masdvd').style.display='block'; menmemo(this.id,'divdvd1','divdvd2','drive4');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
		  <td><div align="center"><img src="images/sonido.png" alt="sonido" width="49" height="37" /></div></td>
            <td><div align="right"><strong><?php echo $btSONIDO;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="sonido" type="text" id="sonido" class="form-control"></td>
          <tr>
		  <td><div align="center"><img src="images/Ethernet card Vista.png" alt="Red" width="40" height="40" /></div></td>
            <td><div align="right"><strong><?php echo $btRED;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="red0" type="text" id="red0" class="form-control"><i id="masred" onclick="document.getElementById('menred').style.display='block'; masmemo(this.id,'divred1','divred2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          <tr>
            <td colspan="2"><div id="divred1" style="display:none;"><div align="right"><strong><?php echo $btRED;?></strong></div></div></td>
            <td colspan="2"><div id="divred2" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="red1" type="text" id="red1" class="form-control"><i id="masred2" onclick="document.getElementById('menred3').style.display='block'; masmemo(this.id,'divred3','divred4');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 259px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><i id="menred" onclick="document.getElementById('masred').style.display='block'; menmemo(this.id,'divred1','divred2','red1');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
            <td colspan="2"><div id="divred3" style="display:none;"><div align="right"><strong><?php echo $btRED;?></strong></div></div></td>
            <td colspan="2"><div id="divred4" style="display:none;"><input onkeypress="return handleEnter(this, event)" name="red2" type="text" id="red2" class="form-control" /><i id="menred3" onclick="document.getElementById('masred2').style.display='block'; menmemo(this.id,'divred3','divred4','red2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -24px; margin-left: 273px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
          <td><div align="center"><img src="images/fuente1.jpg" width="40" height="40" /></div></td>
            <td><div align="right"><strong><?php echo $btFUENTE;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="fuente" type="text" id="fuente" class="form-control"></td>
          <tr>
		  <td><div align="center"><img src="images/SO.png" width="40" height="40" /></div></td>
            <td><div align="right"><strong>OS</strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="so" type="text" id="so" class="form-control"></td>
          <tr>
		  <td><div align="center"><img src="images/custodios.png" width="40" height="40" /></div></td>
            <td><div align="right"><strong><?php echo $btCustodios;?></strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="custodio" readonly type="text" id="custodio" class="form-control" value="<?php echo $row_Recordset1['nombre']?>" size="40">            </td>
		  <tr>
		  <td><div align="center"></div></td>
            <td><div align="right"><strong><?php echo strtoupper($btNombre);?> PC </strong></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="npc" type="text" id="npc" class="form-control"><input name="idunidades" type="hidden" value="<?php echo $row['idunidades'];?>"></td>
          <tr>
            <td colspan="4" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><div align="center">
              <input type="button" class="btn" name="cancel" onclick="window.parent.location='registromedios1.php';" value="<?php echo $btcancelar;?>">&nbsp;<input type="submit" class="btn" name="insertar" value="<?php echo $btaceptar;?>">
            </div></td>	
	      </tr>	 
        </form>	
    </table>
<div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
