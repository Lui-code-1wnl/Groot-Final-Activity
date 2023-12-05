const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const {request, response} = require("express");
const portNumber = 10000;
const hostIP = 'localhost'
var path = require('path')
var connection = mysql.createConnection({
    host: hostIP, user:'root', password: '', database: 'groot_final'
});

const app = express();
app.use(express.static('public'));
app.set('views', `${__dirname}/public/view`);
app.set('view engine', 'pug');
app.use('/css', express.static(`${__dirname}/script/public/css`));

app.use(bodyParser.urlencoded({
    extended: true
}));
app.use(bodyParser.json());
app.use(session({secret: 'somesecretkey', resave: true, saveUninitialized: true}));



app.listen(portNumber, hostIP)
console.log(`Server running on port number ${portNumber}`);

app.post('/login', (request, response) => {
    var username = request.body.username;
    var password = request.body.password;

    if (username && password) {
        connection.query('SELECT * FROM user WHERE username = ? and password = ?',
            [username, password],
            function(err, result, fields) {
                if (err) throw err;

                if (result.length > 0) {
                    request.session.username = username;
                    request.session.shcart = [];
                    response.redirect('/');
                    console.log('Logged in successfully.');
                } else {
                    console.log("Login failed.");
                    response.redirect('/');
                }
            }
        );
    }
});

app.get('/', (request, response) => {
    var username =request.session.usernamel
    response.render('login',{username:username})
});