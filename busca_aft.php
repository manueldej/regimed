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
?>
<?php
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
?>

<?php
@$palabra = @$_POST["palabra"];
$i=0;

if(is_numeric($_SESSION["registros"]))
    $registros = $_SESSION["registros"];
else
   $registros = 3;
session_destroy;

if(!isset($_GET['pagina'])) 
 { 
   $inicio = 0; 
   $pagina = 1; 
 } else 
    { 
	  $pagina=$_GET['pagina'];
	  $inicio = ($pagina - 1) * $registros; 
	}
include ('connections/miConex.php');

$resultados = mysqli_query("SELECT * FROM aft WHERE inv LIKE '%".$palabra."%' or estado LIKE '%".$palabra."%'
or descrip LIKE '%".$palabra."%' or idarea LIKE '%".$palabra."%' or categ LIKE '%".$palabra."%'or marca LIKE '%".$palabra."%'or modelo LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%'");
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

$sql="SELECT * FROM aft WHERE inv LIKE '%".$palabra."%' or estado LIKE '%".$palabra."%'
or descrip LIKE '%".$palabra."%' or idarea LIKE '%".$palabra."%' or categ LIKE '%".$palabra."%'or marca LIKE '%".$palabra."%'or modelo LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%'"; 

$result= mysqli_query($sql);

   
?>
<link href="template_css" rel="stylesheet" type="text/css">
<fieldset class="fieldset">
<table width="903" border="0" align="center">
  <tr>
    <td><form name="f" method="post" action="v4.php">
       <tr>
       <td colspan=4><p><b><?php      
	  
    echo "<TABLE BORDER='0' bordercolor=#AFCBCF class=sgf1 aling=center > \n"; 
    echo "<tr> \n";
	echo "<td><b></b></td> \n";
    echo "<td align=center><b><font color=black>INV</b></td> \n";
    echo "<td align=center><b><font color=black>DESCRIPCION</b></td> \n";
	echo "<td align=center><b><font color=black>ESTADO</b></td> \n";
	echo "<td align=center><b><font color=black>AREA</b></td> \n";
	echo "<td align=center><b><font color=black>SELLO</b></td> \n";
	echo "<td align=center><b><font color=black>MARCA</b></td> \n";
	echo "<td align=center><b><font color=black>SERIE</b></td> \n";
	echo "<td align=center><b><font color=black>MODELO</b></td> \n";
	echo "<td align=center><b><font color=black>TIPO</b></td> \n";
	echo "<td align=center><b><font color=black>CUSTODIO</b></td> \n";
	
    echo "</tr> \n"; 
	   
 
 while($row=mysqli_fetch_array($result))
    {
        echo "<tr>\n";
        $i++;
        $nombre="n".$i;
		
?>

        </p>
       <td><?php  
		echo "<td class=Estilo2>".$row["inv"]."</td> \n";
		echo "<td class=Estilo2>".$row["descrip"]."</td> \n";
        echo "<td class=Estilo2>".$row["estado"]. "</td> \n";
		echo "<td class=Estilo2>".$row["idarea"]."</td> \n";
		echo "<td class=Estilo2>".$row["sello"]."</td> \n";
		echo "<td class=Estilo2>".$row["marca"]."</td> \n";
		echo "<td class=Estilo2>".$row["no_serie"]."</td> \n";
		echo "<td class=Estilo2>".$row["modelo"]."</td> \n";
		echo "<td class=Estilo2>".$row["tipo"]."</td> \n";
		echo "<td class=Estilo2>".$row["custodio"]."</td> \n";
		
    }

?>
<tr>
<input type='hidden' name="cant" size="4" value="<?php echo $i?>">
<input type='hidden' name="area" size="3" value="<?php echo $area;?>">
<td align=center><b>
<?php 
if($registros >= $total_registros)
    echo $i."/".$total_registros;
else
{
  if($pagina == 1)
  {
   if($i !=1)
     echo "1-".$i."/".$total_registros;
   else
     echo "1/".$total_registros;
  }
  else
  {
   if($i !=1)
    echo "<font color=black>".($inicio+1)."-".($inicio + $i)."/".$total_registros;
   else
    echo "<font color=black>".($inicio + 1)."/".$total_registros;
  }
}
?>
<td align=center>

<td align=center><br>
<td align=center><?php
echo "</table>";
echo "</table>";
echo "<table align=center ";
echo "<tr>";
echo "<td colspan=4>";
	
////////////////////////////////////////////////////////////////// 
if(($pagina - 1) > 0) 
 { 
   echo "<a href='$PHP_SELF?pagina=".($pagina-1)."'>< Anterior</a>"; 
 }

//////////////////////////////////////////////////////////////////
 for ($i=1; $i<=$total_paginas; $i++)
  
   if ($pagina == $i)
    {   
      echo "<b>Pagina(s):".$pagina."</b> "; 
    } 
	else 
	  { 
	     echo "<a href='$PHP_SELF?pagina=$i'>$i</a>";
	  }
///////////////////////////////////////////////////////////////////
if(($pagina + 1)<=$total_paginas) 
 { 
   echo "<a href='$PHP_SELF?pagina=".($pagina+1)."'>Siguiente ></a>"; 
 }
 ?>
</form></td>
  </tr>
</table>
  <br><hr width="70%" align="center">
<div class="contentpaneopen" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>

