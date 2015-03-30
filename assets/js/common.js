var href = window.location.href;
var protocol = window.location.protocol;
var host = window.location.hostname;

if (host.indexOf('dev') > -1) {
	domain = protocol + '://' + host + '/booci/';
	project = '/booci/';
} else {
	domain = protocol + '://' + host + '/';
	project = '';
}