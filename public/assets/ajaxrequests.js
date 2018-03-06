

$( document ).ready(function () {
  $('#add-banner').on( "click", registerBanner);
});

function registerBanner() {
  $.ajax({
    type: "GET",
    url: 'ajax.php',
    data: {banner_name: 'Wayne', banner_path: 'aa', start_date: 'Ireland', end_date: ''},
    success: function(data){
        alert(data);
    }
  });

}
