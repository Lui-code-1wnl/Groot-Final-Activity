const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const portNumber = 6969;

const hostIP = 'localhost'

var connection = mysql.createConnection({
    host: hostIP, user:'root', password: '', database: 'groot_finals'
});

const app = express();
app.use(express.static('public'));
app.use(bodyParser.urlencoded);
app.use(bodyParser.json());
app.use(session({secret: 'somesecretkey', resave: true, saveUninitialized: true}));

app.listen(portNumber, hostIP)
console.log('Server running at port ${portNumber}');