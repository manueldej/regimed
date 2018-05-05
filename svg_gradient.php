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

header('Content-Type: image/svg+xml');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

function get_color($get_name, $default)
{
    // get color from GET args, only alphanumeric chcracters
    $opts = array('options' => array('regexp' => '/^[a-z0-9]+$/i'));
    $color = filter_input(INPUT_GET, $get_name, FILTER_VALIDATE_REGEXP, $opts);
    if (preg_match('/^[a-f0-9]{6}$/', $color)) {
        return '#' . $color;
    }
    return $color ? $color : $default;
}
?>
<?php echo '<?xml Version="1.0" ?>' ?>
<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" Version="1.0" width="100%" height="100%">
    <defs>
        <linearGradient id="linear-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="<?php echo get_color('from', 'white') ?>" stop-opacity="1" />
            <stop offset="100%" stop-color="<?php echo get_color('to', 'black') ?>" stop-opacity="1" />
        </linearGradient>
    </defs>
    <rect width="100%" height="100%" style="fill:url(#linear-gradient);" />
</svg>
