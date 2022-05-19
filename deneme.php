<html>

<head>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    function save3() {
      $("#user_id").val(prompt("Give the UserId:"))
      $("#book_id").val(prompt("Give the BookId:"))
      $("#game_id").val(prompt("Give the GameId:"))
      $("#site_id").val(prompt("Give the SiteId:"))
    }
  </script>

</head>

<body>

<p align="center">example</p>
<table align="center" width="730">
  <tr>
    <td align="center">
      <div>
        <table class="blueTable" style="float: left">
          <thead>
          <tr>
            <th colspan="1"><u>Menu</u></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><input type="button" value="New" id="new" onclick="new1()" class="button12" /></td>
          </tr>
          <tr>
            <td><input type="button" value="Load" id="load" onclick="load2()" class="button12" /></td>
          </tr>
          <tr>
            <td>
              <form name="SaveGame" id="SaveGame" method="post" action="#" enctype="multipart/form-data">
                <input type="submit" value="Save" id="save" onclick="save3()" class="button12" />
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="book_id" id="book_id">
                <input type="hidden" name="game_id" id="game_id">
                <input type="hidden" name="site_id" id="site_id">
              </form>
              <script>
                $("#SaveGame").submit(function (e) {


                  var form = $(this);
                  var url = form.attr('action');

                  $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function (data) {
                      console.log(data);
                      return false;
                      alert("The game has been saved!"); // show response from the php script.
                    }
                  });

                  e.preventDefault(); // avoid to execute the actual submit of the form.
                });
              </script>
</body>

</html>

<?php
if(!empty($_POST)) {

    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
  //  $link = mysqli_connect("localhost", "root", "", "homestead");
    // Check connection


    $user_id =$_POST['user_id'];
    $book_id =$_POST['book_id'];
    $game_id =$_POST['game_id'];
    $site_id =$_POST['site_id'];

    echo $user_id;
    exit();
   // mysqli_query($link ,"INSERT INTO components (user_id, book_id, game_id, site_id) VALUES ('".$user_id."','".$book_id."','".$game_id."', '".$site_id."')") ;

    // Close connection
    echo 'Y'; exit;
}
