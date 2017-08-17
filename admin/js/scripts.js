tinymce.init({ selector:'textarea' });
$(document).ready(function() {
  $('#select-all-checkbox').click(function(e) {
    if (this.checked) {
      $('.checkbox').each(function() {
        this.checked = true;
      });
    } else {
      $('.checkbox').each(function() {
        this.checked = false;
      });
    }
  });
});
