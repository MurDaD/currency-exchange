function socketFunc() {
    socket = new WebSocket("ws://li1430-197.members.linode.com:8000/currency-exchange/server.php");

    socket.onopen = function () {
        console.log("Connection OK.");
        _online = true;
        socket.send('{"$type": "ping","seq": "1"}');
        console.log(innerPage);
        if (innerPage) {
            console.log('getInnerList');
            window.setTimeout(function () {
                socket.send('{"$type": "getInnerList","bank": "' + bank + '","currency":"' + curr + '"}');
            }, 500);
        } else {
            console.log('getList');
            window.setTimeout(function () {
                localforage.getItem('currencies').then(function (value) {
                    socket.send('{"$type": "getList", "latest":"' + value[0].added + '"}');
                }).catch(function (err) {
                    console.log(err);
                });
            }, 500);
        }

        /*pingTimeout = window.setInterval(function(){
         socket.send('{"$type": "ping","seq": "1"}');
         }, 1000);*/
    };
    socket.onclose = function (event) {
        if (event.wasClean) {
            console.log('Connection closed carefully');
        } else {
            console.log('Connection error'); // например, "убит" процесс сервера
        }
        console.log('CODE: ' + event.code + ' reason: ' + event.reason);
    };

    socket.onerror = function (error) {
        console.log("ERROR: " + error.message);
    };

    socket.onmessage = function (event) {
        //console.log(event.data);
        var res = JSON.parse(event.data);
        switch (res.$type) {
            case 'pong':
                if (res.seq == 1 && !_online) {
                    console.log("got online");
                    _online = true;
                }
                if (res.seq == 0 && _online) {
                    console.log("got offline");
                    _online = false;
                }
                break;
            case 'list':
                if(res.list != undefined) {
                    var list = res.list[0];
                    storageSaveItem('currencies', list);
                    updateTable(list);
                }
                break;
            case 'listInner':
                if(res.list != undefined) {
                    var list = res.list[0];
                    updateTable(list);
                }
                break;
            case 'listDetailed':
                if(res.list != undefined) {
                    mainTableUpdatiable = false;
                    var list = res.list[0];
                    updateTable(list, true);
                }
                break;
        }
    }
}
