const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const dayjs = require('dayjs');
const {request, response} = require("express");
const portNumber = 10000;
const hostIP = 'localhost'
const path = require('path');
const fileUpload = require('express-fileupload');
var connection = mysql.createConnection({
    host: hostIP, user:'root', password: '', database: 'groot_final'
});
const fs = require('fs');
const app = express();
app.use(express.static('public'));
app.set('views', `${__dirname}/public/view`);
app.set('view engine', 'pug');
app.use('/css', express.static(`${__dirname}/script/public/css`));
app.use(fileUpload());

app.use(bodyParser.urlencoded({
    extended: true
}));
app.use(bodyParser.json());
app.use(session({secret: 'somesecretkey', resave: true, saveUninitialized: true}));
app.use(express.static('documents'));


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
                        const username = user.username;
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
    const userData = request.session.userData;
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

app.get('/login', (request, response) => {
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
        const departmentResult = await getOfficeRequest(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await getUserRequest(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

function getUserRequest(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? ORDER BY requestID DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function getOfficeRequest(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? ORDER BY requestID DESC;';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}


function getOffices() {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT * FROM `user` WHERE userRole = "office"';

        connection.query(sql, (err, result) => {
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

app.post('/request-form', async (request, response) => {
    try {
        let currentDateTime = dayjs();
        const userData = request.session.userData;
        const offices = await getOffices();
        const userID = userData.userID;
        const entity = request.body.entity;
        const documentTitle = request.body.documentTitle;
        const documentType = request.body.documentType;
        const numOfPages = request.body.numOfPages;
        const description = request.body.desc;
        let formattedDateTime = dayjs(currentDateTime).format('YYYY-MM-DD HH:mm');
        let requestID = 0;

        connection.query('INSERT INTO `request` (`userID`,`documentTitle`,`dateSubmitted`, `overallStatus`) VALUES (?, ?, ?, ?)', [userID, documentTitle, formattedDateTime, 'Pending approval'], (err, results) => {
            if (err) {
                console.log(err);
                throw err;
            }

            connection.query('SELECT LAST_INSERT_ID() AS requestID', (error, rows) => {
                if (error) {
                    console.error('Error fetching requestID:', error);
                    throw error;
                }

                if (index === 0) {

                    if (!request.files || !request.files.pdfFile) {
                        console.log('No files were uploaded.');
                    }

                    const pdfFile = request.files.pdfFile;


                    pdfFile.mv(path.join(__dirname, `/public/documents/${userData.username}`, filename), (err) => {
                        if (err) {
                            console.log(err);
                        }

                        console.log('File uploaded successfully!');
                    });
                } else if (index > 0){
                    filename = null;
                }

                const requestID = rows[0].requestID;
                console.log('Inserted requestID:', requestID);
                let filename = `${requestID}-${userData.userID}-${documentTitle}.pdf`;
                offices.forEach((office,index) => {
                    let date = formattedDateTime;
                    const documentValues = [
                        requestID,
                        userData.userID,
                        office.userID,
                        documentTitle,
                        entity,
                        documentType,
                        numOfPages,
                        filename,
                        description,
                        date,
                        '',
                        'Pending'
                    ];

                    connection.query('INSERT INTO document (requestID, userID, officeID, documentTitle, referringEntity, documentType, numberOfPages, document_file, documentDescription, dateReceived, dateReviewed, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', documentValues, (error, results, fields) => {
                        if (error) {
                            console.error('Error inserting data:', error);
                            throw error;
                        }
                        console.log('Document data inserted successfully');
                    });

                });
            });
        });

        response.redirect(`/after-submission`);
    } catch (err) {
        console.error('Error:', err);
    }
});

app.get('/after-submission', (request, response) => {
    const userData = request.session.userData;
    response.render('after-submission');
});

app.get('/client-blue-header', (request, response) => {
    const userData = request.session.userData;
    response.render('client-blue-header');
});

app.get("/document-progress/:requestID", async function(request, response) {
    const reqID = request.params.requestID;
    const userData = request.session.userData;
    console.log(`Request ID: ${reqID}`);
    try {
        const result = await getUserRequest(userData.userID);
        const documentData = await getViewRequest(userData.userID, reqID);
        const departmentData = await getOffices();
        console.log(departmentData);
        console.log(documentData);
        response.render('document-progress', {userData:userData, result: result, documentData:documentData, departmentData:departmentData, reqID});
    } catch (error) {
        console.error('Error:', error);
    }
});

function getDocumentRequest(userID,requestID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT d.documentID, d.requestID, d.userID, d.officeID, d.documentTitle, d.referringEntity, d.documentType, d.numberOfPages, d.document_file, d.documentDescription, d.dateReceived, d.dateReviewed, d.status, u.userID AS user_ID, u.firstName, u.userRole, u.officeID AS user_office FROM document d JOIN request r ON d.requestID = r.requestID JOIN users u ON d.userID = u.userID WHERE r.requestID = d.requestID AND r.userID = d.userID';
        connection.query(sql, [userID, requestID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function getViewRequest(userID,reqID) {
    return new Promise((resolve, reject) => {
        let sql = `SELECT d.documentID, d.requestID, d.userID, d.officeID, d.documentTitle, d.referringEntity, d.documentType, d.numberOfPages, d.document_file, d.documentDescription, d.dateReceived, d.dateReviewed, d.status, u.userID AS officeUserID, u.username AS officeUsername, u.firstName AS office FROM document d JOIN request r ON d.requestID = r.requestID JOIN user u ON u.userID = d.officeID AND u.userRole = 'office' WHERE r.requestID = ${reqID} AND r.userID = ${userID}`;
        connection.query(sql, [userID, reqID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}