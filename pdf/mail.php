<?php
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.0                                                     				                       #
# Fecha:    01/06/2016                                             					                       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
@session_start(); include('../chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="../index.php";</script><?php
	exit;
}
require('encriptar.php');
include('../connections/miConex.php');
if(isset($_GET['tb'])){$tb=$_GET['tb'];}
$Goto = $_GET['gt'];
if(isset($_GET['query'])){
	$kk = base64_decode($_GET['query']);
	$se =$kk;
	$seq = mysqli_query($miConex, $se) or die(mysql_error());
}
$tra="";

//funcion para reemplazar caracteres especiales
	function reemplaza11($tra1){
			$a = str_replace('&aacute;', chr(225), $tra1);
			$e = str_replace('&eacute;', chr(233), $a);
			$i = str_replace('&iacute;', chr(237), $e);
			$o = str_replace('&oacute;', chr(243), $i);
			$u = str_replace('&uacute;', chr(250), $o);
			$n = str_replace('&ntilde;', chr(241), $u);
			$A = str_replace('&Aacute;', chr(193), $n);
			$E = str_replace('&Eacute;', chr(201), $A);
			$I = str_replace('&Iacute;', chr(205), $E);
			$O = str_replace('&Oacute;', chr(211), $I);
			$U = str_replace('&Uacute;', chr(218), $O);
			$N = str_replace('&Ntilde;', chr(209), $U);
			$preg = str_replace('&iquest;', chr(447), $N);
			$guio1 = str_replace('&laquo;', chr(171), $preg);
			$guio2 = str_replace('&raquo;', chr(443), $guio1);
			$guio3 = str_replace('&iexcl;', chr(417), $guio2);
			$cop1 = str_replace('&copy;', chr(425), $guio3);
			$cop2 = str_replace('&Ouml;', chr(470), $cop1);
			$cop3 = str_replace('&ouml;', chr(246), $cop2);
			$cop4 = str_replace('&Uuml;', chr(276), $cop3);
			$cop5 = str_replace('&uuml;', chr(252), $cop4);
			$cop6 = str_replace('&reg;', chr(174), $cop5);
			$cop7 = str_replace('&amp;', chr(550), $cop6);
			$cop8 = str_replace('&lt;', chr(572), $cop7);
			$cop9 = str_replace('&gt;', chr(574), $cop8);
			$cop10 = str_replace('&plusmn;', chr(177), $cop9);
			$cop11 = str_replace('&nbsp;', ' ', $cop10);
			$cop15 = str_replace('&middot;', chr(45), $cop11);
			$preg1 = str_replace('&quot;', chr(290), $cop15);
			$finallx = trim($preg1);

		return $finallx;
	}
