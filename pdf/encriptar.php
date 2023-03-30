<?php
//encriptar
class encriptar1 
{
	function encrip($encrip)
	{if (!is_null($encrip))
		{
		$a = str_replace('a', '&#97;', $encrip);
		$e = str_replace('b', '&#98;', $a);
		$i = str_replace('c', '&#99;', $e);
		$o = str_replace('d', '&#100;', $i);
		$u = str_replace('e', '&#101;', $o);
		$n = str_replace('f', '&#102;', $u);
		$A = str_replace('g', '&#103;', $n);
		$E = str_replace('h', '&#104;', $A);
		$I = str_replace('i', '&#105;', $E);
		$O = str_replace('j', '&#106;', $I);
		$U = str_replace('k', '&#107;', $O);
		$N = str_replace('l', '&#108;', $U);
		$milla = str_replace('m', '&#109;', $N);
		$milla1 = str_replace('n', '&#110;', $milla);
		$preg = str_replace('ñ', '&#164;', $milla1);
		$guio1 = str_replace('o', '&#111;', $preg);
		$guio2 = str_replace('p', '&#112;', $guio1);
		$guio3 = str_replace('q', '&#113;', $guio2);
		$cop1 = str_replace('r', '&#114;', $guio3);
		$cop2 = str_replace('s', '&#115;', $cop1);
		$cop3 = str_replace('t', '&#116;', $cop2);
		$cop4 = str_replace('u', '&#117;', $cop3);
		$cop5 = str_replace('v', '&#118;', $cop4);
		$cop6 = str_replace('w', '&#119;', $cop5);
		$cop8 = str_replace('x', '&#120;', $cop6);
		$cop9 = str_replace('y', '&#121;', $cop8);
		$cop10 = str_replace('z', '&#122;', $cop9);
		$cop11 = str_replace('@', '&#64;', $cop10);
		$cop12 = str_replace('.', '&#46;', $cop11);
		$cop13 = str_replace('_', '&#95;', $cop12);
		$finall = trim($cop13);
		return $finall;
		}else{return "";}
	}
}
//desencriptar
class encriptar2
{
	function encrip($encrip)
	{if (!is_null($encrip))
		{
		$a = str_replace('&#97;', 'a', $encrip);
		$e = str_replace('&#98;', 'b', $a);
		$i = str_replace('&#99;', 'c', $e);
		$o = str_replace('&#100;', 'd', $i);
		$u = str_replace('&#101;', 'e', $o);
		$n = str_replace('&#102;', 'f', $u);
		$A = str_replace('&#103;', 'g', $n);
		$E = str_replace('&#104;', 'h', $A);
		$I = str_replace('&#105;', 'i', $E);
		$O = str_replace('&#106;', 'j', $I);
		$U = str_replace('&#107;', 'k', $O);
		$N = str_replace('&#108;', 'l', $U);
		$milla = str_replace('&#109;', 'm', $N);
		$milla1 = str_replace('&#110;', 'n', $milla);
		$preg = str_replace('&#164;', 'ñ', $milla1);
		$guio1 = str_replace('&#111;', 'o', $preg);
		$guio2 = str_replace('&#112;', 'p', $guio1);
		$guio3 = str_replace('&#113;', 'q', $guio2);
		$cop1 = str_replace('&#114;', 'r', $guio3);
		$cop2 = str_replace('&#115;', 's', $cop1);
		$cop3 = str_replace('&#116;', 't', $cop2);
		$cop4 = str_replace('&#117;', 'u', $cop3);
		$cop5 = str_replace('&#118;', 'v', $cop4);
		$cop6 = str_replace('&#119;', 'w', $cop5);
		$cop8 = str_replace('&#120;', 'x', $cop6);
		$cop9 = str_replace('&#121;', 'y', $cop8);
		$cop10 = str_replace('&#122;', 'z', $cop9);
		$cop11 = str_replace('&#64;', '@', $cop10);
		$cop12 = str_replace('&#46;', '.', $cop11);
		$cop13 = str_replace('&#95;', '_', $cop12);
		$finall = trim($cop13);
		return $finall;
		}else{return "";}
	}
}
?>