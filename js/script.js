$(document).ready(function(){

    /* Detect user language
        1. Check if user was using a website before
        2. Check browser default language
        3. English is default language
     */
    if($_GET['lang'] !== undefined) {
        saveLang($_GET['lang']);
    } else {
        if ($.cookie('lang')) {
            changeLang($.cookie('lang'));
        } else {
            $.browserLanguage(function (language) {
                changeLang(language);
            });
        }
    }

    // Add title to inner page
    if(innerPage) {
        $("h3.title").html(bank + " - " + curr);
        saveLatestCurrency(bank, curr);
    }

    var langs = {
        'ru': "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json",
        'en': "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json",
        'uk': "//cdn.datatables.net/plug-ins/1.10.12/i18n/Ukrainian.json",
    };
    var tableDefaults = {
        "language": {
            "url": langs[lang]
        },
        //"bFilter":   false,           // Disables all the search API
        paging: false,
        columnDefs: [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ]
    };
    t = $('table.main, table.inner').DataTable(tableDefaults);
    tl = $('table.popular').DataTable(tableDefaults);
    if($("table.main").length > 0) {
        localforage.getItem('currencies').then(function (value) {
            updateTable(value);
        }).catch(function (err) {
            console.log(err);
        });
    }
    socketFunc();

    $.datetimepicker.setLocale(lang);
    $('#datetimepicker1').datetimepicker({
        format:'Y-m-d H:i',
    });
    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d H:i',
    });

    $(document).on("click", ".filterDates", function(e){
        var from = $("#datetimepicker1").val();
        var to = $("#datetimepicker2").val();
        console.log(from + " - " + to);
        if(from != '' || to != '') {
            console.log("filtering....")
            socket.send('{"$type": "getInterval","from": "' + from + '", "to": "' + to + '"}');
        }
    });
    $(document).on("click", ".clearFilter", function(e){
        $("#datetimepicker1").val('');
        $("#datetimepicker2").val('');
        mainTableUpdatiable = true;
        localforage.getItem('currencies').then(function (value) {
            updateTable(value);
        }).catch(function (err) {
            console.log(err);
        });
    });
    $(document).on("click", "table.list tbody tr", function(e){
        e.preventDefault();
        $(this).addClass("selected");
        var bank = t.cell(".selected", 1).data();
        var currency = t.cell(".selected", 2).data();
        if($_GET.lang !== undefined) {
            document.location.href = document.location.href + '&currency=' + bank + '-' + currency;
        } else {
            document.location.href = '?currency=' + bank + '-' + currency;
        }
    });
    $(document).on("click", ".change-lang a", function(e){
        e.preventDefault();
        changeLang($(this).data("name"));
    });
});

/**
 * Saves language to user cookie
 * @param lang
 */
function saveLang(lang) {
    $.cookie('lang', lang, { expires: 30 });
}

/**
 * Changes current language
 * @param lang
 */
function changeLang(lang) {
    saveLang(lang);
    if($_GET['lang'] != lang) {
        document.location.href = '?lang=' + lang;
    }
}

/**
 * Updated all tables via new data from socket
 * @param currencies
 */
function updateTable(currencies, interval) {
    console.log('table updated');
    if(!innerPage && interval === undefined) {
        if(mainTableUpdatiable)
            t.clear();
        updatePopular(currencies);
    }
    if(interval)
        t.clear();
    for (var i in currencies) {
        if(!innerPage) {
            if(mainTableUpdatiable || interval) {
                t.row.add([
                    currencies[i].id,
                    currencies[i].bank,
                    currencies[i].currency,
                    currencies[i].sell,
                    currencies[i].buy,
                    currencies[i].added,
                ]);
            }
        } else {
            t.row.add([
                currencies[i].id,
                currencies[i].sell,
                currencies[i].buy,
                currencies[i].added,
            ]).order( [ 3, 'desc' ] );
        }
    }
    if(!innerPage) {
        $('table.main .filter').empty();
        t.columns([1,2]).every( tableFilter );
    }
    t.draw(false);
}

function updatePopular(currencies) {
    tl.clear();
    localforage.getItem('latestCurrencies').then(function (value) {
        for (var i in value) {
            var currency = findCurrency(value[i].bank, value[i].currency, currencies);
            if($.isPlainObject(currency)) {
                tl.row.add([
                    i,
                    currency.bank,
                    currency.currency,
                    currency.sell,
                    currency.buy,
                    currency.added,
                ]);
            }
        }
        $('table.popular .filter').empty();
        tl.columns([1,2]).every( tableFilter );
        tl.draw(false);
    }).catch(function (err) {
        console.log(err);
    });

}

/**
 * Find currency object in resul array
 * @param bank
 * @param currency
 * @param currencies
 * @returns {*}
 */
function findCurrency(bank, currency, currencies) {
    var res = $.grep(currencies, function(e){ return e.bank == bank && e.currency == currency; });
    return res[0];
}

/**
 * Table constructor
 * @param options
 * @constructor
 */
function tableFilter() {
    var column = this;
    var select = $('<select><option value=""></option></select>')
        .appendTo( $(column.header()).closest('table').find(".filter") )
        .on( 'change', function () {
            var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
            );

            column
                .search( val ? '^'+val+'$' : '', true, false )
                .draw();
        } );

    column.data().unique().sort().each( function ( d, j ) {
        select.append( '<option value="'+d+'">'+d+'</option>' )
    } );
}