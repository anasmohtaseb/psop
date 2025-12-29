// Summernote CDN loader for admin competition forms
(function() {
  var link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css';
  document.head.appendChild(link);

  var script = document.createElement('script');
  script.src = 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js';
  script.onload = function() {
    $('.wysiwyg-ar').summernote({
      height: 300,
      lang: 'ar-AR',
      direction: 'rtl',
      placeholder: 'اكتب الوصف التفصيلي بالعربية...',
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'table']],
        ['view', ['codeview']]
      ]
    });
    $('.wysiwyg-en').summernote({
      height: 300,
      lang: 'en-US',
      direction: 'ltr',
      placeholder: 'Enter detailed description in English...',
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'table']],
        ['view', ['codeview']]
      ]
    });
  };
  document.body.appendChild(script);
})();
