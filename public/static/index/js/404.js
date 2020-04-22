// For reloading the animaiton :)
$('.reload-button').on('click', function() {
  $('.animated').removeClass('animated');
  setTimeout(function() {
    $('.rocket').addClass('animated');
    $('.stars').addClass('animated');
  }, 100);
})