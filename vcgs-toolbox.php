<?php
/**
 * Plugin Name: Vcgs Toolbox
 * Plugin URI: http://www.vcgs.net/blog
 * Description: La Caja de Herramientas de Víctor Campuzano. Un plugin construido por una comunidad con herramientas y funciones que te ayudarán a hacer más satisfactoria tu experiencia como Blogger. Por favor, visita <a href="http://www.vcgs.net/blog" target="_blank">vcgs.net/blog</a> para más información o contactar conmigo.
 * Version: 1.9.8
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

require_once(dirname(__FILE__).'/settings.php');
$options = get_option('vcgstb_options');

if ($options['copa_activate']=='1')
{
	include(dirname(__FILE__). '/columna-contapalabras.php');
}

if ($options['cope_activate']=='1')
{
	include(dirname(__FILE__). '/comentarios-pendientes.php');
}

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

	wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, false, 'all' );
	wp_enqueue_style( 'fontawesome' );

}
// Hook into the 'wp_enqueue_scripts' action
add_action( 'wp_enqueue_scripts', 'registra_fontawesome' );
}

// Ahora toca hablar del Bootstrap
if (is_page() && $options['bs_activate']==1)
{
	function registra_bootstrap() {
		wp_register_style('bootstrap_css','//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, false, 'all');
		wp_register_script( 'bootstrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array( 'jquery' ), false, false );
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_script('bootstrap_js');
	}
	add_action ('wp_enqueue_scripts','registra_bootstrap');
}

if ($options['pp_activate']==1)
{
	function add_piopialob_styles() {
		wp_register_style('piopialob_style', plugins_url('css/piopialob.css', __FILE__),false,'1.9.6.2');
		wp_enqueue_style('piopialob_style');
	}
	add_action( 'wp_enqueue_scripts', 'add_piopialob_styles' ); 
	
	function carga_piopialo() {
		wp_register_script( 'piopialo', plugins_url( '/js/piopialo.js' , __FILE__ ), array( 'jquery' ), '1.9.6.3', true );
		wp_enqueue_script( 'piopialo' );
	}
	
	// Hook into the 'wp_enqueue_scripts' action
	add_action( 'wp_enqueue_scripts', 'carga_piopialo' );

	
	function MiPiopialo($atts, $content = null) {
		
	$options = get_option('vcgstb_options');
	// Configuración por defecto - Edita estas variables si lo deseas
	$directoa = ($options['pp_go']=="1")?true:false; // Añade etiquetas para que los links te lleven directamente a la frase y no al principio del post
	$llamada = $options['pp_llamada']; // Texto de llamada a la acción, detrás del guión y antes del icono
	$ivia = $options['pp_via']; // Texto de firma / mención del Tuit
	$i_gplus = ($options['pp_gplus']=="1")?true:false; // Incluir por defecto el botón de Google Plus
	$i_facebook = ($options['pp_facebook']=="1")?true:false; // Incluir por defecto el botón de Facebook
	$i_linkedin = ($options['pp_linkedin']=="1")?true:false; // Incluir por defecto el botón de linkedin
	$i_boxed = false;
	$powered = ($options['pp_powered'] == "1")?false:true;
	$underlined = ($options['pp_underlined'] == "1")?true:false;
	$itheme = $options['pp_theme'];
	// -------------------------------------
	// Extraer y tratar los parámetros recibidos
	extract(shortcode_atts(array(  
        "go" => '1',
		 "text" => '',
		 "via" => '',
		 "vcgplus" => '',
		 "vcfacebook" => '',
		 "vclinkedin" => '',
		 "vcboxed" => '',
		 "theme" => ''  
    ), $atts));
	if ($go != 1) $directoa = false;
	if ($text != '') $llamada = $text;
	if ($via != '') $ivia = $via;
	if($vcgplus!='') $i_gplus = true;
	if($vcfacebook!='') $i_facebook = true;
	if($vclinkedin!='') $i_linkedin = true;
	if($vcboxed!='') $i_boxed = true;
	if ($theme != '') $itheme = $theme;
	
	
	if ($content != null) {
		
		// Necesitamos saber si esta llamada es para un feed y así cambiar la forma de publicar
		$esfeed = is_feed();
		
		// Si es para un feed, los iconos no salen así que la llamada debe ser al menos algo.
		if ( $llamada == '' && $esfeed ) { $llamada = ' piopialo '; }
		
		// Obtener un ID "Unico" para este piopis. Como no podemos controlarlo, al ser shortcode
		//   lo que finalmente he decidido es usar el primer caracteres. Así, puedes piopiar lo que quieras
		//   en un mismo post siempre que no coincida el primer caracter. mejoraré esta limitación ...
		if ($directoa) $tagid = '#piopialo-'.substr(preg_replace('/[^A-Za-z0-9]/', '',strip_tags($content)),0,4);
		
		// Obtener la URL codificada
		$miurl = urlencode(get_permalink($post->ID).$tagid);
		
		// Codificar el texto.
		$texto = urlencode('"'.substr(strip_tags($content),0,116-strlen($ivia)).'" '.$ivia.' ');
		
		// Primero crear la etiqueta para enlazar directamente a este lugar
		$ancla = $directoa ? '<a name="'.$tagid.'" id="'.$tagid.'"></a>':'';
		
		// Nuevo, si MideEnlace está activado, medimos el clic. Pero no si es feed, porque no tiene sentido... 
		if ($options['me_activate'] == '1' && !$esfeed)
		{
			$onclick = ' onClick="javascript:rMidEnlace(\'piopialo\', \''.get_the_title().'\', \''.strip_tags($content).'\');" ';
		} else {
			$onclick = '';
		}
		$solotuit = 'http://www.twitter.com/intent/tweet/?text='.$texto.'&url='.$miurl;
		$enlace = '<a'.$onclick.' rel="nofollow" target="_blank" class="piopialo" '.(($esfeed)?'href=':'data-piolink').'="'.$solotuit.'"  title="Piopialo Ahora"> - '.$llamada.' <i class="fa fa-twitter"></i></a>';
		
		if ($i_gplus && !$esfeed)
		{
			$enlace .= '&nbsp;&nbsp;<a target="_blank" class="piogplus" data-piolink="https://plus.google.com/share?url='.$miurl.'" title="En Google Plus"><i class="fa fa-google-plus-square"></i>&nbsp;</a>';
		}
		
		if ($i_facebook && !$esfeed)
		{
			$enlace .= '&nbsp;&nbsp;<a target="_blank" class="pioface" data-piolink="http://www.facebook.com/sharer/sharer.php?u='.$miurl.'" title="En Facebook"><i class="fa fa-facebook-square">&nbsp;</i></a>';
		}
		
		if ($i_linkedin && !$esfeed)
		{
			$enlace .= '&nbsp;&nbsp;<a target="_blank" class="piolinked" data-piolink="http://www.linkedin.com/shareArticle?mini=true&url='.$miurl.'&title='.$texto.'" title="En Linkedin"><i class="fa fa-linkedin">&nbsp;</i></a>';
		}
		
		if ($i_boxed && !$esfeed) {
			if ($itheme == 'original' || $itheme == '') 
			{
				$iconurl = plugins_url( 'img/pio-icon.png' , __FILE__ );
				$returnval = $ancla.'<div class="piopialob">
									<div class="piopialob-icon">
												<img src="'.$iconurl.'" width="60" />
									</div>
									<div class="piopialob-text">
												<span class="piopialob-frase">'.strip_tags($content).'</span><span class="piopialob-link">'.$enlace.'</span>
									</div>';
				if ($powered) {
					$returnval .= '<div class="piopialob-powered">
											<p><span class="powered-link" data-piolink="https://wordpress.org/plugins/vcgs-toolbox/">Powered by Vcgs-Toolbox</span></p>
									</div>';
				}
				$returnval .= '</div>';
			} elseif ($itheme == 'reducido') {
				$returnval = $ancla.'<div class="piopialobred">
									<div class="piopialobred-text">
												<span class="piopialobred-frase">'.strip_tags($content).'</span><span class="piopialobred-link">'.$enlace.'</span>
									</div>';
				if ($powered) {
					$returnval .= '<div class="piopialobred-powered">
											<p><span class="powered-link" data-piolink="https://wordpress.org/plugins/vcgs-toolbox/" >Powered by Vcgs-Toolbox</span></p>
									</div>';
				}
				$returnval .= '</div>';
			} elseif ($itheme == 'moderno') {
				$returnval = $ancla.'<div class="piopialobmod" data-piolink="'.$solotuit.'">
									<div class="piopialobmod-text">
												<span class="piopialobmod-frase">'.strip_tags($content).'</span><span class="piopialobmod-link">'.$enlace.'</span>
									</div></div>';
				if ($powered) {
					$returnval .= '<div class="piopialobmod-powered">
											<p><span class="powered-link" data-piolink="https://wordpress.org/plugins/vcgs-toolbox/">Powered by Vcgs-Toolbox</span></p>
									</div>';
				}
	//			$returnval .= '</div>';
			} elseif ($itheme == 'modernoGris') {
				$returnval = $ancla.'<div class="piopialobmodgris hvr-bounce-to-bottom" data-piolink="'.$solotuit.'">
									<div class="piopialobmodgris-text">
												<span class="piopialobmodgris-frase">'.strip_tags($content).'</span><span class="piopialobmodgris-link">'.$enlace.'</span>
									</div></div>';
				if ($powered) {
					$returnval .= '<div class="piopialobmodgris-powered">
											<p><span class="powered-link" data-piolink="https://wordpress.org/plugins/vcgs-toolbox/">Powered by Vcgs-Toolbox</span></p>
									</div>';
				}
	//			$returnval .= '</div>';
			}
		} else {
			$subraya = ($underlined)?' style="text-decoration: underline;" ':'';
			if($esfeed) {
				$returnval .= $ancla.'<a class="piopialo"'.$subraya.' href="'.$solotuit.'">'.$content.'</a>'.$enlace;
			} else {
				$returnval .= $ancla.'<span class="piopialo"'.$subraya.' data-piolink="'.$solotuit.'">'.$content.'</span>'.$enlace;
			}
		}
		return $returnval;	
	}
	
}
add_shortcode('piopialo', 'MiPiopialo');

// Registramos el botón del editor
add_action( 'init', 'vcgs_buttons' );
function vcgs_buttons() {
    add_filter( "mce_external_plugins", "wptuts_add_buttons" );
    add_filter( 'mce_buttons', 'wptuts_register_buttons' );
}
function wptuts_add_buttons( $plugin_array ) {
    $plugin_array['vcgs'] = plugins_url( '/js/pio-editor.js' , __FILE__ );
    return $plugin_array;
}
function wptuts_register_buttons( $buttons ) {
    array_push( $buttons, 'piopialo' );
	array_push($buttons,'piopialob'); 
    return $buttons;
}
//Fin de registrar Botón

// Compatibilidad con ClickToTweet
if ( ! class_exists( 'tm_clicktotweet' ) && $options["pp_ctt"] == 1 ) {
		add_filter('the_content', 'CTTreplace_tags',1);
		function CTTreplace_tags($content) {
					$content = preg_replace_callback("/\[tweet \"(.*?)\"]/i", 'CTTweet', $content);
					return $content;
		}
		
		function CTTweet($matches) {
			$text = $matches[1];
			return '[piopialo vcboxed="1"]'.$text.'[/piopialo]';
		}
}

if($options['pp_tco']=="1")
{
add_filter( 'comment_text', 'modificar_comentario');
function modificar_comentario( $text ){
	
	$options = get_option('vcgstb_options');
	$ivia = $options['pp_via']; // Texto de firma / mención del Tuit
	
	// Obtener el Usuario de Twitter del que comenta
	if( $commenttwitter = get_comment_meta( get_comment_ID(), 'twitter', true ) ) {
		$tuitear=urlencode('Me ha gustado el comentario de @'.esc_attr($commenttwitter).' en este post '.$ivia);
	}
	else { 
		$tuitear=urlencode('Me ha gustado este comentario en un post '.$ivia);
	}
	
	// Obtener la URL directa del comentario
	$url = urlencode(get_comment_link(get_comment_ID()));
	if (is_admin() || is_feed()) {
		$enlace = '<p><a class="piopialo-comment" href="http://www.twitter.com/intent/tweet/?text='.$tuitear.'&url='.$url.'"  title="Piopia este comentario"> - Tuitea este comentario <i class="fa fa-twitter"></i></a></p>';
	} else {
		$enlace = '<p><span class="piopialo-comment" data-piolink="http://www.twitter.com/intent/tweet/?text='.$tuitear.'&url='.$url.'"  title="Piopia este comentario"> - Tuitea este comentario <i class="fa fa-twitter"></i></span></p>';
	}
	
	return $text.$enlace;
}
}

// Selector de texto
if ( $options['pp_selector']=='1' && !is_admin()) {
	function selector_js() {
		$options = get_option('vcgstb_options');
    echo '<script type="text/javascript">
		var activate_selector = true;
		var pioselector_via = \''.$options['pp_via'].'\';
		var pioselector_llamada = \''.$options['pp_llamada'].'\';
		
	</script>';
	}
	// Add hook for front-end <head></head>
	add_action('wp_head', 'selector_js');
}

}


// Ahora comenzamos con el tema de midenlace
if ($options["me_activate"]=='1')
{
	// Register Script

	function carga_midenlace() {
		wp_register_script( 'midenlace', plugins_url( '/js/midenlace.js' , __FILE__ ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'midenlace' );
	}
	
	// Hook into the 'wp_enqueue_scripts' action
	add_action( 'wp_enqueue_scripts', 'carga_midenlace' );
	
	function MiMidenlace($atts, $content = null) {
		// Configuración por defecto - Edita estas variables si lo deseas
		$i_categoria = 'Midenlace';
		$i_accion = 'Clic en Enlace';
		$i_etiqueta = 'EtiquetaEvento';
		// -------------------------------------
		// Extraer y tratar los parámetros recibidos
		extract(shortcode_atts(array(  
			"categoria" => '',
			 "accion" => '',
			 "etiqueta" => ''
		), $atts));
		if ($categoria != '') $i_categoria = $categoria;
		if ($accion != '') $i_accion = $accion;
		if ($etiqueta != '') $i_etiqueta = $etiqueta;	
		
		if ($content != null) {	
			$evento = '<a onClick="javascript:rMidEnlace(\''.$i_categoria.'\', \''.$i_accion.'\', \''.$i_etiqueta.'\');"  ';
			$devolver = str_replace('<a ', $evento,$content);
			return $devolver;
		}
}
add_shortcode('midenlace', 'MiMidenlace');	
}

// Esto es para el featured image

if ($options['feati_activate']=='1') {
	function vc_add_featured_image_to_feed($content) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ){
			$content = '' . get_the_post_thumbnail( $post->ID, 'large' ) . '' . $content;
		}
		return $content;
	}

	add_filter('the_excerpt_rss', 'vc_add_featured_image_to_feed', 1000, 1);
	add_filter('the_content_feed', 'vc_add_featured_image_to_feed', 1000, 1);
}

if ($options['analycome'] == '1') {
	add_filter('comment_post_redirect', 'redirect_after_comment');
	function redirect_after_comment($location)
	{
		global $wpdb;
		$newurl = $location;
		$newurl = substr( $location, 0, strpos( $location, '#comment' ) );
		$commentlink = substr($location, strpos($location,'#comment'),strlen($location)-1);
		$delimeter = false === strpos( $location, '?' ) ? '?' : '&';
		$params = 'analycome=true';

		$newurl .= $delimeter . $params;
		$newurl .= $commentlink;
		return $newurl;
	}
}
if($options['textareafirst'] == '1') {
	// We use just one function for both jobs.
	add_filter( 'comment_form_defaults', 'vcgstb_move_textarea' );
	add_action( 'comment_form_top', 'vcgstb_move_textarea' );
	
	function vcgstb_move_textarea( $input = array () )
	{
		static $textarea = '';

		if ( 'comment_form_defaults' === current_filter() )
		{
			// Copy the field to our internal variable …
			$textarea = $input['comment_field'];
			// … and remove it from the defaults array.
			$input['comment_field'] = '';
			return $input;
		}

		print apply_filters( 'comment_form_field_comment', $textarea );
	}
	
}
