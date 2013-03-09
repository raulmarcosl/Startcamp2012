
/**
 * Module dependencies.
 */

var express = require('express')
  , routes = require('./routes')
  , http = require('http')
  , path = require('path');

var app = express();

app.configure(function(){
      app.set('port', process.env.PORT || 3000);
      app.set('views', __dirname + '/views');
      app.set('view engine', 'jade');
      app.use(express.favicon());
      app.use(express.logger('dev'));
      app.use(express.bodyParser());
      app.use(express.methodOverride());
      app.use(express.cookieParser('your secret here'));
      app.use(express.session());
      app.use(app.router);
      app.use(express.static(path.join(__dirname, 'public')));
});

app.configure('development', function(){
    app.use(express.errorHandler());
});


var mongoose = require('mongoose');
var Schema = mongoose.Schema;
mongoose.connect('localhost', 'startcamp2012');
var db = mongoose.connection;
db.on('error', console.error.bind(console, "Connection error: "));

var userSchema = new Schema({
    email: { type: String, unique: true, required: true },
    twitterId: { type: String, unique: true, required: true },
    twitterUsername: { type: String, unique: true, required: true },
    twitterOAuthToken: { type: String, unique: true, required: true },
    twitterOAuthTokenSecret: { type: String, unique: true, required: true },
    avatar: { type: String, default: null },
    avatarUrl: { type: String, default: null },
    feeds: [{
        type: Schema.Types.ObjectId,
        ref: 'Feed',
        default: null
    }],
    favorited: [{
        type: Schema.Types.ObjectId,
        ref: 'Feed',
        default: null
    }]
});
var User = mongoose.model('User', userSchema);

var feedSchema = new Schema({
    title: { type: String, required: true },
    content: { type: String, required: true },
    photo: { type: String, default: null },
    photoUrl: { type: String, default: null },
    permalink: { type: String, required: true },
    pubDate: { type: Number, required: true },
    tags: [{ type: String, default: null }],
    score: { type: Number, default: null }
});
var Feed = mongoose.model('Feed', feedSchema);


app.get('/api/user', function (req, res) {
    User.find({}, function (err, users) {        
        if (err) {
            res.send("Error on /api/user (GET). MongoDB error", 400);
        } else {
            res.send(users, 200);
        }
    });
});

app.get('/api/user/:twitterId', function (req, res) {
    var twitterId = req.params.twitterId;    
    User.findOne({twitterId: twitterId}, function (err, user) {        
        if (err) {
            res.send("Error on /api/user/{twitterId} (GET). MongoDB error", 400);
        } else if (user === null){
            res.send("[]", 200);
        } else {
            res.send(user, 200);
        }
    });
});

app.post('/api/user', function (req, res) {
    var avatar = req.body.avatar ? req.body.avatar : null;
    var  avatarFilename = req.body.avatarFilename ? req.body.avatarFilename : null;

    var newUser = new User ({
        email: req.body.email,
        twitterId: req.body.twitterId,
        twitterUsername: req.body.twitterUsername,
        twitterOAuthToken: req.body.twitterOAuthToken,
        twitterOAuthTokenSecret: req.body.twitterOAuthTokenSecret,
        avatar: avatar,
        avatarFilename: avatarFilename
    });

    newUser.save (function (err) {
        if (err) {
            res.send("Error on /api/user (POST). MongoDB error.", 400);
        } else {
            res.send(newUser, 200);
        }
    });
});


app.get('/api/feed', function (req, res) {
    Feed.find({}, function (err, users) {        
        if (err) {
            res.send("Error on /api/feed (GET). MongoDB error", 400);
        } else {
            res.send(users, 200);
        }
    });
});

app.get('/api/feed/:id', function (req, res) {
    var eventId = req.params.eventId;    
    Feed.findOne({_id: eventId}, function (err, user) {        
        if (err) {
            res.send("Error on /api/feed/{id} (GET). MongoDB error", 400);
        } else if (user === null){
            res.send("[]", 200);
        } else {
            res.send(user, 200);
        }
    });
});

app.post('/api/feed', function (req, res) {
    newFeed = new Feed({
        title: req.body.title,
        content: req.body.content,
        permalink: req.body.permalink,
        pubDate: req.body.pubDate
    });

    newFeed.save (function (err) {
        if (err) {
            res.send("Error on /api/feed (POST). MongoDB error.", 400);
        } else {
            res.send(newFeed, 200);
        }
    });
});


http.createServer(app).listen(app.get('port'), function(){
  console.log("Express server listening on port " + app.get('port'));
});
