function handler (req, res) {
    fs.readFile(__dirname + '/client.html',
        function (err, data) {
            res.writeHead(200);
            res.end(data);
        });
}

function cleanArray(actual){
    var newArray = new Array();
    for(var i = 0; i<actual.length; i++){
        if (actual[i]){
            newArray.push(actual[i]);
        }
    }
    return newArray;
}

//var io = require('socket.io').listen(7074);
var app = require('http').createServer(handler);
var io = require('socket.io').listen(app);
var fs = require('fs');

app.listen(8080);

var connectedUsers = new Array(); // lists all users and sockets
var users = Array();            // lists all usernames
// https://github.com/Automattic/socket.io/blob/master/examples/chat/index.js
// https://coderwall.com/p/ekrcyw
io.on('connection', function (socket) {

    socket.emit('connected', {connected: true });

    socket.on('add_user', function(data) {
        connectedUsers[data.username] = socket;
        users.push(data.username);

        socket.username = data.username;

        users = cleanArray(users);

        io.sockets.emit('update_users', users);
    });

    socket.on('add_message', function(data) {
        // send to all
        var payload =  {'username': socket.username, 'message': data};

        fs.appendFile('chat.json', JSON.stringify(payload, null, 2), 'utf8', function(){
            io.sockets.emit('add_message', payload);
        });
    });

    socket.on('disconnect', function(d){
        var i = users.indexOf(socket.username);

        delete users[i];
        delete connectedUsers[socket.username];

        users = cleanArray(users);

        io.sockets.emit('update_users', users);
    });
});