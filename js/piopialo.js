// JavaScript Document
function oWDL (objeto) {
	window.open(objeto.attr('data-piolink'));
}
jQuery('[data-piolink]').click(function(event) {    
  oWDL(jQuery(this));
  event.preventDefault();
});

function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    return text;
}
jQuery(document).ready(function(e) {
    if ( ! (typeof activate_selector === 'undefined')) {
			 jQuery('[id*="post-"]').mouseup(function (e){
				 texto = getSelectionText();
				 if (texto!= '')
				{
					 creaPioton(e,texto);
				}
			});
			jQuery('[id*="post-"]').mousedown(function (e) {
					if (window.getSelection) {
					  if (window.getSelection().empty) {  // Chrome
						window.getSelection().empty();
					  } else if (window.getSelection().removeAllRanges) {  // Firefox
						window.getSelection().removeAllRanges();
					  }
					} else if (document.selection) {  // IE?
					  document.selection.empty();
					}
					pioboton = document.getElementById('pioton');
					if (pioboton) pioboton.remove();
			});
	}
});

function creaPioton(e,texto)
{
		var x = e.pageX + 'px';
        var y = e.pageY + 'px';
        var div = document.createElement('div');
		div.id = 'pioton';
		div.style.position = 'absolute';
		div.style.left = x;
		div.style.top = y;
        div.innerHTML = TuitLink(texto);
        document.body.appendChild(div);
}

function TuitLink(texto) {
	// vamos a contar los caracteres que nos quedan para la frase
	dispo = 140 - pioselector_via.length - 26;
	if (texto.length > dispo) 
	{
		texto = texto.substring(0,dispo-4) + '...';
	} 
	texto = '"' + texto + '" ' + pioselector_via + ' ' + window.location.href;
	link = '<a href="http://www.twitter.com/intent/tweet/?text=' + encodeURIComponent(texto) + '" target="_blank"><i class="fa fa-twitter"></i> ' + pioselector_llamada + '</a>';
	return link;
}

if ( 'true' == get_url_parameter( 'analycome' ) ) {
	if (typeof(ga) !== "undefined") {
		ga('send', 'event', 'User Interact', 'Comment sent', get_url_comment_id(), 1, {'nonInteraction': 1});
	}
    if (typeof(_gaq) !== "undefined") {
		_gaq.push(['_trackEvent', 'User Interact', 'Comment sent', get_url_comment_id(), 1, true]);
	}
}

function get_url_comment_id()
{
	var url = window.location + " ";
	var posicion = url.indexOf('#comment');
	var commentid = url.substring(posicion,url.length);
	return commentid;
}

function get_url_parameter( param_name ) {
	var page_url = window.location.search.substring(1);
	var url_variables = page_url.split('&');
	for ( var i = 0; i < url_variables.length; i++ ) {
			var curr_param_name = url_variables[i].split( '=' );
		if ( curr_param_name[0] == param_name ) {
			return curr_param_name[1];
		}
	}
}

