</div><br><br>

<div class="col-md-12 text-center">&copy; copyright 2018 - Bishal's Boutique </div>

<script>
  $(window).scroll(function(){
    var vscroll = $(this).scrollTop();
    $('#logotext').css({
      'transform' : "translate(0px, "+vscroll/2+"px)"
    });

    var lscroll = $(this).scrollTop();
    $('#back-flower').css({
      'transform' : "translate("+lscroll/5+"px, -"+lscroll/12+"px)"
    });

    var rscroll = $(this).scrollTop();
    $('#fore-flower').css({
      'transform' : "translate(-"+rscroll/5+"px, -"+rscroll/2+"px)"
    });

  });

  function detailsmodal(id){
    var data = {"id" : id};
    jQuery.ajax({
      url : <?=BASEURL;?>+ 'includes/detailsmodal.php',
      method : "post",
      data : data,
      success : function(data){
        jQuery('body').prepend(data);
        jQuery('#details-modal').modal('toggle');
      },
      error : function(){
        alert("Something went wrong!");
      }
    });
  }
</script>
</body>
</html>
