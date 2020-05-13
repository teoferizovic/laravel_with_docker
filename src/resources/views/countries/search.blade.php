<!DOCTYPE html>
<html>
 <head>
  <title>Simple example of autocomplete</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }
  </style>
 </head>
 <body>
  <br />
  <div class="container box">
   <h3 align="center">Search countries</h3><br />
   
   <div class="form-group">
    <input type="text" name="name" id="name" class="form-control input-lg" placeholder="Enter Country Name" />
    <div id="countryList">
    </div>
   </div>
   {{ csrf_field() }}
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

 var search = false; 

 $("#name").click(function () {
      if (search == false) {
        var output = '<ul class="dropdown-menu" style="display:block; position:relative">';
        $.ajax({
            url:"{{ route('autocomplete.fetchAll') }}",
            method:"GET",
              success:function(data){
                data.forEach(function(row) {
                  output += '<li><a href="https://www.google.com" target="_blank">'+row.name+'</a></li>'
                });
                output += '</ul>';
                $('#countryList').fadeIn();  
                $('#countryList').html(output);
              }
        });  
      } 
 }); 

 $('#name').keyup(function(){ 
      var query = $(this).val();
      if(query != '') {
         search = true;
         var _token = $('input[name="_token"]').val();
         $.ajax({
            url:"{{ route('autocomplete.fetch') }}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
              $('#countryList').fadeIn();  
              $('#countryList').html(data);
            }
          });
      } else {
         $('#countryList').fadeOut();
         search = true;
      }
  });

  $(document).on('click', 'li', function(){  
      $('#name').val($(this).text());  
      $('#countryList').fadeOut();  
  });  

});
</script>
