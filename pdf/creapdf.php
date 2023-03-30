<?php
	function creapdf($seldo){
		require('encriptar.php');
		include('connections/miConex.php');		
		$seq = mysqli_query($miConex, $seldo) or die(mysql_error());
		
		//funcion para reemplazar caracteres especiales
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

		    $fp = fopen("RegistroBajasx.txt", "a+");
			flock($fp, 2);
			if (!$fp){ exit; }
			fwrite($fp, $preg1);
			flock($fp, 3);
			fclose($fp);
		
			$fd1 = @fopen ("RegistroBajasx.txt", "r");
			$contents1 = @fread ($fd1, filesize ("RegistroBajasx.txt"));
			@fclose ($fd1);			
			
			$fp1 = fopen("RegistroBajas.txt", "a+");
			flock($fp1, 2);
			if (!$fp1){ exit; }
			fwrite($fp1, $contents1);
			flock($fp1, 3);
			fclose($fp1);				
		}
				while($ser=mysqli_fetch_array($seq)) {
					@$tra .= $ser["inv"].
						";".$ser["descrip"].
						";".$ser["idarea"].
						";".$ser["organo"].
						";".$ser["titulo"].
						";".$ser["idunidades"].";\r\n";
				}
			
			
			
			if (file_exists("RegistroBajas.txt")){
				@unlink("RegistroBajas.txt");
			}

		reemplaza($tra);
		/////////////

		//CREAR PDF
		require('pdf/fpdf.php');

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
				$qq = $this->Write(5,$titlee,'http://zetifmf.azcuba.cu/regimed'); 
				$this->MultiCell(0,2,$qq,'','','C');
				//Salto de línea
				$this->Ln(4);
				$this->SetLeftMargin(2);
				$this->Image('pdf/Logo1.png',5,5,10,10,'','http://zetifmf.azcuba.cu/regimed');
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
				$this->Ln(4);
				$this->Cell(0,10,'E-Mail: cpollan@ahmzllo.granma.inf.cu',0,0,'C');
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
			function FancyTable($header,$data,$cabec)	{
				//Colores, ancho de línea y fuente en negrita
				$this->Chaptertitlee($cabec);
				$this->SetFont('Arial','',7);
				$this->SetFillColor(181,211,247);
				$this->SetTextColor(0,0,0);
				$this->SetDrawColor(128,0,0);
				$this->SetLineWidth(.3);
				$this->SetFont('','B');
				
					//Cabecera
					$w=array(10,45,30,35,50,20);
					for($i=0;$i<count($header);$i++){
						$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
					}
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
						$this->Ln();
						$fill=!$fill;
					}
					$this->Cell(array_sum($w),0,'','T');		
			}
		}

		$pdf=new PDF();
		//Títulos de las columnas
				$header=array('INV','DESCRIPCIÓN','ÁREA','ORGANO','TITULO','ENTIDAD');
				$cabec = "Listado de Medios que causaron Bajas";
					$i="es";
				if(isset($_COOKIE['seulang'])){
					if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
				}
				if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		//Carga de datos
		$titlee=$btversion2;
		$nmbr = "Medios Dictaminados";
		$pps = 'Página ';
		$data=$pdf->LoadData('RegistroBajas.txt');
		$pdf->AddPage();
		$pdf->FancyTable($header,$data,$cabec);
		$pdf->Output("dt/".$nmbr.'.pdf','');
	}
	
	function creapdfx($invx,$idareax,$fechax,$organox){
						$i="es";
				if(isset($_COOKIE['seulang'])){
					if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
				}
				if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		$tra = $invx.
			";".$idareax.
			";".$fechax.
			";".$organox.";\r\n";
			
			if (file_exists("RegistroBajasy1.txt")){
				unlink("RegistroBajasy.txt");
			}
			$fp = fopen("RegistroBajasy1.txt", "a+");
			flock($fp, 2);
			if (!$fp){ exit; }
			fwrite($fp, $tra);
			flock($fp, 3);
			fclose($fp);
		
			$fd1 = fopen ("RegistroBajasy1.txt", "r");
			$contents1 = fread ($fd1, filesize ("RegistroBajasy1.txt"));
			fclose ($fd1);			
			
			$fp1 = fopen("RegistroBajasy.txt", "a+");
			flock($fp1, 2);
			if (!$fp1){ exit; }
			fwrite($fp1, $contents1);
			flock($fp1, 3);
			fclose($fp1);

		//CREAR PDF
		require('pdf/fpdf.php');

		class PDF1 extends FPDF{
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
				$qq = $this->Write(5,$titlee,'http://zetifmf.azcuba.cu/regimed'); 
				$this->MultiCell(0,2,$qq,'','','C');
				//Salto de línea
				$this->Ln(4);
				$this->SetLeftMargin(2);
				$this->Image('pdf/Logo1.png',5,5,10,10,'','http://zetifmf.azcuba.cu/regimed');
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
				$this->Ln(4);
				$this->Cell(0,10,'E-Mail: carlos.pollan@gtm.jovenclub.cu',0,0,'C');
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
			function FancyTable($header,$data,$cabec)	{
				//Colores, ancho de línea y fuente en negrita
				$this->Chaptertitlee($cabec);
				$this->SetFont('Arial','',7);
				$this->SetFillColor(181,211,247);
				$this->SetTextColor(0,0,0);
				$this->SetDrawColor(128,0,0);
				$this->SetLineWidth(.3);
				$this->SetFont('','B');
				
					//Cabecera
					$w=array(18,50,30,60);
					for($i=0;$i<count($header);$i++){
						$this->Cell($w[$i],3,$header[$i],1,0,'C',1);
					}
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
		}

		$pdf1=new PDF1();
		//Títulos de las columnas
				$header=array('INV','ÁREA','FECHA','ORGANO');
				$cabec = "Certificaciones destino final de las Bajas";
					$i="es";
				if(isset($_COOKIE['seulang'])){
					if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
				}
				if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		//Carga de datos
		$titlee=$btversion2;
		$nmbr = "Destino de Medios";
		$pps = 'Página ';
		$data=$pdf1->LoadData('RegistroBajasy.txt');
		$pdf1->AddPage();
		$pdf1->FancyTable($header,$data,$cabec);
		$pdf1->Output("df/".$nmbr.'.pdf','');
	}
?>
