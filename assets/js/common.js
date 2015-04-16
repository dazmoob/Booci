var href = window.location.href;
var protocol = window.location.protocol;
var host = window.location.hostname;
var pathname = window.location.pathname;
var projectName = $('#project-name').data('name');

if (host.indexOf('dev') > -1 || host.indexOf('localhost') > -1) {
	
	domain = protocol + '://' + host + '/' + projectName + '/';
	project = '/booci';
	var i_check = 4;

} else {
	
	domain = protocol + '://' + host + '/';
	project = '';
	var i_check = 3;

}