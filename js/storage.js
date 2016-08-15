/**
 * Saves data to local storage
 * @param name
 * @param data
 */
function storageSaveItem(name, data) {
    localforage.setItem(name, data).then(function () {
        return localforage.getItem(name);
    }).catch(function (err) {
        console.log(err);
    });
}

/**
 * Saves currency to popular list
 * Max number of items is defined in defaults.js
 * @param bank
 * @param curr
 */
function saveLatestCurrency(bank, curr) {
    localforage.getItem('latestCurrencies').then(function (currencies) {
        if(currencies !== null && currencies.length >= maxLatest) {
            currencies.splice(-1,1);
        }
        if(currencies === null) {
            currencies = [];
        }
        // Remove currency if it's exist;
        var newCurr = {'bank': bank, 'currency': curr};
        for (var i in currencies) {
            if(currencies[i].bank == bank && currencies[i].currency == curr) {
                currencies.splice(i, 1);
            }
        }
        currencies.unshift(newCurr);
        //currencies = [];
        localforage.setItem('latestCurrencies', currencies).then(function () {}).catch(function (err) {
            console.log(err);
        });
    }).catch(function (err) {
        console.log(err);
    });
}