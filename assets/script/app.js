const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const dayjs = require('dayjs');
const {request, response} = require("express");
const portNumber = 6969;
const hostIP = 'localhost'
const path = require('path');
const fileUpload = require('express-fileupload');
var connection = mysql.createConnection({
    host: hostIP, user:'root', password: '', database: 'groot_final'
});

const fs = require('fs');
const app = express();
app.use(express.static('public'));
app.use(express.static('assets'));
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
app.use(express.static('sort'));
app.listen(portNumber, hostIP)
console.log(`Server running on port number ${portNumber}`);
const annotationHandler = require('./public/lib/annotationHandler');
app.use('/lib/annotationHandler.js', annotationHandler);
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
    const userData = request.session.userData;
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

app.get('/logout', (request, response) => {
    const userData = request.session.userData;
    if (userData) {
        // Set user status to 'offline' when logging out
        connection.query(
            'UPDATE user SET status = ? WHERE username = ?',
            ['offline', userData.username],
            (updateErr) => {
                if (updateErr) {
                    console.error(updateErr);
                    // Handle error if necessary
                } else {
                    console.log(`${userData.username} is offline.`);
                    request.session.destroy(); // Destroy session upon logout
                    response.redirect('/login'); // Redirect to login page after logout
                }
            }
        );
    } else {
        response.redirect('/login');
    }
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

        const dir = path.join(__dirname, `public/documents/${userData.username}`);

        // Create the directory if it doesn't exist
        if (!fs.existsSync(dir) && userData.role === 'user') {
            fs.mkdirSync(dir, { recursive: true });
            console.log(`Folder created for: ${userData.username}`);
        }

        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-date-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserDateAsc(userData.userID);
        response.render('dashboard-date-asc', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-date-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserDateDesc(userData.userID);
        response.render('dashboard-date-desc', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-title-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserTitleAsc(userData.userID);
        response.render('dashboard-title-asc', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-title-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserTitleDesc(userData.userID);
        response.render('dashboard-title-desc', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-reqID-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserTitleAsc(userData.userID);
        response.render('dashboard-reqID-asc', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-reqID-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserReqIDDesc(userData.userID);
        response.render('dashboard-reqID-desc', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-pending", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserPending(userData.userID);
        response.render('dashboard-pending', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/dashboard-approved", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await sortUserApproved(userData.userID);
        response.render('dashboard-approved', {userData:userData, result: result });

    } catch (error) {
        console.error('Error:', error);
    }
});



app.get("/office-dashboard", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await getUserRequest(userData.userID);


        const sortOption = request.query.sort;

        // Sort the departmentResult based on the sortOption
        if (sortOption === 'id') {
            departmentResult.sort((a, b) => a.referringEntity.localeCompare(b.name));
        } else if (sortOption === 'name') {
            departmentResult.sort((a, b) => a.name.localeCompare(b.name));
        } else if (sortOption === 'date') {
            departmentResult.sort((a, b) => new Date(a.date) - new Date(b.date));
        }


        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});


app.get("/office-dashboard-entity-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortEntityAsc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-entity-asc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-entity-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortEntityDesc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-entity-desc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-reqNo-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortReqNoDesc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-reqNo-desc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-reqNo-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortReqNoAsc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-reqNo-asc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-date-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortDateDesc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-date-desc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-date-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortDateAsc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-date-asc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-title-desc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortTitleDesc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-title-desc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-title-asc", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await sortTitleAsc(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-title-asc', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-pending", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await getPending(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-pending', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-approved", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await getApproved(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-approved', {userData:userData, departmentResult: departmentResult });
        }

    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/office-dashboard-returned", async function(request, response) {
    try {
        const userData = request.session.userData;
        const result = await getUserRequest(userData.userID);
        const departmentResult = await getReturned(userData.userID);
        if (userData.role === 'user') {
            response.render('dashboard', {userData:userData, result: result });
        } else if (userData.role === 'office') {
            response.render('office-dashboard-returned', {userData:userData, departmentResult: departmentResult });
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
        let message = request.body.mssg;
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


                const requestID = rows[0].requestID;
                console.log('Inserted requestID:', requestID);

                offices.forEach((office, index) => {

                    let filename = `${requestID}-${userData.userID}-${documentTitle}.pdf`;
                    let date = formattedDateTime;
                    let docStat = (index === 0) ? 'Pending' : 'Waiting'; // Set initial status accordingly

                    if (index !== 0) {
                        // For subsequent indexes, modify specific elements of the array
                        filename = ''; // Set filename to null for subsequent indexes
                        message = ''; // Set message to null for subsequent indexes
                    }
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
                        message,
                        date,
                        '',
                        docStat // Assign the status
                    ];



                    if (index === 0) {
                        documentValues[13] = 'Pending';
                        if (!request.files || !request.files.pdfFile) {
                            console.log('No files were uploaded.');
                        } else {
                            const pdfFile = request.files.pdfFile;

                            pdfFile.mv(path.join(__dirname, `/public/documents/${userData.username}`, filename), (err) => {
                                if (err) {
                                    console.log(err);
                                }
                                console.log('File uploaded successfully!');
                            });
                        }
                    } else {
                        // Modify specific elements of the array for subsequent indexes
                        documentValues[7] = ''; // Set filename to null for subsequent indexes
                        documentValues[9] = ''; // Set message to null for subsequent indexes
                    }

                    connection.query('INSERT INTO document (requestID, userID, officeID, documentTitle, referringEntity, documentType, numberOfPages, document_file, documentDescription, message, dateReceived, dateReviewed, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', documentValues, (error, results, fields) => {
                        if (error) {
                            console.error('Error inserting data:', error);
                            throw error;
                        }
                        console.log('Document data inserted successfully');
                    });
                });
            });
            response.redirect(`/after-submission`);
        });
    } catch (err) {
        console.error('Error:', err);
    }
});

