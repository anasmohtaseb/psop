// TinyMCE CDN loader for admin competition forms
(function() {
  var script = document.createElement('script');
  script.src = 'https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js';
  script.referrerPolicy = 'origin';
  script.onload = function() {
    tinymce.init({
      selector: '.wysiwyg-ar',
      directionality: 'rtl',
      language: 'ar',
      height: 300,
      plugins: 'lists link image table code directionality',
      toolbar: 'undo redo | bold italic underline | alignright aligncenter alignleft | bullist numlist | link image table | code',
      menubar: false,
      branding: false
    });
    tinymce.init({
      selector: '.wysiwyg-en',
      directionality: 'ltr',
      language: 'en',
      height: 300,
      plugins: 'lists link image table code directionality',
      toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code',
      menubar: false,
      branding: false
    });
  };
  document.head.appendChild(script);
})();
