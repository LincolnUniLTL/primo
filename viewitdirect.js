/* Make your "View It" link go directly to the source instead of opening an embedded box.
   Essentially it copies the link from the title of the search result to the View It link.
   It doesn't actually suppress the opening of the embedded box, but by using the same window to go to the resource it has the same effect.
   See in action by searching  http://primo-direct-apac.hosted.exlibrisgroup.com/primo_library/libweb/action/search.do?vid=LIN and clicking "View Online" on any record. */

function getElementsByClass (string,containerId) {
  var classElements = new Array();
  ( containerId === undefined ) ? containerId = document : containerId = document.getElementById(containerId);
  var allElements = containerId.getElementsByTagName('*');
  for (var i = 0; i < allElements.length; i++) {
    var multiClass = allElements[i].className.split(' ');
    for (var j = 0; j < multiClass.length; j++)
      if (multiClass[j] === string)
        classElements[classElements.length] = allElements[i];
  }
  return classElements;
}

function viewOnlineHandler() {
	var theResult = this.parentNode.parentNode.parentNode.parentNode.parentNode;
	var theUrl = theResult.children[0].children[0].children[0].children[0].href;
	location.href = theUrl;
}

var results = getElementsByClass('EXLSummary');
for (i=1; i<results.length; i++) {
	if (results[i].children[0].children[0].children[0].children[0].href != null) {
		results[i].children[1].children[0].children[0].children[0].children[3].onclick = viewOnlineHandler;
	}
}