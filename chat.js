function nChat(host, port)
{
    this.socket = io.connect(host + ':' + port);
    this.username = '';
}

nChat.prototype.send = function(handle, data)
{
    this.socket.emit(handle, data);
}

nChat.prototype.addUser = function(username)
{
    this.username = username;
    this.send('add_user', {username: username});
};

nChat.prototype.updateUsers = function(elem, users)
{
    elem.html('');
    console.log(users);
    for (var i = 0; i < users.length; i++)
    {
        var append = '<li class="list-group-item">';

        if (users[i] == this.username)
            var append = '<li class="list-group-item list-group-item-info">';

        elem.append(append + '<span class="glyphicon glyphicon-user"></span> <small>'+users[i]+'</small></li>');
    }
}

nChat.prototype.leave = function()
{
    this.send('disconnect');
}

nChat.prototype.addMessage = function(message)
{
    this.send('add_message', {message: message});
}