// JavaScript Document

function rMidEnlace(categoria, accion, etiqueta) {
	if (typeof(ga) !== "undefined") {
		ga('send', 'event', categoria, accion, etiqueta, 1, {'nonInteraction': 1});
	}
    if (typeof(_gaq) !== "undefined") {
		_gaq.push(['_trackEvent', categoria, accion, etiqueta, 1, true]);
	}
}