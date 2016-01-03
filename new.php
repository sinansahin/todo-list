<?php
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
                  <li class="active"><a href="new.php">Yeni Oluştur</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">New Todo</h1>
          <?php
          if ($_POST){
            if (isset($_POST["title"])){
              $title=make_safe($_POST["title"]);
            }
            if (isset($_POST["content"])){
              $content=make_safe($_POST["content"]);
            }
            $query = $db->prepare("INSERT INTO list SET title = ?, content = ?");
            $insert = $query->execute(array($title, $content));
            if ( $insert ){
                $last_id = $db->lastInsertId();
                print '
                <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                  ×
                </button>
                <h4>
                  Başarılı!
                </h4> <strong>İşlem Başarılı!</strong> Veritabanına kayıt işlemi gerçekleştirildi.
              </div>';
            }
            else{
              print '
                <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                  ×
                </button>
                <h4>
                  Hata!
                </h4> <strong>İşlem Başarısız!</strong> Veritabanına kayıt işlemi sırasında hata oluştu. Tekrar Deneyiniz.
              </div>';
            }
          }else{
          ?>
            <form class="form-horizontal" action="#" method="post">
              <fieldset>
              <!-- Form Name -->
              
              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="title">Başlık</label>  
                <div class="col-md-5">
                <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>

              <!-- Textarea -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="content">İçerik</label>
                <div class="col-md-4">                     
                  <textarea class="form-control" id="content" name="content" required></textarea>
                </div>
              </div>

              <!-- Button (Double) -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-8">
                  <button id="submit" name="submit" class="btn btn-success">Kaydet</button>
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
              <p> &copy; 2015 </p>
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