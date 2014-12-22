<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Node.js App</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- Optional theme
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="./assets/css/bootstrap-theme.css">
    <link rel="stylesheet" href="./assets/css/global.css">

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</head>
<body>
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div id="navbar" class="col-lg-2" style="background:red">a</div>-->
<!--        <div id="chat" class="col-lg-8">b</div>-->
<!--        <div id="sidebar" class="col-lg-2" style="background: blue">c</div>-->
<!--    </div>-->
<!--</div>-->
<div class="container">
    <div id="navbar" class="row col-lg-2">
        <div class="panel panel-default">
            <div class="panel-heading">
               <h2 class="panel-title">Chat.io <small>Let's talk :)</small></h2>
            </div>
            <div class="panel-body">
                <ul class="nav">
                    <li data-room="general" class="active"><a href="#">General <span class="badge pull-right">20</span></a></li>
                    <li data-room="vacation"><a href="#">Vacation  <span class="badge pull-right">10</span></a></li>
                    <li data-room="fun"><a href="#">Fun <span class="badge pull-right">2</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="chat" class="row col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">What's dem people talking 'bout</h2>
            </div>
            <div class="panel-body">
                <!-- List group -->
                <ul class="list-group" id="messages">
                    <li><p>Message listing..</p></li>
                </ul>

                <div id="formField" class="row col-md-12">
                    <form role="form" class="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Username:</label>
                                <input id="username" name="user" type="text" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" id="message" placeholder="Ohh.. tell me what you want what you really really want"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">
                            <span class="glyphicon glyphicon-comment"></span> Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar" class="row col-lg-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Who's on the line</h3>
            </div>
            <!-- List group -->
            <ul class="list-group" id="users" style="overflow: auto; height: 400px;">

            </ul>
        </div>
    </div>
</div>

<script src="http://localhost:8080/socket.io/socket.io.js"></script>
<script src="chat.js"></script>
<script type="text/javascript">
    function randomString(length)
    {
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var result = '';

        for (var i = length; i > 0; --i)
            result += chars[Math.round(Math.random() * (chars.length - 1))];

        return result;
    }

    var app = new nChat('http://localhost', 8080);
    var username = 'Anon-'+randomString(4).toUpperCase();

    app.send('test', {name: 'johnSmitsson'});

    app.addUser(username);
    $("input#username").val(username);

    $("form").submit(function(e){
        e.preventDefault();

        var msg = $("#message").val();

        app.addMessage(msg);
    });


    console.log(app.socket);

    app.socket.on('connected', function(d) {
//        console.log(d);
    });

    app.socket.on('add_message', function(data) {
        var message = '<li class="list-group-item well well-sm">';
        message = message+'<strong><span class="glyphicon glyphicon-comment"></span>'+data.username+'</strong>';
        message = message+'<p>'+data.message.message+'</p></li>';

        $("#messages").append(message);
        $("#messages").animate({ scrollTop: $("#messages")[0].scrollHeight }, 1000);
    });

    app.socket.on('update_users', function(users){
        app.updateUsers( $("#users"), users);
    });

//    //
//    var socket = io.connect('http://localhost:8080/');
//    var username = 'Anon'+randomString(6);
//
//    // listeners
//    socket.on('connect', function(data){
//        //        socket.emit('subscribe', {channel: 'private messaging app'});
//    });
//
//    socket.on('chat.general', function(data){
//        var message = '<li class="list-group-item well well-sm">';
//        message = message+'<strong><span class="glyphicon glyphicon-comment"></span>'+data.user+'</strong>';
//        message = message+'<p>'+data.message+'</p></li>';
//
//        $("#messages").append(message);
//        $("#messages").animate({ scrollTop: $("#messages")[0].scrollHeight }, 1000);
//    });
//
//    // user actions
//    $("form#chat").submit(function(e){
//        e.preventDefault();
//        socket.emit('sendMessage', {user:  $("form input#username").val(), message: $("form input#message").val()});
//    });
</script>
</body>
</html>