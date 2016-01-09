<?php
session_start();
ob_start();
try {
     $db = new PDO("mysql:host=localhost;dbname=todo;charset=utf8", "root", "");
} catch ( PDOException $e ){
     print $e->getMessage();
}
function make_safe($deger) 
{
   $deger = strip_tags(mysql_real_escape_string(trim($deger)));
   return $deger; 
}
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Todo List</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/cover.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Todo List</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li><a href="index.php">Anasayfa</a></li>
                  <li class="active"><a href="uye-girisi.php">Üye Girişi</a></li>
                  <li><a href="uye-ol.php">Üye Ol</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Üye Girişi</h1>
          <?php
          if ($_POST){
            if (isset($_POST["email"])){
              $email=make_safe($_POST["email"]);
            }
            if (isset($_POST["password"])){
              $password=make_safe($_POST["password"]);
            }
            $query = $db->query("Select * From uye Where email = '{$email}' And password = '{$password}'")->fetch(PDO::FETCH_ASSOC);
            if ( $query ){
              $_SESSION["giris"] = "true";
              $_SESSION["email"] = $email;
              $_SESSION["password"] = $password;
              $_SESSION["name"] = $query["name"];
              $_SESSION["uid"] = $query["id"];
                //print_r($query); 
                print '
                <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                  ×
                </button>
                <h4>
                  Başarılı!
                </h4> <strong>Giriş Başarılı!</strong> <a href="index.php">Yönlendiriliyorsunuz</a>.
              </div>';
              header("Refresh: 2; url=index.php");
            }
            else{
              print '
                <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                  ×
                </button>
                <h4>
                  Hata!
                </h4> <strong>Giriş Başarısız!</strong> E-Mail veya Şifreniz Hatalı. Tekrar Deneyiniz.
              </div>';
            }
          }else{
          ?>
            <form class="form-horizontal" action="#" method="post">
              <fieldset>
              <!-- Form Name -->
              
              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="email">E-mail</label>  
                <div class="col-md-5">
                <input id="email" name="email" type="email" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>

              <!-- Textarea -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password">Password</label>
                <div class="col-md-5">                     
                  <input id="password" name="password" type="password" placeholder="" class="form-control input-md" required>
                </div>
              </div>

              <!-- Button (Double) -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-8">
                  <button id="submit" name="submit" class="btn btn-success">Gönder</button>
                  <button id="reset" name="reset" class="btn btn-info">Temizle</button>
                </div>
              </div>

              </fieldset>
            </form>
          <?php            
          }
          ?>

            
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p> &copy; 2016 </p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>