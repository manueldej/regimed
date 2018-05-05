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
@session_start(); 
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}

	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');} ?>
	<link href="css/template.css" rel="stylesheet" type="text/css" /><?php
include ('connections/miConex.php');
	$query = "SELECT * FROM conectado";
	$lista = mysqli_query($miConex, $query);
	$nnum = mysqli_num_rows($lista);
	$queryi = "SELECT * FROM conectado WHERE conectado ='invitado'";
	$listai = mysqli_query($miConex, $queryi);
	$nnumi = mysqli_num_rows($listai);

		if(($nnum) !=0){	
			$i=1;
			@header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
			@header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
			@header( "Cache-Control: no-cache, must-revalidate" ); 
			@header( "Pragma: no-cache" ); ?>
				<style type="text/css">
					.Estilo4 {color: #000000; font-weight: bold; }
				</style>
			<table width="100%" align="center" border='0' cellpadding="0" cellspacing="0" class="tablen">
				<tr class="vistauser1">
					<td align="center"><span class="Estilo4"><?php echo "<b>".$user_con.": </b><font color='red'>".$nnum."</font>&nbsp;&nbsp;(<b>".$Invitado."s: </b><font color='red'>".$nnumi."</font>)<br>";?></span></td>
				</tr><?php
			function getRealIP() {
				if (!empty($_SERVER['HTTP_CLIENT_IP']))
					return $_SERVER['HTTP_CLIENT_IP'];
			 
				if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
					return $_SERVER['HTTP_X_FORWARDED_FOR'];
			 
				return $_SERVER['REMOTE_ADDR'];
			}
			$p=0;
			while($row = mysqli_fetch_array($lista)){ $i++;
				if(($row['conectado']) !="invitado"){
					$vis = mysqli_query($miConex, "SELECT COUNT(user) as total FROM visitas WHERE user ='".$row['conectado']."'") or die(mysql_error());
					$resu = mysqli_fetch_array($vis);
					$us = mysqli_query($miConex, "select * from usuarios where login='".$row['conectado']."' AND idunidades='".$row['idunidades']."'") or die(mysql_error());
					$rus = mysqli_fetch_array($us);
					$nrus=mysqli_num_rows($us);
					if ($row['sexo']=="h"){
	                    $imge ="images/admin.png";
					}elseif ($row['sexo']=="m"){
                        $imge ="images/female.png";
					}else{
						$imge ="images/invitado.gif";
					}
					if(($rus['tipo']) =="root"){						 
						$imge ="images/male.png";
					}?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');">
						<td><a href="ej1.php?palabra=<?php echo $row['conectado'];?>" class="tooltip"><img align="absmiddle" src="<?php echo $imge;?>" style="cursor:pointer" width="16" height="16"/>&nbsp;<?php echo "<font color='red'><b>".$row['conectado']."</b></font>";?><span style="cursor:pointer" ><?php echo $rus['nombre'].$btRealizado1.$resu['total'].'&nbsp;'; if(($resu['total']) >1){ echo $btvisitas; }else{ echo $btvisita; } echo $btestesitio;?></span></a></td>
					</tr><?php	$p++;			
				}
			} 	
		}
?>