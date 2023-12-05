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

app.get('/', (request, response) => {
        response.render('index');
});

app.get('/login', (request, response) => {
    var username = request.session.username;
    response.render('login', { username: username });
});

app.post('/login', (request, response) => {
    var username = request.body.username;
    var password = request.body.password;

    if (username && password) {
        connection.query('SELECT * FROM user WHERE username = ? and password = ?',
            [username, password],
            function(err, result, fields) {
                if (err) {
                    console.error(err);
                    response.redirect('/login'); // Redirect on error
                } else {
                    if (result.length > 0) {
                        const user = result[0];

                        const firstName = user.firstName;

                        const role = user.userRole;
                        const lastName = user.lastName;
                        const status = user.status;

                        if (role === 'user') {
                            console.log(`${username} is a ${role}`);
                        } else if (role === 'office') {
                            console.log(`${username} is a ${role}`);
                        }

                        let uData =  {
                            username: username,
                            role: role,
                            firstName: firstName,
                            lastName: lastName,
                            status: status
                        };

                        request.session.userData = uData;

                        response.redirect('/welcome-page'); // Redirect after successful login
                        console.log('Logged in successfully.');
                    } else {
                        console.log("Login failed.");
                        response.redirect('/login'); // Redirect if login fails
                    }
                }
            }
        );
    } else {
        response.redirect('/login'); // Redirect if username/password not provided
    }
});

app.get('/', (request, response) => {
    var username =request.session.username
    response.render('login',{username:username});
});

app.get('/welcome-page', (request, response) => {
    var userData = request.session.userData;
    response.render('welcome-page', {userData: userData});
});


app.post('/welcome-page', (request, response) => {
    const userData = request.session.userData;
    const fname = user.firstName;
    response.render('welcome-page', {userData: userData});
});