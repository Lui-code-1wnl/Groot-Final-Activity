const fs = require('fs');
const multer = require('multer');
const express = require('express');
const router = express.Router( );

const upload = multer({dest: 'public/documents'}); // To handle blob in the server


router.post('/', upload.single('file'), (req, res) => {
  const filename = req.query.filename;
  console.log(req.headers);
  const uploadedFile = req.file;
  console.log(uploadedFile.toString());
  try {
    if (!uploadedFile) {
      return res.status(400).send(`No file uploaded. Size: ${uploadedFile.size} Type: ${uploadedFile.type} Filename: ${uploadedFile.filename}`);
    }
    fs.writeFileSync(`public/documents/${filename}`, uploadedFile.buffer);
  } catch(e) {
    res.status(500).send(`Error writing file data to ${filename} due to ${e} Size: ${uploadedFile.size} Type: ${uploadedFile.type} Filename: ${uploadedFile.filename}`);
  }
  res.end();
});


module.exports = router;