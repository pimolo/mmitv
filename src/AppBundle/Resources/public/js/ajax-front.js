$(document).ready(function() {
  $.ajax({
    url: 'get-current-video',
    success: function(data) {
      console.log(data);
      $('.youtube').html(data);
    }
  });
});