function reemplaza($tra){
$a = str_replace('&aacute;', 'á', $tra);
$e = str_replace('&eacute;', 'é', $a);
$i = str_replace('&iacute;', 'í', $e);
$o = str_replace('&oacute;', 'ó', $i);
$u = str_replace('&uacute;', 'ú', $o);
$n = str_replace('&ntilde;', 'ñ', $u);
$A = str_replace('&Aacute;', 'Á', $n);
$E = str_replace('&Eacute;', 'É', $A);
$I = str_replace('&Iacute;', 'Í', $E);
$O = str_replace('&Oacute;', 'Ó', $I);
$U = str_replace('&Uacute;', 'Ú', $O);
$N = str_replace('&Ntilde;', 'Ñ', $U);
$milla = str_replace('&ldquo;', '"', $N);
$milla1 = str_replace('&rdquo;', '"', $milla);
$preg = str_replace('&iquest;', '¿', $milla1);
$guio = str_replace('&ndash;', '-', $preg);
$guio1 = str_replace('&laquo;', '«', $guio);
$guio2 = str_replace('&raquo;', '»', $guio1);
$guio3 = str_replace('&iexcl;', '¡', $guio2);
$cop1 = str_replace('&copy;', '©', $guio3);
$cop2 = str_replace('&Ouml;', 'Ö', $cop1);
$cop3 = str_replace('&ouml;', 'ö', $cop2);
$cop4 = str_replace('&Uuml;', 'Ü', $cop3);
$cop5 = str_replace('&uuml;', 'ü', $cop4);
$cop6 = str_replace('&reg;', '®', $cop5);
$cop7 = str_replace('&amp;', '&', $cop6);
$cop8 = str_replace('&lt;', '<', $cop7);
$cop9 = str_replace('&gt;', '>', $cop8);
$cop10 = str_replace('&plusmn;', '±', $cop9);
$cop11 = str_replace('&nbsp;', ' ', $cop10);
$preg1 = str_replace('&quot;', '"', $cop11);

$fp = fopen("fichero.txt", "w");
     flock($fp, 2);
    if (!$fp){ exit; }
    fwrite($fp, $preg1);
    flock($fp, 3);
    fclose($fp);
}
$yy=0; 
	if(($tb) =="areas"){
		while($ser=mysqli_fetch_array($seq))    {
			@$tra .= $ser["nombre"].
				";".$ser["computadoras"].
				";".$ser["impresora"].
				";".$ser["ploter"].
				";".$ser["escanner"].
				";".$ser["monitor"].
				";".$ser["fotocopiadora"].
				";".$ser["camara"].
				";".$ser["memorias"].
				";".$ser["switch"].
				";".$ser["modem"].
				";".$ser["ups"].
				";".$ser["pinza"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="aft"){
		while($ser=mysqli_fetch_array($seq))    {
			@$tra .= $ser["inv"].
				";".$ser["descrip"].
				";".$ser["idarea"].
				";".$ser["marca"].
				";".$ser["custodio"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="mtto"){
		while($ser=mysqli_fetch_array($seq))    {
			$tra .= $ser["inv"].
				";".$ser["categ"].
				";".$ser["fecha"].
				";".$ser["idarea"].
				";".$ser["estado"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="mtto1"){
		while($ser=mysqli_fetch_array($seq))    {
			$tra .= $ser["inv"].
				";".$ser["categ"].
				";".$ser["fecha"].
				";".$ser["idarea"].
				";".$ser["estado"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="inci"){
		$bufergest = array();
		$gest = @fopen("../incidencias.irm", "r");
		while (!feof($gest)) {
			$bufergest[] = fgets($gest, 4096);
		}
		fclose ($gest);
		asort($bufergest); 	
		foreach ($bufergest as $key => $val) { 
			$explot = explode('*',$val);
			$seldg=mysqli_query($miConex, "select * from datos_generales where id_datos='".trim($explot[4])."'") or die(mysql_error());
			$redg = mysqli_fetch_array($seldg);	
			@$tra .= trim($explot[5]).
				";".trim($explot[1]).
				";".trim($explot[2]).
				";".trim($explot[3]).
				";".$redg['entidad'].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="traspasos"){
		while($ser=mysqli_fetch_array($seq))    {
			@$tra .= $ser["inv"].
				";".$ser["fecha"].
				";".$ser["origen"].
				";".$ser["destino"].
				";".$ser["motivo"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="plan_rep"){
		while($ser=mysqli_fetch_array($seq))    {
			@$tra .= $ser["inv"].
				";".$ser["fecha"].
				";".$ser["idarea"].
				";".$ser["observ"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="inspecciones"){
		while($ser=mysqli_fetch_array($seq))    {
			$seentid=mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$ser["idunidades"]."'") or die(mysql_error());
			$rseentid=mysqli_fetch_array($seentid);
			@$tra .= $ser["fecha"].
				";".$ser["estado"].
				";".$ser["observ"].
				";".$rseentid["entidad"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="tipos_medios"){
		if(isset($_GET['area']) AND ($_GET['area']) !=""){
			$idunidad=" AND id =".$_GET['area'];
		}
		if(isset($_GET['query'])){
			$kk = base64_decode($_GET['query']);
	
			if(stristr($kk,'kk') !=""){
				$se = str_ireplace('kk',$idunidad,$kk);
			}else{
				$se =$kk;
			}
			$seq = mysqli_query($miConex, $se) or die(mysql_error());
		}

		while($ser=mysqli_fetch_array($seq))    {
			@$tra .= $ser["nombre"].
				";".$ser["descripcion"].
				";".$ser["organo"].
				";".$ser["fecha"].";\r\n";
			$yy=$yy+1;
		}
	}
	if(($tb) =="usuarios"){
		if(isset($_GET['area']) AND ($_GET['area']) !=""){
			$idunidad=" AND id =".$_GET['area'];
		}
		if(isset($_GET['query'])){
			$kk = base64_decode($_GET['query']);
	
			if(stristr($kk,'kk') !=""){
				$se = str_ireplace('kk',$idunidad,$kk);
			}else{
				$se =$kk;
			}
			$seq = mysqli_query($miConex, $se) or die(mysql_error());
		}

		while($ser=mysqli_fetch_array($seq))    {
			@$tra .= $ser["login"].
				";".$ser["nombre"].
				";".$ser["cargo"].
				";".$ser["email"].
				";".$ser["idarea"].";\r\n";
			$yy=$yy+1;
		}
	}
	if (file_exists("fichero.txt")){
		@unlink("fichero.txt");
	}
	if (file_exists("fichero_2.txt")){
		@unlink("fichero_2.txt");
	}
reemplaza($tra);
/////////////

//CREAR PDF
require('fpdf.php');

class PDF extends FPDF{
	//Cargar los datos
	function LoadData($file)	{
		//Leer las líneas del fichero
		$lines=file($file);
		$data=array();
		foreach($lines as $line)
			$data[]=explode(';',chop($line));
		return $data;
	}
	function Header(){
		global $titlee;
		//Arial bold 15
		$this->SetFont('Arial','BI',12);
		//Calculamos ancho y posición del título.
		$this->SetX(0);
		//Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(128);
		//Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		//Título
		$this->SetLeftMargin(72);
		$qq = $this->Write(5,$titlee,'http://www.zeti.azcuba.cu'); 
		$this->MultiCell(0,2,$qq,'','','C');
		//Salto de línea
		$this->Ln(4);
		$this->SetLeftMargin(2);
		$this->Image('RegimedLogoVerticalBlack.png',5,5,10,10,'','http://www.zeti.azcuba.cu');
		$this->Ln(3);
	}
	//FOOTER
	function Footer(){
		global $pps;
		//Posición a 1,5 cm del final
		$this->SetY(-15);
		//Arial itálica 8
		$this->SetFont('Arial','I',7);
		//Color del texto en gris
		$this->SetTextColor(128);
		//Número de página y acento
		$pag = str_replace('&aacute;', 'á', $pps);
		$this->Cell(0,5,$pag.$this->PageNo(),0,0,'C');
		$this->Ln(0);
		$this->Cell(0,10,'E-Mail: manuel.jesus@zetifmf.azcuba.cu',0,0,'C');
	}
	function Chaptertitlee($label){
		//Arial 12
		$this->SetFont('Arial','',11);
		//Color de fondo
		$this->SetFillColor(200,220,255);
		//Título
		$this->Cell(0,6,$label,0,1,'L',1);
		//Salto de línea
		$this->Ln(4);
	}
	//Tabla coloreada
	function FancyTable($header,$data,$cabec,$tb)	{
		//Colores, ancho de línea y fuente en negrita
		$this->Chaptertitlee($cabec);
		$this->SetFont('Arial','',7);
		$this->SetFillColor(181,211,247);
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		
		if(($tb) =="areas"){
			//Cabecera
			$w=array(40,13,13,13,13,13,13,13,13,13,14,14,14);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Cell($w[5],3,$row[5],'LR',0,'L',$fill);
				$this->Cell($w[6],3,$row[6],'LR',0,'L',$fill);
				$this->Cell($w[7],3,$row[7],'LR',0,'L',$fill);
				$this->Cell($w[8],3,$row[8],'LR',0,'L',$fill);
				$this->Cell($w[9],3,$row[9],'LR',0,'L',$fill);
				$this->Cell($w[10],3,$row[10],'LR',0,'L',$fill);
				$this->Cell($w[11],3,$row[11],'LR',0,'L',$fill);
				$this->Cell($w[12],3,$row[12],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');
		}
		if(($tb) =="aft"){
			//Cabecera
			$w=array(26,50,50,25,45);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="mtto"){
			//Cabecera
			$w=array(26,35,20,50,30);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="mtto1"){
			//Cabecera
			$w=array(26,35,20,50,30);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="inci"){
			//Cabecera
			$w=array(18,15,50,60,58);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauraci?n de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="plan_rep"){
			//Cabecera
			$w=array(26,20,50,50);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="traspasos"){
			//Cabecera
			$w=array(26,20,40,40,45);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="inspecciones"){
			//Cabecera
			$w=array(26,20,40,40);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="tipos_medios"){
			//Cabecera
			$w=array(70);
			$this->Cell($w[0],3,$header[0],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');		
		}
		if(($tb) =="usuarios"){
			//Cabecera
			$w=array(15,50,40,50,50);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauraci?n de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			//Datos
			$fill=0;
			foreach($data as $row)	{
				$this->Cell($w[0],3,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],3,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],3,$row[2],'LR',0,'L',$fill);
				$this->Cell($w[3],3,$row[3],'LR',0,'L',$fill);
				$this->Cell($w[4],3,$row[4],'LR',0,'L',$fill);
				$this->Ln();
				$fill=!$fill;
			}
			$this->Cell(array_sum($w),0,'','T');					
		}
	}
}

$pdf=new PDF();
			$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('../esp.php');}else{ include('../eng.php');}
//Títulos de las columnas
	if(($tb) =="areas"){
		$header=array('ÁREA','COMPUT.','IMPRES.','PLOTER','SCAN.','MONIT.','FOTOCP.','CÁMARAS','FLASH','SWITCH','MODEM','UPS','PINZAS');
		$cabec = "Áreas de Responsabilidad";
	}
	if(($tb) =="aft"){
		$header=array('INV','DESCRIPCIÓN','ÁREA','MARCA','CUSTODIO');
		$cabec = "Listado de Medios (Resultado de la Búsqueda)";
	}
	if(($tb) =="mtto"){
		$header=array('INV','CATEGORÍA','FECHA','MARCA','ESTADO');
		$cabec = "Plan de Mantenimiento";
	}
	if(($tb) =="mtto1"){
		$header=array('INV','CATEGORÍA','FECHA','MARCA','ESTADO');
		$cabec = "Plan de Mantenimiento";
	}
	if(($tb) =="inci"){
		$header=array('INV',strtoupper($Fecha),reemplaza11($btAreas1),strtoupper($Incidencias),strtoupper($btdatosentidad3));
		$cabec = $bteditaunid0;
	}
	if(($tb) =="plan_rep"){
		$header=array('INV','FECHA','PERTENECE AL ÁREA','OBSERVACIONES');
		$cabec = "Plan de Reparaciones";
	}
	if(($tb) =="traspasos"){
		$header=array('INV','FECHA','ORIGEN','DESTINO','MOTIVO');
		$cabec = "Plan de Reparaciones";
	}
	if(($tb) =="inspecciones"){
		$header=array(strtoupper($Fecha),$btRESULTADOS,$btOBSERVACIONES,$btdatosentidad3);
		$cabec = "Plan de Reparaciones";
	}
	if(($tb) =="tipos_medios"){
		$header=array(reemplaza11('Categorias'));
		$cabec = "Categorias de Medios";
	}
	if(($tb) =="usuarios"){
		$header=array('LOGIN','NOMBRE','CARGO','EMAIL','AREA');
		$cabec = "Registro de Usuarios";
	}
	
//Carga de datos
$titlee="Registros de Medios Informaticos";
$nmbr = "MediosInformaticos";
$pps = 'Página ';
$data=$pdf->LoadData('fichero.txt');
$pdf->AddPage();
$pdf->FancyTable($header,$data,$cabec,$tb);
$pdf->Output($nmbr.'.pdf','');

///MENSAJE
$bHayFicheros = 0;
$sCabeceraTexto = "";
$sAdjuntos = "";
$cuerpo = "Adjunto enviamos datos de la Tabla: ".$tb."\n";
$se = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rse = mysqli_fetch_array($se);

		$destino = array($rse['email']) ;
		$asunto = $tb ;
		$sCabeceras = 'From: '.$rse['nombre'].' <'.$rse['email'].'>' ;
		$sCabeceras .= "MIME-version: 1.0\n";
		$sCabeceras .= "Content-type: multipart/mixed;";
		$sCabeceras .= "boundary=\"--_Separador-de-mensajes_--\"\n";
		
		$sCabeceraTexto = "----_Separador-de-mensajes_--\n";		
		$sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1\n";
		$sCabeceraTexto .= "Content-transfer-encoding: 7BIT\n";
		$sTexto = "\n\n----_Separador-de-mensajes_--\n";
		$sTexto .= $sCabeceraTexto;
		$sTexto .= "\n\n----_Separador-de-mensajes_--\n";
		if(($tb) =="inci"){
			$sTexto .="\n\n----Adjunto enviamos datos sobre las Incidencias.";
		}else{
			$sTexto .="\n\n----Adjunto enviamos datos de la Tabla: ".$tb;		
		}
		
		$sAdjuntos .= "\n\n----_Separador-de-mensajes_--\n";
		$sAdjuntos .= "Content-type: ".filetype($nmbr.".pdf").";name=\"".$nmbr.".pdf\"\n";;
		$sAdjuntos .= "Content-Transfer-Encoding: BASE64\n";
		$sAdjuntos .= "Content-disposition: attachment;filename=\"".$nmbr.".pdf\"\n\n";

		if(($tb) =="inspecciones"){
			while($ser=mysqli_fetch_array($seq))    {
				$seentid=mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$ser["idunidades"]."'") or die(mysql_error());
				$rseentid=mysqli_fetch_array($seentid);
				$oFichero1 = fopen("../inspecciones/".$ser["observ"], 'r');
				$sContenido1 = fread($oFichero, filesize("../inspecciones/".$ser["observ"]));
				$sAdjuntos1 .= chunk_split(base64_encode($sContenido1));
				fclose($oFichero1);
				$sTexto .= $sAdjuntos1;
				$sTexto .= "\n\n----_Separador-de-mensajes_--\n";
			}		
		}
		
		$oFichero = fopen($nmbr.".pdf", 'r');
		$sContenido = fread($oFichero, filesize($nmbr.".pdf"));
		$sAdjuntos .= chunk_split(base64_encode($sContenido));
		fclose($oFichero);
		$sTexto .= $sAdjuntos;
		$sTexto .= "\n\n----_Separador-de-mensajes_--\n";
		
		$destino = array($rse['email']) ;
		
			$cuta=0;
			for($r=0; $r<count($destino);$r++){
				if(mail($destino[$r], $tb, $sTexto, $sCabeceras)){
					$cuta++;
				}
			}
		if(($cuta) ==0)	{
			$msg = "El correo no ha sido enviado.Por favor, verifique su conexion...";  ?>
			<script language="javascript">
				alert('<?php echo $msg;?>');
				document.location="../<?php echo $Goto;?>.php";
			</script>	<?php 					
		}else{ ?>
		<script language="javascript">
			document.location="../<?php echo $Goto;?>.php";
		</script>	<?php 	
		}

?>
