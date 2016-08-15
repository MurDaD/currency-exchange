var $_GET = getQueryParams(document.location.search);   // GET params
var t, tl;                                              // DataTable for main and inner, Latest DataTable
var socket;                                             // WebSocket instance
var maxLatest = 10;                                     // Number of max popular items
var _online = false;                                    // Online status
var innerPage = false;                                  // If it's inner page
var mainTableUpdatiable = true;                         // If false, Main table won't be updated
if($_GET['currency'] !== undefined) {                   // If we are on inner page
    innerPage = true;
    var bank = $_GET.currency.split('-')[0];            // Bank name
    var curr = $_GET.currency.split('-')[1];            // Currency name
}
var defaultLang = 'en';
var lang = ($_GET['lang'] === undefined) ? defaultLang : $_GET['lang'];

function getQueryParams(qs) {
    qs = qs.split("+").join(" ");
    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}