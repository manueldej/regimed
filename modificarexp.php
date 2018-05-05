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
$dde="";
$varCPU = array('marca','cpuid','frecuencia','fabricante','socket','cpucores','cpulogicos');
$varMemorias = array('marca','modelo','no_serie','fabricante','capacidad','tasa','frecuencia');
$varDiscoDuro = array('marca','modelo','no_serie','fabricante','capacidad','tasa','cache','rpm');
$varTarjetaGrafica = array('marca','modelo','no_serie','fabricante','capacidad','frecuencia');
$varcomponente = array($varCPU,$varMemorias,$varDiscoDuro,$varTarjetaGrafica);

if(isset($_REQUEST['palabra'])){
 $palabra=$_REQUEST['palabra'];
}else{
  $palabra="";
}

if (isset($_REQUEST['q'])){
 $q= $_REQUEST['q'];
}else{
 $q="";
}
$explode2 = array();
  if(isset($_REQUEST['inv'])){
    $inv = $_REQUEST['inv'];
    $explode=explode("*",$inv);
    if((strstr($_REQUEST['idunidades'], '*')) !=""){
      $explode2=explode("*",$_REQUEST['idunidades']);
    }else{
      $explode2[]= $_REQUEST['idunidades'];
    }	
  }
if(isset($_REQUEST['marcado'])){
	$explode=$_REQUEST['marcado'];
	$inv = $explode[0];
	$explode2 = $_REQUEST['idunidades'];
}
$noinv = $explode[0];

    if(isset($_POST['key'])){$key =$_POST['key'];}
	if(isset($_POST['marcado'])){$marcado =$_POST['marcado'];}
	if(isset($_REQUEST['inv'])){$key =$_REQUEST['inv'];}
    if(isset($_REQUEST['key'])){$key =$_REQUEST['key'];}
	if(isset($_REQUEST['idunidades'])){$idunidadesc =$_REQUEST['idunidades'];}
	if(isset($_REQUEST['cut'])){$nom_custo =$_REQUEST['cut'];}
	if(isset($_REQUEST['marcado'])){$marcado =$_REQUEST['marcado'];}
	if(isset($_REQUEST['palabra'])){$palabra =$_REQUEST['palabra'];}
	if(isset($_REQUEST['dde'])){$dde =$_REQUEST['dde'];}
	if(isset($_REQUEST['compon'])){$compon =$_REQUEST['compon'];}
	if(isset($_REQUEST['compo'])){$compo =$_REQUEST['compo'];}
	
	if(isset($_REQUEST['compo'])){
	    $sql1 ="SELECT * FROM componentes WHERE nombre ='".$compo."' AND idexp='".$inv."'";
	}else{
	  $compo ="";
	  $sql1 ="SELECT * FROM componentes";
	 }
	$result1 = mysqli_query($miConex, $sql1) or die (mysql_error());
	$rows1 = mysqli_fetch_array($result1); 
	$cantrows = mysqli_num_rows($result1);
	
?>
<script language="JavaScript">

  // chequear campos en blanco 
