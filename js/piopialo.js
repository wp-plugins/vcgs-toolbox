// JavaScript Document
function oWDL (objeto) {
	window.open(objeto.attr('data-piolink'));
}
jQuery('[data-piolink]').click(function(event) {    
  oWDL(jQuery(this));
  event.preventDefault();
});