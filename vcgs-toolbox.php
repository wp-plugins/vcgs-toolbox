<?php
/**
 * Plugin Name: Vcgs Toolbox
 * Plugin URI: http://www.vcgs.net/blog
 * Description: Toolbox with some awesome tools, shortcodes and configs from Victor Campuzano. Go to Settings->VCGS Toolbox for conig options and  more. Please, goto to <a href="http://www.vcgs.net/blog" target="_blank">vcgs.net/blog</a> for contact and more info.
 * Version: 0.6
 * Author: Víctor Campuzano (vcgs)
 * Author URI: http://www.vcgs.net/blog/
 * Config: Algo mas
 * Config URI: http://www.vcgs.net/
 * License: GPL2
 */
/*  Copyright 2014  VICTOR CAMPUZANO  (email : vcampuzano@vcgs.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Registramos la página de opciones
add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page() {
add_options_page('VCGS Toolbox by Víctor Campuzano', 'VCGS Toolbox', 'manage_options', 'vcgs_toolbox', 'f_vcgstoolbox_page');
}

function f_vcgstoolbox_page() {
?>

<div>
  <h2>Vcgs Toolbox - Pequeñas herramientas de la mano de Víctor Campuzano</h2>
  <p>Este es un sencillo plugin que incluye aquellas pequeñas herramientas creadas o recopiladas por <a href="http://www.vcgs.net/blog/" target="_blank"> Víctor Campuzano </a>.</p>
  <form action="options.php" method="post">
    <?php settings_fields('vcgstb_options'); ?>
    <?php do_settings_sections('vcgs_toolbox'); ?>
    <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button button-primary" />
  </form>
</div>
<?php
}

add_action('admin_init', 'plugin_admin_init');
function plugin_admin_init(){
	register_setting( 'vcgstb_options', 'vcgstb_options', 'vcgstb_validate_options' );
	add_settings_section('vcgstb_scrollytics', 'Relativos a Scrollytics', 'plugin_scrollytics_section_text', 'vcgs_toolbox');
	function plugin_scrollytics_section_text(){
?>
<p>Esta sección se refiere a incluir o no la Monitorización del Scroll de tus posts a través de Google Analytics. Puedes encontrar información detallada sobre esto en este post de mi blog: <a href="http://www.vcgs.net/blog/scrollytics-registrando-el-scroll-en-google-analytics/" target="_blank">Scrollytics</a>.</p>
<?php
	}

add_settings_field('sc_activate', 'Activar Scrollytics', 'sc_activate_f', 'vcgs_toolbox', 'vcgstb_scrollytics');
function sc_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="sc_activate" name="vcgstb_options[sc_activate]" value="1"' . checked( 1, $options['sc_activate'], false ) . '/>';
    $html .= '<label for="sc_activate">Activa esta casilla si quieres que se registre en Google Analytics el Scroll que hacen tus visitantes.</label>';
    echo $html;
}
add_settings_section('vcgstb_fontawesome', 'Relativo a Font Awesome', 'plugin_fontawesome_section_text', 'vcgs_toolbox');
	function plugin_fontawesome_section_text(){
?>
<p>Esta sección se refiere a incluir o no los scripts de Font Awesome que te permitirán usar la nomenclatura  para mostrar iconos de Font Awesome en tus posts. Puedes ver un vídeo y ejemplos en mi post: <a href="http://www.vcgs.net/blog/posticoning-mejorar-aspecto-posts-con-iconos/" target="_blank">Posticoning</a>..</p>
<?php
	}

add_settings_field('fa_activate', 'Activar Font Awesome', 'fa_activate_f', 'vcgs_toolbox', 'vcgstb_fontawesome');
function fa_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="fa_activate" name="vcgstb_options[fa_activate]" value="1"' . checked( 1, $options['fa_activate'], false ) . '/>';
    $html .= '<label for="fa_activate">Activa esta casilla si quieres que se incluya Font Awesome en tu blog.</label>';
    echo $html;
}
add_settings_field('sc_single', 'Sólo en Páginas/Posts', 'sc_single_f', 'vcgs_toolbox', 'vcgstb_scrollytics');
function sc_single_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="sc_single" name="vcgstb_options[sc_single]" value="1"' . checked( 1, $options['sc_single'], false ) . '/>';
    $html .= '<label for="sc_activate">Activa esta casilla si quieres que sólo se registre el scroll en posts y páginas. Desactívala para registrar también páginas de autor, etiquetas, categorías, etc...</label>';
    echo $html;
}

// Comenzamos con la sección se Settings para Piopialo
	add_settings_section('vcgstb_piopialo', 'Relativos al Shortcode Piopíalo', 'plugin_piopialo_section_text', 'vcgs_toolbox');
	function plugin_piopialo_section_text(){
?>
<p>Esta sección de la configuración se refiere a si incluir o no la función del <a href="http://www.vcgs.net/blog/piopialo-shortcode-para-tuitear-facilmente-frases-de-posts/" target="_blank">shortcode Piopialo</a>. Como puedes comprobar <a href="http://www.vcgs.net/blog/piopialo-shortcode-para-tuitear-facilmente-frases-de-posts/" target="_blank">en este post de mi blog</a>, el Piopialo es un shortcode que podrás usar para que tus lectores puedan fácilmente Tuitear frases destacadas de tus artículos..</p>
<p>El uso del piopialo es sencillo:</p>
<p>Encierra la frase que quieres que sea "piopiable" así: <code>[piopialo <opciones>]aquí la frase que quieres que sea clicable[/piopialo]</code>. Este sencillo código utilizará las opciones por defecto que puedes especificar aquí.</p>
<p>Además, para cada caso concreto (cada frase en concreto) puedes especifciar las opciones siguientes:</p>
<?php
	}

add_settings_field('pp_activate', 'Activar el Piopialo', 'pp_activate_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_activate" name="vcgstb_options[pp_activate]" value="1"' . checked( 1, $options['pp_activate'], false ) . '/>';
    $html .= '<label for="pp_activate">Activa esta casilla si quieres que se registre el shortcode piopialo para que puedas utilizarlo en tu blog.</label>';
    echo $html;
}
add_settings_field('pp_go', 'Links llegan a la Frase', 'pp_go_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_go_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_go" name="vcgstb_options[pp_go]" value="1"' . checked( 1, $options['pp_go'], false ) . '/>';
    $html .= '<label for="pp_go">Activa esta casilla si quieres que, por defecto, los links tuiteados lleven directamente al punto del post donde está la frase tuiteada. Este parámetro se puede sobre-escribir para cada caso concreto usando el parámetro <code>go="0"</code> (para desactivarlo) o <code>go="1"</code> (para activarlo). Si el valor es no, entonces los links llevan al principio del post.</label>';
    echo $html;
}
add_settings_field('pp_llamada', 'Texto de Llamada a la Acción', 'pp_llamada_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_llamada_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="text" id="pp_llamada" name="vcgstb_options[pp_llamada]" value="'.$options['pp_llamada'].'"/> P. Ej. piopialo';
    $html .= '<p><small>Lla llamada a la acción es el texto que aparecerá justo después de la frase a tuitear. Normalmente se usa piopialo, pero puedes escoger lo que queras. Este parámetro puedes especificarlo para cada frase usando el modificador <code>text="otra llamada"</code></small></p>';
    echo $html;
}

add_settings_field('pp_via', 'Texto de la Firma', 'pp_via_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_via_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="text" id="pp_via" name="vcgstb_options[pp_via]" value="'.$options['pp_via'].'"/> P. Ej. via @vcgs_net aqui:';
    $html .= '<p><small>La firma es el texto que aparecerá justo después de la frase y antes del link. Recuerda que debe ser lo más corto posible, pues los caracteres que uses en la firma no podrás usarlos en la frase. Este parámetro se puede sobreescribir para cada frase usando el modificador <code>via="firma"</code>.</small></p>';
    echo $html;
}

add_settings_field('pp_gplus', 'Activar Google Plus', 'pp_gplus_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_gplus_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_gplus" name="vcgstb_options[pp_gplus]" value="1"' . checked( 1, $options['pp_gplus'], false ) . '/>';
    $html .= '<label for="pp_gplus">¿Deseas añadir un icono para compartir en Google Plus?.</label><p><small>Si quieres, puedes añadir un botón para compartir en Google Plus. Puedes sobreescribir esta configuración añadiendo el parámetro <code>vcgplus="1"</code> o <code>vcgplus="0"</code>.</small></p>';
    echo $html;
}
add_settings_field('pp_facebook', 'Activar Facebook', 'pp_facebook_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_facebook_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_facebook" name="vcgstb_options[pp_facebook]" value="1"' . checked( 1, $options['pp_facebook'], false ) . '/>';
    $html .= '<label for="pp_facebook">¿Deseas añadir un icono para compartir en Facebook?.</label><p><small>Si quieres, puedes añadir un botón para compartir en Facebook. Puedes sobreescribir esta configuración añadiendo el parámetro <code>vcfacebook="1"</code> o <code>vcfacebook="0"</code>.</small></p>';
    echo $html;
}
add_settings_field('pp_linkedin', 'Activar LinkedIn', 'pp_linkedin_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_linkedin_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_linkedin" name="vcgstb_options[pp_linkedin]" value="1"' . checked( 1, $options['pp_linkedin'], false ) . '/>';
    $html .= '<label for="pp_linkedin">¿Deseas añadir un icono para compartir en LinkedIn?.</label><p><small>Si quieres, puedes añadir un botón para compartir en LinkedIn. Puedes sobreescribir esta configuración añadiendo el parámetro <code>vclinkedin="1"</code> o <code>vclinkedin="0"</code>.</small></p>';
    echo $html;
}


function vcgstb_validate_options($input) {
	if (!is_array($input) || !array_key_exists('sc_activate',$input))
	{
		$input['sc_activate'] = '0';
	}
	if (!is_array($input) || !array_key_exists('sc_single',$input))
	{
		$input['sc_single'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_activate',$input))
	{
		$input['pp_activate'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_gplus',$input))
	{
		$input['pp_gplus'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_go',$input))
	{
		$input['pp_go'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_facebook',$input))
	{
		$input['pp_facebook'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_linkedin',$input))
	{
		$input['pp_linkedin'] = '0';
	}
	if (!is_array($input) || !array_key_exists('fa_activate',$input))
	{
		$input['fa_activate'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_llamada',$input)){
		$input['pp_llamada'] = '';
	}
	if (!is_array($input) || !array_key_exists('pp_via',$input))
	{
		$input['pp_via'] = '';
	}
	return $input;
}

}

$options = get_option('vcgstb_options');

if ($options['sc_activate']=='1')
{
/**
 *    SCROLLDEPH BETA ---
 * Vamos a registrar los scripts necesarios para que funcione el scriptdeph
 */
 
 // Register Script

	function carga_scrolldeph() {
		if (is_single() || $options['sc_single'] == 0) {
			wp_register_script( 'scrolldepht', plugins_url( '/js/jquery.scrolldepth.min.js' , __FILE__ ), array( 'jquery' ), false, true );
			wp_enqueue_script( 'scrolldepht' );
		
		
			wp_register_script( 'initializescrolldepth', plugins_url( '/js/initialize-scrolldepth.js' , __FILE__ ), array( 'scrolldepht' ), false, true );
			wp_enqueue_script( 'initializescrolldepth' );
		}
	}
	
	// Hook into the 'wp_enqueue_scripts' action
	add_action( 'wp_enqueue_scripts', 'carga_scrolldeph' );
	
}