function submit_page(form)
{
 foundError = false;
 
 if(isFieldBlank(form.t2)) {
  alert("El campo 'Inv' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.cpu)) {
  alert("El campo 'CPU' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.placa)) {
  alert("El campo 'PLACA' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.chiset)) {
  alert("El campo 'CHIPSET' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem)) {
  alert("El campo 'MEMORIA' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem2)) {
  alert("El campo 'MEMORIA' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem3)) {
  alert("El campo 'MEMORIA' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem4)) {
  alert("El campo 'MEMORIA' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.grafic)) {
  alert("El campo 'GRAFICS' est\u00E1 en blanco.");
  foundError = true;
 }else
  if(isFieldBlank(form.fuente)) {
  alert("El campo 'FUENTE DE PODER' est\u00E1 en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.so)) {
  alert("El campo 'SO' est\u00E1 en blanco.");
  foundError = true;
 }else
   
 if(foundError == false )
  document.form1.action="insertarexp.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

function retornar(form){
 document.form1.action="registromedios1.php";
}
//------------------------- funciones -------------------------------------------//

function isFieldBlank(theField)
{
 innStr = theField.value;
 innLen = innStr.length;

 if(theField.value == "" && innLen==0)
  return true;
 else
  return false;


function ctype_digit(theField){
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
  {
   var ch = val.substring(i,i+1)
   if(ch < "0" || "9"< ch)
     return true;
  }
}

function ci(theField) {
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
    var chh = val.substring(i,i+1)

  if(i < "11")
    return true;
}	
 </script>
<script type="text/javascript">

	 function seguro4(q,inv,idun,ini,donde,compon,compo,accion){
	    if (compo!=="") {
			document.wq.q.value = q;
			document.wq.action='#modal6';
			document.wq.inv.value = inv;
			document.wq.idunidades.value = idun;
			document.wq.palabra.value = ini;
			document.wq.dde.value = donde;
			document.wq.compon.value = compon;
			document.wq.compo.value = compo;
			document.wq.accion.value = accion;
			document.wq.submit();
		}
	 }
 
 	function __ir(inv,idun,ini,donde){
     var aceptaEntrar = window.confirm("\u00BFEs esta operaci\u00F3n correcta.?");
		if (aceptaEntrar) {
		  document.ir.inv.value = inv;
	      document.ir.idunidades.value = idun;
	      document.ir.palabra.value = ini;
	      document.ir.dde.value = donde;
	      document.ir.submit();
		}else {
		 return false;
		}  
	}
</script>
<?php include('barra.php');?>
<form action="modificarexp.php" method="post" name="ir" id="ir">
	<input name="inv" value="" type="hidden">
	<input name="idunidades" type="hidden">
	<input name="idun" id="marcado" type="hidden">
	<input name="palabra" id="palabra" type="hidden">
	<input name="dde" id="dde" type="hidden">
</form>
<form action="" method="post" name="wq" id="wq">
	<input name="q" value="<?php echo $q;?>" type="hidden">
	<input name="inv" value="" type="hidden">
	<input name="idunidades" type="hidden">
	<input name="idun" id="marcado" type="hidden">
	<input name="palabra" id="palabra" type="hidden">
	<input name="dde" id="dde" type="hidden">
	<input name="compon" id="compon" type="hidden">
	<input name="compo" id="compo" type="hidden">
	<input name="accion" id="accion" type="hidden">
</form>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 54%; height: 543px; border-radius: 5px 5px 5px 5px; margin-top:70px;">
<div style="height: 15px; text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25); background-color: rgb(196, 84, 60); background-image: linear-gradient(to bottom, rgb(#3C85C4), rgb(#3C85C4)); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); color: rgb(251, 238, 238); padding: 1px 0px 16px 9px; margin-left: -19px; width: 571px; vertical-align: middle; border-radius: 4px 4px 0px 0px; margin-top: -3px;"><a href="" title="<?php echo $btclose; ?>" class="close tip-s medium  barramenu" style="text-decoration:none; cursor:pointer; color: #F8F3F3; float:right; width: 15px; top: 0px; background: rgb(221, 179, 172) none repeat scroll 0% 0%;">X</a>
<h2  class="pos"><?php echo strtoupper($new3.$btEXPEDIENTE);?></h2></div>
		<p><iframe src="form-insertarexp.php?inv=<?php echo @$noinv;?>&marcado=<?php echo @$marcado;?>&idunidades=<?php echo @$explode2[0];?>" name="b" scrolling="Auto" width="102%" height="500" frameborder="0" class="notice" border="0"></iframe></p>
</div>
</div>
<div id="modal6" class="modalmask" style="background: rgba(63, 57, 57, 0.7);">
	<div class="modalbox resize" style="width: 400px; <?php if($compon=="Disco Duro") { ?>height: 390px;<?php }elseif($compon=="Memorias"){ ?>height: 353px;<?php }elseif($compon=="Tarjeta Grafica"){ ?>height: 319px;<?php }elseif($compon=="Microprocesador"){ ?>height: 320px;<?php } ?>border: 1px solid rgb(194, 35, 16); border-radius: 5px 5px 5px 5px; left: 4%; top: 45px; background: rgb(244, 251, 251) none repeat scroll 0% 0%;">
		<div style="height: 15px; text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25); background-color: rgb(196, 84, 60); background-image: linear-gradient(to bottom, rgb(#3C85C4), rgb(#3C85C4)); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); color: rgb(251, 238, 238); padding: 1px 0px 16px 9px; margin-left: -19px; width: 429px; vertical-align: middle; border-radius: 4px 4px 0px 0px; margin-top: -3px;"><span class="close tip-s medium  barramenu" onclick="__ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','me');" style="text-decoration:none; cursor:pointer; color: rgb(150, 120, 120); float:right; width: 25px; top: 0px; background: rgb(221, 179, 172) none repeat scroll 0% 0%;">X</span>
			<div class="panel-title" style="margin-top: 5px;"><b>DETALLES DEL COMPONENTE: <?php if (strlen($q)>=15) { echo substr($q,0,15)."..."; } else { echo $q; }?></b></div>
		</div><br>
	<form action="" method="post" name="componente">
        <table width="47%" align="center" class="table"><?php 
		    if($compon == "Memorias") {
		        foreach ($varcomponente[1] as $clave => $valor) { 
				   $nombcamp[] = $valor; 
				}
			}elseif(($compon == "Microprocesador")) {
		        foreach ($varcomponente[0] as $clave => $valor) { 
				   $nombcamp[] = $valor; 
				}
		    }elseif(($compon == "Tarjeta Grafica")) {
		        foreach ($varcomponente[3] as $clave => $valor) { 
				   $nombcamp[] = $valor; 
				}
		    }elseif(($compon == "Disco Duro")) {
		        foreach ($varcomponente[2] as $clave => $valor) { 
				   $nombcamp[] = $valor; 
				}
		    }
		  
		   for ($a=0; $a<count($nombcamp); $a++) { 
		?>
		<tr>
		  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcamp[$a]); ?></b></div></td>
		  <td width="54%" align="center"><div align="center"><input onkeypress="return handleEnter(this, event)" name="<?php echo $nombcamp[$a]; ?>1" id="<?php echo $nombcamp[$a]; ?>1" type="text" required value="<?php echo $rows1[$nombcamp[$a]]; ?>" class="form-control" onblur="componente.<?php echo $nombcamp[$a]; ?>.value=this.value; <?php if($_REQUEST['accion']=='editar') { ?>__editcompo('<?php echo $nombcamp[$a]; ?>','<?php echo $rows1['id']; ?>',this.value,'<?php echo $nombcamp[$a]; ?>'); <?php } ?>"></div></td>
		</tr><?php } ?>
		<tr><input name="interfaz" id="interfaz" type="hidden" value="<?php echo $rows1['interfaz'];?>"><?php if($compon!="Microprocesador" AND $compon!="Memorias" ) { ?>
		  <td width="46%" align="center"><div align="center"><b>INTERFAZ</b></div></td>
		  <td width="54%" align="center"><div align="center">
		    <select name="interf" id="interf" class="form-control" required onchange="componente.interfaz.value=this.value; __editcompo('interfaz','<?php echo $rows1['id']; ?>',this.value,'interfaz');">
			  <option value="AGP" <?php if($rows1['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
			  <option value="IDE" <?php if($rows1['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
			  <option value="PCI" <?php if($rows1['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
			  <option value="PCI-X" <?php if($rows1['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
			  <option value="PCIe" <?php if($rows1['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
			  <option value="SATA" <?php if($rows1['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
			  <option value="SCSI" <?php if($rows1['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
			  <option value="SAS" <?php if($rows1['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
			  <option value="USB" <?php if($rows1['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
	        </select></div></td><?php } ?>
		</tr>
		<tr><input name="taip" id="taip" type="hidden" value="<?php echo $rows1['tipo'];?>"><?php if($compon=="Memorias") { ?>
		  <td width="46%" align="center"><div align="center" id="tmem1"><b>TIPO</b></div></td>
		  <td width="54%" align="center"><div align="center" id="tmem2" >
		    <select name="tai" id="tai" class="form-control" onchange="componente.taip.value=this.value; __editcompo('tipo','<?php echo $rows1['id']; ?>',this.value,'tipo');">
			  <option value="SDR SDRAM" <?php if($rows1['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
			  <option value="RDRAM" <?php if($rows1['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
			  <option value="DDR SDRAM" <?php if($rows1['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
			  <option value="DDR2 SDRAM" <?php if($rows1['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
			  <option value="DDR3 SDRAM" <?php if($rows1['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
			  <option value="DDR4 SDRAM" <?php if($rows1['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
	        </select></div></td><?php } ?>
		</tr>
		<tr>
		  <td colspan="2"><input name="acepta" onclick="<?php if($_REQUEST['accion']=='insertar') { ?> __insertcompo('<?php echo $compon; ?>','<?php echo $key; ?>','<?php echo $q; ?>',document.getElementById('marca').value,document.getElementById('modelo').value,document.getElementById('no_serie').value,document.getElementById('fabricante').value,document.getElementById('capacidad').value,document.getElementById('tasa').value,document.getElementById('frecuencia').value,document.getElementById('cache').value,document.getElementById('rpm').value,document.getElementById('interfaz').value,document.getElementById('tipo').value,document.getElementById('cpuid').value,document.getElementById('cpucores').value,document.getElementById('cpulogicos').value,document.getElementById('socket').value); <?php } ?> __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','me');" value="<?php echo $btaceptar;?>" class="btn" style="float: right;" type="button"></td>
		</tr>
		</table>
		<input name="marca" id="marca" type="hidden">
		<input name="modelo" id="modelo" type="hidden">
		<input name="no_serie" id="no_serie" type="hidden">
		<input name="fabricante" id="fabricante" type="hidden">
		<input name="capacidad" id="capacidad" type="hidden">
		<input name="tasa" id="tasa" type="hidden">
		<input name="frecuencia" id="frecuencia" type="hidden">
		<input name="cache" id="cache" type="hidden">
		<input name="rpm" id="rpm" type="hidden">
		<input name="interfaz" id="interfaz" type="hidden">
		<input name="tipo" id="tipo" type="hidden">
		<input name="cpuid" id="cpuid" type="hidden">
		<input name="cpucores" id="cpucores" type="hidden">
		<input name="cpulogicos" id="cpulogicos" type="hidden">
		<input name="socket" id="socket" type="hidden">
	</form>
	</div>
</div>
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php if((count($explode) >1)){ echo $bteditar." ".$btEXPEDIENTE."S AFT";}else{ echo $bteditar." ".$btEXPEDIENTE." AFT:<font color=red><strong> ".$inv."</font>";} ?></legend>
<form action="insertarexp.php" method="post" name="form1" >
				<table width="576" height="759" border="0" align="center" class="tablen"><?php
					$kl=0;
					foreach($explode as $key){
						if(!empty($key)){
							$queryx="select * from exp where inv='".$key."' AND idunidades='".$explode2[$kl]."'";
							$result=mysqli_query($miConex, $queryx) or die(mysql_error());
							$row = mysqli_fetch_array($result);
                            $sihay = mysqli_num_rows($result); 							
							$memor=explode('*',$row["MEMORIA2"]);
							$redes=explode('*',$row["RED2"]); 
							if($sihay!=0) { 
							        $sqlcpt0 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$row["CPU"]."'";
									$rescpt0 = mysqli_query($miConex, $sqlcpt0) or die (mysql_error());
									$filacomp0 = mysqli_fetch_array($rescpt0);
									$numre0 = mysqli_num_rows($rescpt0);
								    $nombcampo =array();
									foreach ($varcomponente[0] as $clave => $valor) { 
										   $nombcampo[] = $valor; 
									}?>
							<tr>
								<td colspan="6"><div class="vistauser1" align="center"><b><?php echo "Nro. INV: ".$key; ?></b></div></td>
							</tr>
							<tr>
								<td width="62" height="47" align="right"><img src="images/cpu.png" alt="CPU" width="45" height="45" class="Estilo1" longdesc="Unidad central de procesamiento " /></td>
								<td width="130"><div align="right"><strong>CPU</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="cpu[]" type="text" class="form-control" id="cpu[]" value="<?php echo $row['CPU'];?>" size="50"></td>
								<td><?php if ($numre0==0) {  ?><i id="insertcpu" onclick="seguro4('<?php echo $row["CPU"]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Microprocesador','<?php echo $row['CPU']; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $row['CPU']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr><?php if ($numre0!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top">
								<div id="<?php echo $row['CPU']; ?>" style="display:block;">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre0!=0) {  ?><i id="editcpu" onclick="seguro4('<?php echo $row["CPU"]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Microprocesador','<?php echo $row['CPU']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['CPU']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleCPU" onclick="__deletecompo('<?php echo $filacomp0["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['CPU']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="cpu" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre0!=0) { 
									 for ($a=0; $a<count($nombcampo); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><?php echo strtoupper($nombcampo[$a]); ?></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo[$a]; ?>" id="<?php echo $nombcampo[$a]; ?>0" type="text" style="width:200px;"  value="<?php echo $filacomp0[$nombcampo[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo[$a]; ?>','<?php echo $filacomp0['id']; ?>',this.value,'<?php echo $nombcampo[$a]; ?>');"></div></td>
									</tr><?php } } ?>
								</form>	
								</table>
								<?php } ?>
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } ?>	
							<tr>
								<td height="42" align="right"><img src="images/placa.png" alt="Board" width="55" height="38" longdesc="Placa Base" /></td>
								<td><div align="right"><strong><?php echo $btPLACA;?></strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="placa[]" type="text" class="form-control" id="placa[]" value="<?php echo $row['PLACA'];?>"></td>
							</tr>
							<tr>
								<td align="right"><img src="images/chipset.png" alt="Chipset" width="55" height="38" longdesc="Chipset" /></td>
								<td><div align="right"><strong>CHIPSET </strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="chiset[]" type="text" class="form-control" id="chiset[]" value="<?php echo $row['CHIPSET'];?>" size="50"></td>
							</tr><?php 
							    $sqlcpt1 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$row['MEMORIA']."'";
								$rescpt1 = mysqli_query($miConex, $sqlcpt1) or die (mysql_error());
								$filacomp1 = mysqli_fetch_array($rescpt1);
								$numre1 = mysqli_num_rows($rescpt1);
								$nombcampo1 =array();
									foreach ($varcomponente[1] as $clave => $valor) { 
										   $nombcampo1[] = $valor; 
									} ?>
							<tr>
								<td align="right"><img src="images/ram.png" alt="RAM" width="40" height="40" /></td>
								<td><div align="right"><strong><?php echo $Memorias1;?>-1</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem[]" type="text" class="form-control" id="mem[]" value="<?php echo $row['MEMORIA'];?>" size="50"></td>
							    <td><?php if (($numre1==0)  and ($row['MEMORIA']!="")) { ?><i id="insertmemo1" onclick="seguro4('<?php echo $row['MEMORIA']; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $row['MEMORIA']; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr><?php if ($numre1!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top">
								<div id="<?php echo $row['MEMORIA']; ?>" style="display:block;">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre1!=0) {  ?><i id="editmem1" onclick="seguro4('<?php echo $row['MEMORIA']; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $row['MEMORIA']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleCPU" onclick="__deletecompo('<?php echo $filacomp1["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i><i id="deleMEMORIA0" onclick="__deletecompo('<?php echo $filacomp1["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="memo1" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre1!=0) { 
									 for ($a=0; $a<count($nombcampo1); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><?php echo strtoupper($nombcampo1[$a]); ?></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo1[$a]; ?>" id="<?php echo $nombcampo1[$a]; ?>1" type="text" value="<?php echo $filacomp1[$nombcampo1[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo1[$a]; ?>','<?php echo $filacomp1['id']; ?>',this.value,'<?php echo $nombcampo1[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center">TIPO</div></td>
									  <td width="54%" align="center"><div align="center">
									    <select name="tipo0" id="tipo0" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp1['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp1['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp1['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp1['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp1['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp1['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp1['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?> 
							</tr>
								</form>	
								</table><?php } ?>
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } 
								$sqlcpt1 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$memor[0]."'";
								$rescpt1 = mysqli_query($miConex, $sqlcpt1) or die (mysql_error());
								$filacomp1 = mysqli_fetch_array($rescpt1);
								$numre1 = mysqli_num_rows($rescpt1);
								$nombcampo2 =array();
									foreach ($varcomponente[1] as $clave => $valor) { 
										   $nombcampo2[] = $valor; 
									} ?>
							<tr>
								<td align="right"><strong><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></strong></td>
								<td><div align="right"><strong><?php echo $Memorias1;?>-2</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem2[]" type="text" class="form-control" id="mem2[]" value="<?php echo @$memor[0]?>"></td>
								<td><?php if (($numre1==0) and ($memor[0]!="")) {  ?><i id="insertmemo2" onclick="seguro4('<?php echo $memor[0]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memor[0]; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $memor[0]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr><?php if ($numre1!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top">
								<div id="<?php echo $memor[0]; ?>" style="display:block;">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre1!=0) {  ?><i id="editcpu" onclick="seguro4('<?php echo $memor[0]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memor[0]; ?>','editar');" manolo="Editar&nbsp;<?php echo $memor[0]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleCPU" onclick="__deletecompo('<?php echo $filacomp1["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="memo2" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre1!=0) { 
									 for ($a=0; $a<count($nombcampo2); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><?php echo strtoupper($nombcampo2[$a]); ?></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo2[$a]; ?>" id="<?php echo $nombcampo2[$a]; ?>1" type="text" style="width:200px;" value="<?php echo $filacomp1[$nombcampo2[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo2[$a]; ?>','<?php echo $filacomp1['id']; ?>',this.value,'<?php echo $nombcampo2[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center">TIPO</div></td>
									  <td width="54%" align="center"><div align="center">
									    <select name="tipo0" id="tipo0" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp1['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp1['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp1['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp1['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp1['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp1['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp1['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?> 
								</form>	
								</table>
								<?php } ?>	
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } 
							    $sqlcpt2 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$memor[1]."'";
								$rescpt2 = mysqli_query($miConex, $sqlcpt2) or die (mysql_error());
								$filacomp2 = mysqli_fetch_array($rescpt2);
								$numre2 = mysqli_num_rows($rescpt2);
								$nombcampo3 =array();
									foreach ($varcomponente[1] as $clave => $valor) { 
										   $nombcampo3[] = $valor; 
									}?>
							<tr>
							  <td align="right"><strong><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></strong></td>
							  <td><div align="right"><strong><?php echo $Memorias1;?>-3</strong></div></td>
							  <td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem3[]" type="text" class="form-control" id="mem3[]" value="<?php echo @$memor[1];?>" /></td>
				              <td><?php if (($numre2==0) and ($memor[1]!="")) {  ?><i id="insertmemo3" onclick="seguro4('<?php echo $memor[1]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memor[1]; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $memor[1]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr><?php if ($numre2!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top">
								<div id="<?php echo $memor[1]; ?>" style="display:block;">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre2!=0) {  ?><i id="editcpu" onclick="seguro4('<?php echo $memor[1]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memor[1]; ?>','editar');" manolo="Editar&nbsp;<?php echo $memor[1]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleCPU" onclick="__deletecompo('<?php echo $filacomp2["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $memor[1]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="cpu" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre2!=0) { 
									 for ($a=0; $a<count($nombcampo3); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><?php echo strtoupper($nombcampo3[$a]); ?></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo3[$a]; ?>" id="<?php echo $nombcampo3[$a]; ?>2" type="text" style="width:200px;" value="<?php echo $filacomp2[$nombcampo3[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo3[$a]; ?>','<?php echo $filacomp2['id']; ?>',this.value,'<?php echo $nombcampo3[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center">TIPO</div></td>
									  <td width="54%" align="center"><div align="center">
									    <select name="tipo0" id="tipo0" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp2['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp2['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp2['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp2['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp2['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp2['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp2['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?>
								</form>	
								</table>
								<?php } ?>	
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } 
							    $sqlcpt3 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$memor[2]."'";
								$rescpt3 = mysqli_query($miConex, $sqlcpt3) or die (mysql_error());
								$filacomp3 = mysqli_fetch_array($rescpt3);
								$numre3 = mysqli_num_rows($rescpt3);
								$nombcampo4 =array();
									foreach ($varcomponente[1] as $clave => $valor) { 
										   $nombcampo4[] = $valor; 
									}?>
							<tr>
							  <td align="right"><strong><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></strong></td>
							  <td><div align="right"><strong><?php echo $Memorias1;?>-4</strong></div></td>
							  <td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem4[]" type="text" class="form-control" id="mem4[]" value="<?php echo @$memor[2]?>" /></td>
				              <td><?php if (($numre3==0) and ($memor[2]!="")) {  ?><i id="insertmemo4" onclick="seguro4('<?php echo $memor[2]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memor[2]; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $memor[2]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr><?php if ($numre3!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top">
								<div id="<?php echo $memor[2]; ?>" style="display:block;">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre3!=0) {  ?><i id="editcpu" onclick="seguro4('<?php echo $memor[2]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memor[2]; ?>','editar');" manolo="Editar&nbsp;<?php echo $memor[2]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleCPU" onclick="__deletecompo('<?php echo $filacomp3["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $memor[2]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="cpu" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre3!=0) { 
									 for ($a=0; $a<count($nombcampo4); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><?php echo strtoupper($nombcampo4[$a]); ?></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo4[$a]; ?>" id="<?php echo $nombcampo4[$a]; ?>1" type="text" style="width:200px;" value="<?php echo $filacomp3[$nombcampo4[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo4[$a]; ?>','<?php echo $filacomp3['id']; ?>',this.value,'<?php echo $nombcampo4[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center">TIPO</div></td>
									  <td width="54%" align="center"><div align="center">
									    <select name="tipo0" id="tipo0" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp3['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp3['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp3['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp3['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp3['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp3['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp3['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?>
								</form>	
								</table>
								<?php } ?>	
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } 
							    $sqlcpt4 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$row['GRAFICS']."'";
								$rescpt4 = mysqli_query($miConex, $sqlcpt4) or die (mysql_error());
								$filacomp4 = mysqli_fetch_array($rescpt4);
								$numre4 = mysqli_num_rows($rescpt4);
								$nombcampo5 =array();
									foreach ($varcomponente[3] as $clave => $valor) { 
										   $nombcampo5[] = $valor; 
									}?>
							<tr>
								<td align="right"><img src="images/video.png" alt="video" width="45" height="38" longdesc="Tarjeta de Video" /></td>
								<td><div align="right"><strong><?php echo $bttargeta;?></strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="grafic[]" type="text" class="form-control" id="grafic[]" value="<?php echo $row['GRAFICS'];?>" size="50">						</td>
							    <td><?php if (($numre4==0) and ($row['GRAFICS']!="")) {  ?><i id="insertgrafics" onclick="seguro4('<?php echo $row['GRAFICS']; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Tarjeta Grafica','<?php echo $row['GRAFICS']; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $row['GRAFICS']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr><?php if ($numre4!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top">
								<div id="<?php echo $row['GRAFICS']; ?>" style="display:block;">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre4!=0) { ?><i id="editgrafics" onclick="seguro4('<?php echo $row["GRAFICS"]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Tarjeta Grafica','<?php echo $row['GRAFICS']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['GRAFICS']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleGrafics" onclick="__deletecompo('<?php echo $filacomp4["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','me');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['GRAFICS']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="cpu" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre4!=0) { 
									 for ($a=0; $a<count($nombcampo5); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><?php echo strtoupper($nombcampo5[$a]); ?></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo5[$a]; ?>" id="<?php echo $nombcampo5[$a]; ?>0" type="text" value="<?php echo $filacomp4[$nombcampo5[$a]]; ?>" style="width:200px;" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo5[$a]; ?>','<?php echo $filacomp4['id']; ?>',this.value,'<?php echo $nombcampo5[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<td width="46%" align="center"><div align="center">INTERFAZ</div></td>
									<td width="54%" align="center"><div align="center">
										<select name="interf" id="interf" class="form-control" required onchange="componente.interfaz.value=this.value; __editcompo('interfaz','<?php echo $filacomp4['id']; ?>',this.value,'interfaz');">
										  <option value="AGP" <?php if($filacomp4['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
										  <option value="IDE" <?php if($filacomp4['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
										  <option value="PCI" <?php if($filacomp4['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
										  <option value="PCI-X" <?php if($filacomp4['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
										  <option value="PCIe" <?php if($filacomp4['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
										  <option value="SATA" <?php if($filacomp4['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
										  <option value="SCSI" <?php if($filacomp4['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
										  <option value="SAS" <?php if($filacomp4['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
										  <option value="USB" <?php if($filacomp4['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
										</select></div><?php } ?>
									</td>
								</form>	
								</table><?php } ?>
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } ?>	
							<tr><?php  
							    $sqlcpt5 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$row['DRIVE1']."'";
								$rescpt5 = mysqli_query($miConex, $sqlcpt5) or die (mysql_error());
								$filacomp5 = mysqli_fetch_array($rescpt5);
								$numre5 = mysqli_num_rows($rescpt5);
								$nombcampo6 =array();
									foreach ($varcomponente[2] as $clave => $valor) { 
										   $nombcampo6[] = $valor; 
									}?>
								<td align="right"><span align="left"><strong><img src="images/HDD.png" alt="HDD" width="40" height="40" longdesc="Disco Duro" /></strong></span></td>
								<td><div align="right"><strong>HDD-1</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive1[]" type="text" class="form-control" id="drive1[]" value="<?php echo $row['DRIVE1'];?>" size="50" >						</td>
							    <td><?php if (($numre5==0) AND ($row['DRIVE1']!="")) {  ?><i id="insertgrafics" onclick="seguro4('<?php echo $row['DRIVE1']; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE1']; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $row['DRIVE1']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr>
							<?php if ($numre5!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top" width="300">
								<div id="<?php echo $row['DRIVE1']; ?>">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre4!=0) { ?><i id="editgrafics" onclick="seguro4('<?php echo $row["DRIVE1"]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE1']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['DRIVE1']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleHDD" onclick="__deletecompo('<?php echo $filacomp5["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','me');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['DRIVE1']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="cpu" action="" method="post">
								<table width="100%" align="center" class="table" border="0"> 
									<?php if ($numre5!=0) { 
									 for ($a=0; $a<count($nombcampo6); $a++) { ?>
									<tr>
									  <td width="70%" align="center"><div align="center"><?php echo strtoupper($nombcampo6[$a]); ?></div></td>
									  <td width="90%" align="center"><div align="center"><input name="<?php echo $nombcampo6[$a]; ?>" id="<?php echo $nombcampo6[$a]; ?>0" type="text" style="width:200px;" value="<?php echo $filacomp5[$nombcampo6[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo6[$a]; ?>','<?php echo $filacomp5['id']; ?>',this.value,'<?php echo $nombcampo6[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<td width="70%" align="center"><div align="center">INTERFAZ</div></td>
									<td width="70%" align="center"><div align="center">
										<select name="interf" id="interf" class="form-control" required onchange="componente.interfaz.value=this.value; __editcompo('interfaz','<?php echo $filacomp5['id']; ?>',this.value,'interfaz');">
										  <option value="AGP" <?php if($filacomp5['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
										  <option value="IDE" <?php if($filacomp5['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
										  <option value="PCI" <?php if($filacomp5['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
										  <option value="PCI-X" <?php if($filacomp5['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
										  <option value="PCIe" <?php if($filacomp5['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
										  <option value="SATA" <?php if($filacomp5['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
										  <option value="SCSI" <?php if($filacomp5['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
										  <option value="SAS" <?php if($filacomp5['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
										  <option value="USB" <?php if($filacomp5['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
										</select></div><?php } ?>
									</td>
								</form>	
								</table><?php } ?>
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php }   
							    $sqlcpt6 = "SELECT * FROM componentes WHERE componentes.idexp='".$key."' AND componentes.nombre = '".$row['DRIVE2']."'";
								$rescpt6 = mysqli_query($miConex, $sqlcpt6) or die (mysql_error());
								$filacomp6 = mysqli_fetch_array($rescpt6);
								$numre6 = mysqli_num_rows($rescpt6);
								$nombcampo7 =array();
									foreach ($varcomponente[2] as $clave => $valor) { 
										   $nombcampo7[] = $valor; 
								}?>							
							<tr>
								<td align="right"><span align="left"><strong><img src="images/HDD.png" alt="HDD" width="40" height="40" longdesc="Disco Duro" /></strong></span></td>
								<td><div align="right"><strong>HDD-2</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive2[]" type="text" class="form-control" id="drive2[]" value="<?php echo $row['DRIVE2'];?>" size="50" >						</td>
							    <td><?php if (($numre6==0) AND ($row['DRIVE2']!="")) {  ?><i id="inserthdd" onclick="seguro4('<?php echo $row['DRIVE2']; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE2']; ?>','insertar');" manolo="Agregar Detalles del Componte :&nbsp;<?php echo $row['DRIVE2']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -11px; margin-left: -29px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i><?php } ?></td>
							</tr>
							<?php if ($numre6!=0) {  ?>
							<tr>	
							    <td>&nbsp;</td>
								<td>&nbsp;</td>
								<td valign="top" width="300">
								<div id="<?php echo $row['DRIVE2']; ?>">
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php if ($numre6!=0) { ?><i id="edithdd" onclick="seguro4('<?php echo $row["DRIVE2"]; ?>','<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE2']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['DRIVE2']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleHDD" onclick="__deletecompo('<?php echo $filacomp6["id"]; ?>'); __ir('<?php echo $key;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','me');" manolo="Eliminar Detalles del Componte :&nbsp;<?php echo $row['DRIVE2']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="cpu" action="" method="post">
								<table width="100%" align="center" class="table" border="0"> 
									<?php if ($numre6!=0) { 
									 for ($a=0; $a<count($nombcampo7); $a++) { ?>
									<tr>
									  <td width="70%" align="center"><div align="center"><?php echo strtoupper($nombcampo7[$a]); ?></div></td>
									  <td width="90%" align="center"><div align="center"><input name="<?php echo $nombcampo7[$a]; ?>" id="<?php echo $nombcampo7[$a]; ?>0" type="text" style="width:200px;" value="<?php echo $filacomp6[$nombcampo7[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo7[$a]; ?>','<?php echo $filacomp6['id']; ?>',this.value,'<?php echo $nombcampo7[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<td width="70%" align="center"><div align="center">INTERFAZ</div></td>
									<td width="70%" align="center"><div align="center">
										<select name="interf" id="interf" class="form-control" required onchange="componente.interfaz.value=this.value; __editcompo('interfaz','<?php echo $filacomp6['id']; ?>',this.value,'interfaz');">
										  <option value="AGP" <?php if($filacomp6['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
										  <option value="IDE" <?php if($filacomp6['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
										  <option value="PCI" <?php if($filacomp6['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
										  <option value="PCI-X" <?php if($filacomp6['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
										  <option value="PCIe" <?php if($filacomp6['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
										  <option value="SATA" <?php if($filacomp6['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
										  <option value="SCSI" <?php if($filacomp6['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
										  <option value="SAS" <?php if($filacomp6['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
										  <option value="USB" <?php if($filacomp6['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
										</select></div><?php } ?>
									</td>
								</form>	
								</table><?php } ?>
								</div>
								</td>
								<td>&nbsp;</td>
							</tr><?php } ?>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/DriveDVD.png" alt="DRIVE" width="40" height="40" longdesc="Disco Duro/Lector/Quemador" /></strong></span></td>
								<td><div align="right"><strong><?php echo $btdevice;?>-1</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive3[]" type="text" class="form-control" id="drive3[]" value="<?php echo $row['DRIVE3']?>" size="50" >						</td>
							</tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/DriveDVD.png" alt="DRIVE" width="40" height="40" longdesc="Disco Duro/Lector/Quemador" /></strong></span></td>
								<td><div align="right"><strong><?php echo $btdevice;?>-2</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive4[]" type="text" class="form-control" id="drive4[]" value="<?php echo $row["DRIVE4"]?>" size="50" >						</td>
							</tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/sonido.png" alt="SONIDO" width="40" height="40" longdesc="Tarjeta de Sonido " /></strong></span></td>
								<td><div align="right"><strong><?php echo $btSONIDO;?></strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="sonido[]" type="text" class="form-control" id="sonido[]" value="<?php echo $row['SONIDO'];?>" size="50" >						</td>
							</tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/Ethernet card Vista.png" alt="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></span></td>
								<td><div align="right"><strong><?php echo $btRED;?>-1</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="red0[]" type="text" class="form-control" id="red0[]" value="<?php echo $row['RED'];?>" size="50">						</td>
							</tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/Ethernet card Vista.png" alt="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></span></td>
								<td><div align="right"><strong><?php echo $btRED;?>-2</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="red1[]" type="text" class="form-control" id="red1[]" value="<?php echo @$redes[0];?>" size="50">						</td>
							</tr>
							<tr>
							  <td align="right"><strong><img src="images/Ethernet card Vista.png" alt="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></td>
							  <td><div align="right"><strong><?php echo $btRED;?>-3</strong></div></td>
							  <td colspan="3"><input onkeypress="return handleEnter(this, event)" name="red2[]" type="text" class="form-control" id="red2[]" value="<?php echo @$redes[1];?>" size="50" /></td>
				            </tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/fuente1.jpg" title="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></span></td>
								<td><div align="right"><strong><?php echo $btFUENTE;?></strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="fuente[]" type="text" class="form-control" id="fuente[]" value="<?php echo $row['FUENTE']?>" size="50">						</td>
							</tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/SO.png" alt="SO" width="40" height="40" longdesc="Sistema Operativo" /></strong></span></td>
								<td><div align="right"><strong>OS</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="so[]" type="text" class="form-control" id="so[]" value="<?php echo $row['OS']?>" size="50"></td>					
							</tr>
							<tr>
								<td align="right"><span align="left"><strong><img src="images/custodios.png" alt="CUST" width="40" height="40" longdesc="Custodios" /></strong></span></td>
								<td><div align="right"><strong><?php echo strtoupper($btCustodios);?></strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="custodio[]" type="text" class="form-control" id="custodio[]" value="<?php echo $row['custodio'];?>" readonly ></td>
							</tr>					
							<tr>
								<td colspan="2" align="right"><div align="right"><strong><?php echo strtoupper($btNombre);?> PC</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="npc[]" type="text" class="form-control" id="npc[]" value="<?php echo $row['n_PC']?>" size="50"></td>
							</tr>
							<tr>
								<td colspan="5"><hr><input type="hidden" name="invt[]" value="<?php echo $key;?>"><input type="hidden" name="marcado[]" value="<?php echo $row['id'];?>"></td>
							</tr><?php } else { ?>
									<script language="javascript">document.location='et.php?inv=<?php echo $key;?>';</script>
								<?php
							}
							$kl++;
						}						
					} if ($sihay!=0) { ?>
					<tr>
						<td colspan="2" align="right"><input type="submit" class="btn" name="editar" value="<?php echo $btaceptar;?>" onClick="submit_page(this.form)">&nbsp;<input name="canc" onclick="document.location='registromedios1.php';" type="button" class="btn" value="<?php echo $btcancelar;?>" /></td>
						<td width="178" align="left" colspan="2">&nbsp;</td>
					</tr><?php } ?>
				</table>				
</form>
</fieldset><br><?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
