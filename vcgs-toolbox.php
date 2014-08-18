<?php
/**
 * Plugin Name: Vcgs Toolbox
 * Plugin URI: http://www.vcgs.net/blog
 * Description: Toolbox with some awesome tools, shortcodes and configs from Victor Campuzano. Go to Settings->VCGS Toolbox for conig options and  more. Please, goto to <a href="http://www.vcgs.net/blog" target="_blank">vcgs.net/blog</a> for contact and more info.
 * Version: 1.2
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
add_settings_field('sc_single', 'Sólo en Páginas/Posts', 'sc_single_f', 'vcgs_toolbox', 'vcgstb_scrollytics');
function sc_single_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="sc_single" name="vcgstb_options[sc_single]" value="1"' . checked( 1, $options['sc_single'], false ) . '/>';
    $html .= '<label for="sc_activate">Activa esta casilla si quieres que sólo se registre el scroll en posts y páginas. Desactívala para registrar también páginas de autor, etiquetas, categorías, etc...</label>';
    echo $html;
}


// Comenzamos con la sección de Settings para Font Awesome
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

// Comenzamos con la sección de Settings para Bootstrap
add_settings_section('vcgstb_bootstrap', 'Relativo a BootStrap', 'plugin_bootstrap_section_text', 'vcgs_toolbox');
	function plugin_bootstrap_section_text(){
?>
<p>Esta sección se refiere a incluir o no los scripts de cabecera de Bootstrap para poder aprovechar todo su potencial dentro de nuestras páginas. Por poner un ejemplo, puedes ver cómo aprovecharlo en este post, utilizando la utilizadad Layoutit. <strong>¡Cuidado! -> Esta configuración puede provocar algun problema con tu Theme. Si, tras activarlo, observas resultados que no te cuadran, desactívalo enseguida.</strong></p>

<?php
	}

add_settings_field('bs_activate', 'Activar BootStrap', 'bs_activate_f', 'vcgs_toolbox', 'vcgstb_bootstrap');
function bs_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="bs_activate" name="vcgstb_options[bs_activate]" value="1"' . checked( 1, $options['bs_activate'], false ) . '/>';
    $html .= '<label for="bs_activate">Activa esta casilla si quieres que se incluya Bootstrap en tu blog.</label>';
    echo $html;
}

// Comenzamos con la sección de Settings para Piopialo
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

add_settings_field('pp_underlined', 'Subrayar Frase', 'pp_underlined_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_underlined_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_underlined" name="vcgstb_options[pp_underlined]" value="1"' . checked( 1, $options['pp_underlined'], false ) . '/>';
    $html .= '<label for="pp_underlined">¿Deseas que las frases aparezcan subrayadas? Aunque esta propiedad se puede establecer mediante CSS, si no quieres tocar la hoja de estilos de tu Theme, puedes marcar esta casilla y las frases aparecerán subrayadas.</p>';
    echo $html;
}

add_settings_field('pp_powered', 'Eliminar firma de Vcgs-Toolbox', 'pp_powered_f', 'vcgs_toolbox', 'vcgstb_piopialo');
function pp_powered_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="pp_powered" name="vcgstb_options[pp_powered]" value="1"' . checked( 1, $options['pp_powered'], false ) . '/>';
    $html .= '<label for="pp_powered">¿Eliminar la firma Powered By de debajo de las Cajas de Piopialo?.</label><p><small>En los piopialos que van encerrados en cajas, se añade por defecto un enlace hacia el plugin. Si quieres puedes eliminarlo aunque, si lo dejas, contribuirás a que el plugin se descargue por más gente y yo te lo agradeceré mucho.</small></p>';
    echo $html;
}

// Comenzamos con la sección de Settings para Midenlace Shortcode
add_settings_section('vcgstb_midenlace', 'Relativo a Midenlace', 'plugin_midenlace_section_text', 'vcgs_toolbox');
	function plugin_midenlace_section_text(){
?>
<p>Esta sección se refiere activar el Midenlalytics o, lo que es lo mismo, <b>un shortcode mara registrar clics a enlaces en google analytics</b>. Se usa colocando el shortcode <code>[midenlace categoria="categoria" etiqueta="etiqueta" accion="accion"]el código html del enlace[/midenlace]</code> para que el plugin registre los clics a ese enlace en Google Analytics como un evento. Puedes leer <a href="http://www.vcgs.net/blog/midenlalytics-mide-clics-enlaces-en-google-analytics" target="_blank">este post</a> para informarte mejor.</p>

<?php
	}

add_settings_field('me_activate', 'Activar Midenlace', 'me_activate_f', 'vcgs_toolbox', 'vcgstb_midenlace');
function me_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="me_activate" name="vcgstb_options[me_activate]" value="1"' . checked( 1, $options['me_activate'], false ) . '/>';
    $html .= '<label for="me_activate">Activa esta casilla si quieres activar el Shortcode Midenlace.</label>';
    echo $html;
}

// Comenzamos con la sección de Settings para la columna contadora de palabras
add_settings_section('vcgstb_cpalabras', 'Relativo al contador de Palabras', 'plugin_cpalabras_section_text', 'vcgs_toolbox');
	function plugin_cpalabras_section_text(){
?>
<p>Esta sección se refiere a si deseas activar la columna contadora de palabras en tu panel de adminsitración. Si lo activas, cuando vayas a Entradas, verás una columna que te dice cuántas palabras tiene cada post. Es ideal, por ejemplo, para comparar el número de comentarios con la longitud de los posts de un rápido vistazo. También te puede servir para ver la evolución que están teniendo tus posts.</p>

<?php
	}

add_settings_field('copa_activate', 'Activar el Contador de Palabras', 'copa_activate_f', 'vcgs_toolbox', 'vcgstb_cpalabras');
function copa_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="copa_activate" name="vcgstb_options[copa_activate]" value="1"' . checked( 1, $options['copa_activate'], false ) . '/>';
    $html .= '<label for="copa_activate">Activa esta casilla si quieres que aparezca la columna contadora de palabras.</label>';
    echo $html;
}

// Comenzamos con la sección de Settings para los comentarios sin responder
add_settings_section('vcgstb_sinrespuesta', 'Relativo a la funcionalidad de Comentarios Sin Responder', 'plugin_sinrespuesta_section_text', 'vcgs_toolbox');
	function plugin_sinrespuesta_section_text(){
?>
<p>Esta sección se refiere a si quieres activar la funcionalidad de <strong>comentarios pendientes de responder</strong>. Basado en el plugin original <a href="https://wordpress.org/plugins/comments-not-replied-to/" target="_blank">"Comments Not Replied To"</a> aunque con algunas mejoras, como que no muestre los pingbacks o que solo muestre los comentarios pendientes del último mes. <strong>Cuidado</strong>, no activar esta opción si tienes el plugin instalado y activado pues provocarás un conflicto.</p>
<p>Una vez activado, verás un filtro en la página de comentarios que te mostrará los comentarios pendientes de responder que tienes. Para mí es realmente útil.</p>

<?php
	}

add_settings_field('cope_activate', 'Activar la Funcionalidad de Comentarios Sin Respuesta', 'cope_activate_f', 'vcgs_toolbox', 'vcgstb_sinrespuesta');
function cope_activate_f() {
	$options = get_option( 'vcgstb_options' );
    $html = '<input type="checkbox" id="cope_activate" name="vcgstb_options[cope_activate]" value="1"' . checked( 1, $options['cope_activate'], false ) . '/>';
    $html .= '<label for="cope_activate">Activa esta casilla si quieres poder filtrar los comentarios que no has respondido aún.</label>';
    echo $html;
}


function vcgstb_validate_options($input) {
	if (!is_array($input) || !array_key_exists('sc_activate',$input))
	{
		$input['sc_activate'] = '0';
	}
	if (!is_array($input) || !array_key_exists('bs_activate',$input))
	{
		$input['bs_activate'] = '0';
	}
	if (!is_array($input) || !array_key_exists('me_activate',$input))
	{
		$input['me_activate'] = '0';
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
	if (!is_array($input) || !array_key_exists('pp_powered',$input))
	{
		$input['pp_powered'] = '0';
	}
	if (!is_array($input) || !array_key_exists('pp_underlined',$input))
	{
		$input['pp_underlined'] = '0';
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
	if (!is_array($input) || !array_key_exists('copa_activate',$input))
	{
		$input['copa_activate'] = '';
	}
	if (!is_array($input) || !array_key_exists('cope_activate',$input))
	{
		$input['cope_activate'] = '';
	}
	return $input;
}

}

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

	wp_register_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, false, 'all' );
	wp_enqueue_style( 'fontawesome' );

}
// Hook into the 'wp_enqueue_scripts' action
add_action( 'wp_enqueue_scripts', 'registra_fontawesome' );
}

// Ahora toca hablar del Bootstrap
if (is_page() && $options['bs_activate']==1)
{
	function registra_bootstrap() {
		wp_register_style('bootstrap_css','//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', false, false, 'all');
		wp_register_script( 'bootstrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array( 'jquery' ), false, false );
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_script('bootstrap_js');
	}
	add_action ('wp_enqueue_scripts','registra_bootstrap');
}

if ($options['pp_activate']==1)
{
	function add_piopialob_styles() {
		wp_register_style('piopialob_style', plugins_url('css/piopialob.css', __FILE__));
		wp_enqueue_style('piopialob_style');
	}
	add_action( 'wp_enqueue_scripts', 'add_piopialob_styles' ); 

	
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
	// -------------------------------------
	// Extraer y tratar los parámetros recibidos
	extract(shortcode_atts(array(  
        "go" => '1',
		 "text" => '',
		 "via" => '',
		 "vcgplus" => '',
		 "vcfacebook" => '',
		 "vclinkedin" => '',
		 "vcboxed" => ''  
    ), $atts));
	if ($go != 1) $directoa = false;
	if ($text != '') $llamada = $text;
	if ($via != '') $ivia = $via;
	if($vcgplus!='') $i_gplus = true;
	if($vcfacebook!='') $i_facebook = true;
	if($vclinkedin!='') $i_linkedin = true;
	if($vcboxed!='') $i_boxed = true;
	
	
	if ($content != null) {
		
		// Obtener un ID "Unico" para este piopis. Como no podemos controlarlo, al ser shortcode
		//   lo que finalmente he decidido es usar el primer caracteres. Así, puedes piopiar lo que quieras
		//   en un mismo post siempre que no coincida el primer caracter. mejoraré esta limitación ...
		if ($directoa) $tagid = '#piopialo-'.substr(preg_replace('/[^A-Za-z0-9]/', '',strip_tags($content)),0,1);
		
		// Obtener la URL codificada
		$miurl = urlencode(get_permalink($post->ID).$tagid);
		
		// Codificar el texto.
			$texto = urlencode('"'.substr(strip_tags($content),0,116-strlen($ivia)).'" '.$ivia.' ');
		
		// Primero crear la etiqueta para enlazar directamente a este lugar
		$ancla = $directoa ? '<a name="'.$tagid.'" id="'.$tagid.'"></a>':'';
		
		// Nuevo, si MideEnlace está activado, medimos el clic
		if ($options['me_activate'] == '1')
		{
			$onclick = ' onClick="javascript:rMidEnlace(\'piopialo\', \''.get_the_title().'\', \''.strip_tags($content).'\');" ';
		} else {
			$onclick = '';
		}
				
		$enlace = '<a'.$onclick.' target="_blank" class="piopialo" href="http://www.twitter.com/intent/tweet/?text='.$texto.'&url='.$miurl.'"  title="Piopialo Ahora"> - '.$llamada.' <i class="fa fa-twitter"></i></a>';
		
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
		
		if ($i_boxed) {
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
										<p><a href="https://wordpress.org/plugins/vcgs-toolbox/" target="_blank">Powered by Vcgs-Toolbox</a></p>
								</div>';
			}
			$returnval .= '</div>';
		} else {
			$subraya = ($underlined)?' style="text-decoration: underline;" ':'';
			$returnval = $ancla.'<span class="piopialo"'.$subraya.'>'.$content.'</span>'.$enlace;
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