// Víctor Campuzano Piopialo ...
// Register Style
if ($options['fa_activate']==1)
{
function registra_fontawesome() {

	wp_register_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, false, 'all' );
	wp_enqueue_style( 'fontawesome' );

}
// Hook into the 'wp_enqueue_scripts' action
add_action( 'wp_enqueue_scripts', 'registra_fontawesome' );
}


if ($options['pp_activate']==1)
{
	
	function MiPiopialo($atts, $content = null) {
		
	$options = get_option('vcgstb_options');
	// Configuración por defecto - Edita estas variables si lo deseas
	$directoa = ($options['pp_go']=="1")?true:false; // Añade etiquetas para que los links te lleven directamente a la frase y no al principio del post
	$llamada = $options['pp_llamada']; // Texto de llamada a la acción, detrás del guión y antes del icono
	$ivia = $options['pp_via']; // Texto de firma / mención del Tuit
	$i_gplus = ($options['pp_gplus']=="1")?true:false; // Incluir por defecto el botón de Google Plus
	$i_facebook = ($options['pp_facebook']=="1")?true:false; // Incluir por defecto el botón de Facebook
	$i_linkedin = ($options['pp_linkedin']=="1")?true:false; // Incluir por defecto el botón de linkedin
	// -------------------------------------
	// Extraer y tratar los parámetros recibidos
	extract(shortcode_atts(array(  
        "go" => '1',
		 "text" => '',
		 "via" => '',
		 "vcgplus" => '',
		 "vcfacebook" => '',
		 "vclinkedin" => ''  
    ), $atts));
	if ($go != 1) $directoa = false;
	if ($text != '') $llamada = $text;
	if ($via != '') $ivia = $via;
	if($vcgplus!='') $i_gplus = true;
	if($vcfacebook!='') $i_facebook = true;
	if($vclinkedin!='') $i_linkedin = true;
	
	
	if ($content != null) {
		
		// Obtener un ID "Unico" para este piopis. Como no podemos controlarlo, al ser shortcode
		//   lo que finalmente he decidido es usar el primer caracteres. Así, puedes piopiar lo que quieras
		//   en un mismo post siempre que no coincida el primer caracter. mejoraré esta limitación ...
		if ($directoa) $tagid = 'piopialo-'.substr(preg_replace('/[^A-Za-z0-9]/', '',strip_tags($content)),0,1);
		
		// Obtener la URL codificada
		$miurl = urlencode(get_permalink($post->ID).'#'.$tagid);
		
		// Codificar el texto . Nos dejamos 94 caracteres en esta versión
		$texto = urlencode('"'.substr(strip_tags($content),0,116-strlen($ivia)).'" '.$ivia.' ');
		
		// Primero crear la etiqueta para enlazar directamente a este lugar
		$ancla = $directoa ? '<a name="'.$tagid.'" id="'.$tagid.'"></a>':'';
				
		$enlace = '<a target="_blank" class="piopialo" href="http://www.twitter.com/intent/tweet/?text='.$texto.'&url='.$miurl.'"  title="Piopialo Ahora"> - '.$llamada.' <i class="fa fa-twitter"></i></a>';
		
		if ($i_gplus)
		{
			$enlace .= '&nbsp;&nbsp;<a target="_blank" class="piogplus" href="https://plus.google.com/share?url='.$miurl.'" title="En Google Plus"><i class="fa fa-google-plus-square"></i>&nbsp;</a>';
		}
		
		if ($i_facebook)
		{
			$enlace .= '&nbsp;&nbsp;<a target="_blank" class="pioface" href="http://www.facebook.com/sharer/sharer.php?u='.$miurl.'" title="En Facebook"><i class="fa fa-facebook-square">&nbsp;</i></a>';
		}
		
		if ($i_linkedin)
		{
			$enlace .= '&nbsp;&nbsp;<a target="_blank" class="piolinked" href="http://www.linkedin.com/shareArticle?mini=true&url='.$miurl.'&title='.$texto.'" title="En Linkedin"><i class="fa fa-linkedin">&nbsp;</i></a>';
		}
		
		return $ancla.'<span class="piopialo">'.$content.'</span>'.$enlace;
		
	}
	
}
add_shortcode('piopialo', 'MiPiopialo');
}