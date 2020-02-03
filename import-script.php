<script src="./assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="./assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
  <script src="./assets/js/plugins/moment.min.js"></script>
  <script src="./assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
  <!-- Control Center for Paper Kit: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/paper-kit.js?v=2.2.0" type="text/javascript"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJ7hrXjF4JwMSSxcc_x66XIuiNIzWO97c&callback=initMap"
  type="text/javascript"></script>
  <script>

$(document).ready(function() {

  if ($("#datetimepicker").length != 0) {
    $('#datetimepicker').datetimepicker({
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      }
    });
  }

  function scrollToDownload() {

    if ($('.section-download').length != 0) {
      $("html, body").animate({
        scrollTop: $('.section-download').offset().top
      }, 1000);
    }
  }
   $('.btn-checklog').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'src/checklog.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
          if(response == "1")
            window.location.href="login.php";
        });
    });

});

function OnClickLike(bid,memid) {

    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              if(this.responseText == "1"){
                var els = document.getElementsByClassName('like'+bid);

                Array.prototype.forEach.call(els, function(el) {
                    el.innerHTML = parseInt(el.innerHTML)+1;
                });
              }
            }
        };
        xmlhttp.open("GET", "src/member_like.php?band_id=" + bid +"&member_id=" + memid, true);
        xmlhttp.send();
}

</script>