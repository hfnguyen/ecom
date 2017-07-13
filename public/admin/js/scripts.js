$(document).ready(function(){

$('#demo').hover(
  function () {
    $(this).toggle();

 
});



});


$(document).ready(function(){

        $(".delete_link").on('click', function(){
          var id = $(this).attr("rel");
          var delete_url = "./index.php?page=orders&delete="+id;
          $(".modal-delete-link").attr("href", delete_url);
          $("#myModal").modal('show');


        });

 });


$(document).ready(function(){

        $(".delete_product").on('click', function(){
          var id = $(this).attr("rel");
          var delete_url = "./index.php?page=view_products&delete="+id;
          $(".modal-delete-link").attr("href", delete_url);
          $("#myModal").modal('show');


        });

 });

$(document).ready(function(){

        $(".delete_categories").on('click', function(){
          var id = $(this).attr("rel");
          var delete_url = "./index.php?page=view_cat&delete="+id;
          $(".modal-delete-link").attr("href", delete_url);
          $("#myModal").modal('show');


        });

 });

$(document).ready(function(){

        $(".delete_users").on('click', function(){
          var id = $(this).attr("rel");
          var delete_url = "./index.php?page=view_users&delete="+id;
          $(".modal-delete-link").attr("href", delete_url);
          $("#myModal").modal('show');


        });

 });




