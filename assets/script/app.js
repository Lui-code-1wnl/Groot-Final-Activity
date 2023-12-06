const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const dayjs = require('dayjs');
const {request, response} = require("express");
const portNumber = 10000;
const hostIP = 'localhost'
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
    const error_msg = request.session.error_msg;
    const username = request.session.username;

    if (error_msg !== null) {
        response.render('login', { username, error_msg });
    } else {
        response.render('login', { username });
    }
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
                        const userID = user.userID;
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
                            userID: userID,
                            username: username,
                            role: role,
                            firstName: firstName,
                            lastName: lastName,
                            status: status
                        };

                        request.session.userData = uData;

                        connection.query('SELECT status FROM user WHERE username = ?', [username],
                            function(err, result, fields) {
                            if (err) {
                                console.error(err);
                                // Handle the error
                            } else {
                                if (result.length > 0) {
                                    const userStatus = result[0].status;
                                    if (userStatus === 'online') {
                                        const error_msg = `${firstName} ${lastName} is currently online.`;
                                        request.session.error_msg = error_msg;
                                        response.redirect('/login'); // Redirect after successful login
                                        console.log('User is online');
                                    } else {
                                        response.redirect('/welcome-page'); // Redirect after successful login
                                        console.log('Logged in successfully.');
                                        console.log('User is not online');
                                    }
                                } else {
                                    // No user found with the provided username
                                    console.log('User not found');
                                }
                            }
                        });

                    } else {
                        console.log("Login failed.");
                        response.redirect('/login');
                    }
                }
            }
        );
    } else {
        response.redirect('/login');
    }
});


app.get('/', (request, response) => {
    const error_msg = request.session.error_msg;
    var username = request.session.username;
    if(error_msg === null) {
        response.render('login', {error_msg});
    } else {
        response.render('login', { username: username });
    }
});

app.get('/welcome-page', (request, response) => {
    var userData = request.session.userData;
    connection.query(
        'UPDATE user SET status = ? WHERE username = ?',
        ['online', userData.username],
        (updateErr) => {
            if (updateErr) {
                console.error(updateErr);
                response.redirect('/login');
            } else {
                console.log(`${userData.username} is online.`);
            }
        }
    );
    response.render('welcome-page', {userData: userData});
});


app.post('/welcome-page', (request, response) => {
    const userData = request.session.userData;
    response.render('welcome-page', {userData: userData});

});

app.get('/logout', (request, response) => {
    const userData = request.session.userData;
    request.session.destroy((err) => {
        if (err) {
            console.error(err);

        } else {
            connection.query(
                'UPDATE user SET status = ? WHERE username = ?',
                ['offline', userData.username],
                (updateErr) => {
                    if (updateErr) {
                        console.error(updateErr);
                        response.redirect('/login');
                    } else {
                        console.log(`${userData.username} is offline.`);
                    }
                }
            );
            response.redirect('/login');
        }
    });
});
app.post("/", async function(request, response) {
    const userData = request.session.userData;
    const result = await getUserRequest(userData.userID);
    response.send(result);
    console.log(getUserRequest(userData.userID));
});

app.get("/dashboard", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        response.render('dashboard', {userData:userData, result: result });
    } catch (error) {
        console.error('Error:', error);
    }
});

function getUserRequest(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT r.requestID, d.documentID, d.documentTitle, d.documentType, d.dateReviewed, d.numberOfPages, d.documentDescription, d.status FROM User u JOIN Document d ON u.userID = d.userID JOIN Request r ON d.documentID = r.documentID WHERE u.userID = ?';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

app.get('/request-form', (request, response) => {
    var userData = request.session.userData;
    response.render('request-form', {userData: userData});
});


app.post('/request-form', (request, response) => {


});