app.get('/after-submission', (request, response) => {
    const userData = request.session.userData;
    response.render('after-submission', {userData:userData});
});

app.get('/client-blue-header', (request, response) => {
    const userData = request.session.userData;
    response.render('client-blue-header', {userData:userData});
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

app.post("/document-progress/:requestID", async function(request, response) {
    const reqID = request.params.requestID;
    const userData = request.session.userData;
    console.log(`Request ID: ${reqID}`);

    try {
        const result = await getUserRequest(userData.userID);
        const documentData = await getViewRequest(userData.userID, reqID);
        const departmentData = await getOffices();
        console.log(departmentData);
        console.log(documentData);

        let filename = `${reqID}-${userData.userID}-${documentData[0].documentTitle}.pdf`;
        const dateOfRev = dayjs();
        let formattedDateTime = dayjs(dateOfRev).format('YYYY-MM-DD HH:mm');
        const buttonAction = request.body.actionTaken;


        if (buttonAction === 'reupload') {
            const pdfFile = request.files.pdfFile;

            pdfFile.mv(path.join(__dirname, `/public/documents/${userData.username}`, filename), (err) => {
                if (err) {
                    console.log(err);
                }
                console.log('File uploaded successfully!');
            });
            connection.query(
                'UPDATE document SET document_file = ?, message = ?, dateReceived = ? WHERE requestID = ? AND userID = ? AND officeID = ?',
                [filename, request.body.mssg,formattedDateTime, reqID, userData.userID, documentData[0].officeID],
                (updateErr) => {
                    if (updateErr) {
                        console.error(updateErr);

                    } else {
                        console.log(`Successfully reuploaded.`);
                    }
                });
        }

        response.render('after-submission', {userData:userData, result: result, documentData:documentData, departmentData:departmentData, reqID});
    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/document-review/:requestID", async function(request, response) {
    const reqID = request.params.requestID;
    const userData = request.session.userData;
    console.log(`Request ID: ${reqID}`);
    try {
        const result = await getUserRequest(userData.userID);
        const documentData = await getToBeReviewed(userData.userID, reqID);
        const departmentData = await getOffices();
        console.log(departmentData);
        console.log(documentData);

        response.render('document-review', {userData:userData, result: result, documentData:documentData, departmentData:departmentData, reqID});
    } catch (error) {
        console.error('Error:', error);
    }
});

app.get("/file/:filename", function(request, response) {

    response.status(200).sendFile(path.join(__dirname, `documents/${request.params.filename}`));

});

app.get("/render:filepath", async function(request, response) {

    const reqID = request.params.requestID;
    const userData = request.session.userData;
    console.log(`Request ID: ${reqID}`);
    try {
        const result = await getUserRequest(userData.userID);
        const documentData = await getToBeReviewed(userData.userID, reqID);
        const departmentData = await getOffices();
        console.log(departmentData);
        console.log(documentData);


        response.render('render:filepath', {userData:userData, result: result, documentData:documentData, departmentData:departmentData, reqID});
    } catch (error) {
        console.error('Error:', error);
    }
});


app.post('/document-review/:requestID', async (request, response) => {
    const userData = request.session.userData;
    const reqID = request.params.requestID;
    const buttonAction = request.body.actionTaken;
    const message = request.body.mssg;
    const dateOfRev = dayjs();
    let formattedDateTime = dayjs(dateOfRev).format('YYYY-MM-DD HH:mm');
    try {
        const documentData = await getToBeReviewed(userData.userID, reqID);


        if (buttonAction === 'Approve') {
            connection.query(
                'UPDATE document SET status = ?, document_file = ?, message = ?, dateReviewed = ? WHERE documentID = ? AND requestID = ? AND officeID = ?',
                ['Approved', documentData[0].document_file, message, formattedDateTime, documentData[0].documentID, reqID, documentData[0].officeID],
                (updateErr) => {
                    if (updateErr) {
                        console.error(updateErr);
                    } else {
                        console.log("Document status updated.");
                        console.log(documentData[0].document_file);
                        let officeMove = documentData[0].officeID + 1;
                        let documentMove = documentData[0].documentID +1;
                        console.log(officeMove);
                        console.log(documentData[0].documentID +1);
                        console.log(reqID);
                        // Execute the second query inside the callback of the first query
                        if (documentData && documentData.length > 0) {
                            if (documentData[0].officeID < 7) {
                                connection.query(
                                    'UPDATE document SET status = ?, document_file = ?, message = ?, dateReceived = ? WHERE documentID = ? AND requestID = ? AND officeID = ?',
                                    ['Pending', documentData[0].document_file, message, formattedDateTime, documentMove, reqID, officeMove],
                                    (secondUpdateErr) => {
                                        if (secondUpdateErr) {
                                            console.error(secondUpdateErr);
                                        } else {
                                            console.log("Second document status updated.");
                                            // Further actions after the update
                                        }
                                    }
                                );
                            } else if (documentData[0].officeID === 8) {
                                connection.query(
                                    'UPDATE request SET overallStatus = ? WHERE requestID = ? AND userID = ?',
                                    ['Approved', reqID, documentData[0].userID],
                                    (secondUpdateErr) => {
                                        if (secondUpdateErr) {
                                            console.error(secondUpdateErr);
                                        } else {
                                            console.log("Request status updated.");
                                            // Further actions after the update
                                        }
                                    }
                                );
                            } else {
                                console.log('No update criteria matched.');
                            }
                        } else {
                            console.log('No data found for the given criteria.');
                        }

                    }

                }
            );


        } else if (buttonAction === 'Return') {
            connection.query(
                'UPDATE document SET status = ?, document_file = ?, message = ?, dateReviewed = ? WHERE documentID = ? AND requestID = ? AND officeID = ?',
                ['Returned', documentData[0].document_file, message, formattedDateTime, documentData[0].documentID, reqID, documentData[0].officeID],
                (updateErr) => {
                    if (updateErr) {
                        console.error(updateErr);

                    } else {
                        console.log("Document status updated.");
                    }
                }
            );

        }

        response.render('reviewer-after-submit', {userData: userData});
    } catch(err) {
        console.log(err);
    }

});

app.get('/reviewer-after-submit', (request, response) => {
    const userData = request.session.userData;
    response.render('reviewer-after-submit', {userData:userData});
});



function getViewRequest(userID,reqID) {
    return new Promise((resolve, reject) => {
        let sql = `SELECT d.documentID, d.requestID, d.userID, d.officeID, d.documentTitle, d.referringEntity, d.documentType, d.numberOfPages, d.document_file, d.documentDescription, d.message, d.dateReceived, d.dateReviewed, d.status, u.userID AS officeUserID, u.username AS officeUsername, u.firstName AS office FROM document d JOIN request r ON d.requestID = r.requestID JOIN user u ON u.userID = d.officeID AND u.userRole = 'office' WHERE r.requestID = ${reqID} AND r.userID = ${userID}`;
        connection.query(sql, [userID, reqID], (err, result) => {
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
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND status != "Waiting" AND document_file IS NOT NULL ORDER BY requestID DESC';

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

function getToBeReviewed(userID,reqID) {
    return new Promise((resolve, reject) => {
        let sql = `SELECT document.*, user.* FROM document JOIN user ON document.userID=user.userID WHERE document.requestID =? AND document.officeID = ?`;
        connection.query(sql, [reqID,userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortEntityDesc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY referringEntity DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortEntityAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY referringEntity ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortTitleDesc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY documentTitle DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortTitleAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY documentTitle ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortDateDesc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY dateReceived DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortDateAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY dateReceived ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortReqNoDesc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY requestID DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortReqNoAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND document_file IS NOT NULL ORDER BY requestID ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function getPending(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND status = ? AND document_file IS NOT NULL ORDER BY requestID DESC';

        connection.query(sql, [userID, 'Pending'], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function getApproved(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND status = ? AND document_file IS NOT NULL ORDER BY requestID ASC';

        connection.query(sql, [userID, 'Approved'], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function getReturned(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT `documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `dateReceived`, `dateReviewed`, `status` FROM `document` WHERE officeID = ? AND status = ? AND document_file IS NOT NULL ORDER BY requestID ASC';

        connection.query(sql, [userID, 'Returned'], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserReqIDDesc(userID) {
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

function sortUserReqIDAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? ORDER BY requestID ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserTitleDesc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? ORDER BY documentTitle DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserTitleAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? ORDER BY documentTitle ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserDateDesc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? ORDER BY dateSubmitted DESC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserDateAsc(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? ORDER BY dateSubmitted ASC';

        connection.query(sql, [userID], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserPending(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? AND overallStatus = ? ORDER BY requestID DESC';

        connection.query(sql, [userID, 'Pending approval'], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function sortUserApproved(userID) {
    return new Promise((resolve, reject) => {
        let sql = 'SELECT requestID, userID, documentTitle, dateSubmitted, overallStatus FROM request WHERE userID = ? AND overallStatus = ? ORDER BY requestID DESC';

        connection.query(sql, [userID, 'Approved'], (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}
