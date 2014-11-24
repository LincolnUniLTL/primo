primo
=====

Javascript and CSS used to customise our instance of Ex Libris Primo hosted at http://primo-direct-apac.hosted.exlibrisgroup.com/primo_library/libweb/action/search.do?vid=LIN

I haven't bothered uploading general branding customisations. But customisations that might generalise to other institutions are each in their own file.

Instructions for use:
---------------------

1. Javascript
 * Put in a javascript file on a server somewhere...
 * Add <script src="YOUR-URL-HERE.js" type="text/javascript"></script> to the very bottom of your Primo footer tile
 * Note the footer tile can be found at: Primo Back Office > Ongoing Configuration > Views Wizard > [select appropriate view and continue to...] > Tiles Configuration > Home Page > Static HTML
 * Any future changes to the javascript file will take effect immediately.

2. CSS modifying *primo_library_css.css*
 * Put in a css file on a server somewhere...
 * Add the url for this file to Primo Back Office > Advanced Config > Mapping Tables > CSS > [the skin used by your system]
 * Save and deploy all code and mapping tables.
 * Any future changes to the css file will require redeploying the code and mapping tables.

3. CSS modifying *otb_mashup.css*
 * Put in a css file on a server somewhere...
 * Download the skin from Alma > General configuration menu > Delivery System Skins > [name of skin] > Actions-Edit > Skin Zip File
 * Extract and open skin\branding_skin\css\mashup.css in a text file.
 * At the very very top, before any comments, add the line: @import url("YOUR-URL-HERE.css");
 * Save, rezip, and reupload to Alma.
 * Any future changes to the javascript file will take effect immediately.
