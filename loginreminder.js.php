/* Add a dismissable login reminder to the top of the page.
   Doesn't appear if the user is logged in already or is on campus as you define in line 69: $campusIP = array();
   In case you have policies about cookies: the 'dismissable' part of it involves setting a cookie called 'primo_login_reminder'.
   Needs styling in your css for div#loginCloser and div#loginNote - float them both left for starters.
   See in action at http://primo-direct-apac.hosted.exlibrisgroup.com/primo_library/libweb/action/search.do?vid=LIN */

var loginNoteText = "Sign in for more results and other services";
var dismissImage = "http://library2.lincoln.ac.nz/librarysearch/images/x-button.png";
var daysToReappear = "30";		// leave as "" if you don't want the message to ever reappear after the user dismisses it
var guestName = "Guest";		// the username Primo displays when the user is not logged in

if (!String.prototype.trim) {
	String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g,'');
	}
}

function setCookie(name, value, days_to_expire, path, domain, secure) {
	var today = new Date();
	today.setTime(today.getTime());
	if (days_to_expire) {
		days_to_expire = days_to_expire * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date(today.getTime() + (days_to_expire));
	document.cookie = name + "=" + escape(value) +
	( (days_to_expire) ? ";expires=" + expires_date.toGMTString() : "" ) +
	( (path) ? ";path=" + path : "" ) +
	( (domain) ? ";domain=" + domain : "" ) +
	( (secure) ? ";secure" : "" );
}

function getCookie(check_name) {
	var a_all_cookies = document.cookie.split(';');
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false;
	for (i = 0; i < a_all_cookies.length; i++) {
		a_temp_cookie = a_all_cookies[i].split( '=' );
		cookie_name = a_temp_cookie[0].trim();
		if (cookie_name == check_name) {
			b_cookie_found = true;
			if (a_temp_cookie.length > 1) {
				cookie_value = unescape(a_temp_cookie[1].trim());
			}
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if (!b_cookie_found) {
		return null;
	}
}

function deleteCookie(name, path, domain) {
	if (getCookie(name)) document.cookie = name + "=" +
	( (path) ? ";path=" + path : "") +
	( (domain) ? ";domain=" + domain : "" ) +
	";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

var username = getElementsByClass("EXLUserNameDisplay", "exlidUserName")[0].innerHTML.trim();
var loggedin = (username===guestName)?false:true;
var oncampus = <?php 
	$oncampus = 0;
	$userIP = $_SERVER['REMOTE_ADDR']; 
	$campusIP = array(); // Array of regular expressions for IP addresses to include as "on campus" - eg array('/^103\.240\.5[2-5]/', '/^10\./')
	foreach($campusIP as $ip) {
		if (preg_match($ip,$userIP)) {
			$oncampus = 1;
			break;
		}
	}
	echo $oncampus;
?>;

if ((!loggedin && !oncampus) && (getCookie('librarysearch_login_reminder')!="nothanks")){
	var loginPlace = document.getElementById("exlidUserAreaTile");
	var loginCloser = document.createElement("div");
	loginCloser.id = "loginCloser";
	var hideLength = (daysToReappear!="")?" for "+daysToReappear+" days":"";
	loginCloser.innerHTML = "<img src='"+dismissImage+"' alt='[Hide"+hideLength+"]' title='[Hide"+hideLength+"]' />&nbsp;";
	loginCloser.onclick = removeLoginNote;
	loginPlace.parentNode.insertBefore(loginCloser,loginPlace);

	var loginNote = document.createElement("div");
	loginNote.id = "loginNote";
	loginNote.innerHTML = loginNoteText + "&nbsp;&rarr;";
	loginPlace.parentNode.insertBefore(loginNote,loginPlace);
}

function removeLoginNote() {
	var loginNote = document.getElementById('loginNote');
	var loginCloser = document.getElementById('loginCloser');
	if (loginNote) {
		loginNote.parentNode.removeChild(loginNote);
		loginCloser.parentNode.removeChild(loginCloser);
		setCookie('primo_login_reminder', 'nothanks', daysToReappear, '/', '', '');
	}
}