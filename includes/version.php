<?php
/***********************************************************************************************************
* Software: Regimed                                                                                                        * 
* (Registro de Medios Informáticos)     					                                		                  *
* Version:  2.0.2                                                     				                                          *
* Fecha:    01/06/2013                                             					                                      *
* Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			                  *
*          	     Msc. Carlos Pollan Estrada											         		                  *
* Licencia: Freeware                                                				                                          *
*                                                                       			                                                  *
* Usted puede usar y modificar este software si asi lo desee, pero debe mencional la fuente  *
***********************************************************************************************************/

// Impedir accesso a páginas del sitio. 
defined( '_VALID_MOS' ) or die( 'Acceso Restringido' );

/**
 * Datos de la Version.
 * @package RegiMed 
 */
class seguVersion {
	var $PRODUCT 	= 'RegiMed';
	var $RELEASE 	= '3.1';
	var $DEV_STATUS = 'Stable';
	var $DEV_LEVEL 	= '1';
	var $BUILD	 	= '$Revision: 6086 $';
	var $CODENAME 	= 'GitHub';
	var $RELDATE 	= 'Ene, 01 de 2023';
	var $RELTZ 		= 'UTC';
	var $COPYRIGHT 	= "Copyright(C) 2013 - 2023. Todos los Derechos Reservados.";
	var $URL 		= '<a href="http://localhost/seguridad/">RegiMed!</a> es Software Libre distribuido bajo licencia GNU/GPL.';
	var $SITE 		= 1;
	var $RESTRICT	= 0;
	var $SVN		= 0;


	function getLongVersion() {
		return $this->PRODUCT .' '. $this->RELEASE .'.'. $this->DEV_LEVEL .' '
			. $this->DEV_STATUS
			.' [ '.$this->CODENAME .' ] '. $this->RELDATE .' '
			. $this->RELTIME .' '. $this->RELTZ;
	}

	function getShortVersion() {
		return $this->RELEASE .'.'. $this->DEV_LEVEL;
	}

	function getHelpVersion() {
		if ($this->RELEASE > '1.0') {
			return '.' . str_replace( '.', '', $this->RELEASE );
		} else {
			return '';
		}
	}
}
$_VERSION = new seguVersion();

$version = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '
. $_VERSION->DEV_STATUS
.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE;
?>