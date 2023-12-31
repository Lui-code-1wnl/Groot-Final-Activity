
var viewerElement = document.getElementById('viewer');

WebViewer({
  path: '/lib',
  initialDoc: '/documents/adumlao/39-1-Organization%20Assembly.pdf',
}, viewerElement).then(instance => {
  const {documentViewer, annotationManager} = instance.Core;
  // Add a save button on header
  instance.setHeaderItems(function(header) {
    header.push({
      type: 'actionButton',
      img: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>',
      onClick: function() {
        console.log("annotate plss");
        // Update the document when button is clicked
        saveDocument('39-1-Organization%20Assembly.pdf').then(function() {
          console.log("Test Log");
          alert('Annotations saved to the document.');
        });
      }
    });
  });

  // Make a POST request with blob data for a PDF with new annotations
  var saveDocument = function(filename) {
    return new Promise(function(resolve, reject) {
      annotationManager.exportAnnotations().then(function(xfdfString) {
        documentViewer.getDocument().getFileData({ xfdfString }).then(function(data) {
          var arr = new Uint8Array(data);
          var blob = new Blob([ arr ], { type: 'application/pdf' });
          // FormData is used to send blob data through fetch
          var formData = new FormData();
          formData.append('blob', blob);
          fetch(`/lib/annotationHandler.js?filename=${filename}`, {
            method: 'POST',
            body: formData,
          }).then(function (res) {
            if (res.status === 200) {
              resolve();
              console.log("Test");
            }
          }).catch(function (error) {
            console.error('Error:', error);
          });
        });
      });
    });
  };
});