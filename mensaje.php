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
?>
<?php
function show_message($Titulo,$Mensaje,$Imagen,$atras){
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		echo "<link href='css/template.css' rel='stylesheet' type='text/css'>"; ?>
		<div  class='message'>
			<table width='60%'  align='center' ><tr><td>
				<table width='100%' height='76' border='0' align='center' cellpadding='0' cellspacing='0'>
				  <tr>
					<td colspan='4'><div align=center><font size=4><strong><?php echo $Titulo;?></strong></font></div></td>
				  </tr>
				  <tr>
					<td width='25%' align='center' valign='middle'><label><img src='images/<?php echo $Imagen;?>.png' width='32' height='32'></label>				</td>
					<td colspan='3' class='quote'><div align='justify'><?php echo $Mensaje;?></div></td>
				  </tr>
				  <tr>
					<td align=right>&nbsp;</td>
					<td width='36%' align=right>&nbsp;</td>
					<td align=right><span onmouseover="this.style.cursor='pointer';" class='btn' onclick="document.location='<?php echo $atras;?>';"><?php echo $btaceptar;?></span></td>
					<td width='8%'>&nbsp;&nbsp;</td>
				  </tr>
				</table></td></tr>
			</table>		
		</div><?php 
	}
function show_message1($Titulo,$Mensaje,$Imagen,$atras){
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		echo "<link href='css/template.css' rel='stylesheet' type='text/css'>
		<table width='54%' border='0' align='center' cellpadding='3' cellspacing='3' class='message' bgcolor='#F9FDF0'>
		<tr align='center' valign='middle'>
		<td height='82' bgcolor='#F7F7F7'>
		<table width='100%' height='76' border='0' align='center' cellpadding='0' cellspacing='0'>
		<tr bgcolor='#B5B2B5'>
		<td colspan='5'>
		<div align=center><font size=4><strong>". $Titulo."</strong></font></div>		</td>
		</tr>
		<tr>
		<td width='28%' align='center' valign='middle'> 
		<label><img src='images/".$Imagen.".png' width='32' height='32'></label>		</td>
		<td colspan='3' class='quote'> 
		  <div align='justify'>".$Mensaje."</div></td>
		</tr>
		
		<tr>
		<td align=right>&nbsp;</td>
		<td width='33%' align=right>&nbsp;</td>
		<td width='7%' align=right>&nbsp;</td>
		<td width='31%' align='center'>
		<script type='text/javascript'>function vete() { window.parent.location='".$atras."'; }</script>
		<input class='btn' type='button' name='Submit' value='$btaceptar' onclick='vete();';>
		 </form>		  </td> 
				  <td width='1%'>&nbsp;&nbsp;</td>
		  </tr>
		  </table>
		  </td>
  </tr>
		</table>
		";  
	}
	function show_messagex($Titulo,$Mensaje,$Imagen,$atras,$tb,$fichero,$trunca){
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		echo "<link href='css/template.css' rel='stylesheet' type='text/css'>"; ?>
		<form name="form1" method="post" action="<?php echo $atras;?>"><br>
			<table width='54%' border='0' align='center' cellpadding='3' cellspacing='3'>
				<tr align='center' valign='middle'>
					<td height='82'><div class="message">
					<table width='100%' height='76' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					<td colspan='3'>
					<div align=center><font size=4><strong><?php echo $Titulo;?></strong></font></div>		</td>
					</tr>
					<tr>
					<td width='28%' align='center' valign='middle'> 
					<label><img src='images/<?php echo $Imagen;?>.png' width='32' height='32'></label>		</td>
					<td class='quote'> 
					  <div align='justify'><?php echo $Mensaje;?></div></td>
					</tr>
					
					<tr>
					<td align=right>&nbsp;</td>
					<td align=right>
					  <input class='btn' type="button" onclick="document.location='restaura.php';" value="<?php echo $btcancelar;?>">
					  &nbsp;
					  <input class='btn' type="submit" value="<?php echo $btaceptar;?>">
					  <input name='marcado' type="hidden" value="<?php echo $fichero;?>">					</td>
					<td width='1%'><input name="mens" type="hidden"><input name="tb" type="hidden" value="<?php echo $tb;?>"><input name="trunca" type="hidden" value="<?php echo $trunca;?>">		</td>
					  </tr>
					  </table></div>
				  </td>
			  </tr>
			  </table></form><?php  
	}
?>