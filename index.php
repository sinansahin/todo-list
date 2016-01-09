<?php
try {
     $db = new PDO("mysql:host=localhost;dbname=todo;charset=utf8", "root", "");
} catch ( PDOException $e ){
     print $e->getMessage();
}
session_start();
ob_start();
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
            <?php
              if(!isset($_SESSION["giris"])){
                print('
                  <h3 class="masthead-brand">Todo List</h3>');
              }else{
                print("
                  <h3 class='masthead-brand'>".$_SESSION["name"]." Todo Lists</h3>"); 
              }
              ?>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="index.php">Anasayfa</a></li>
                  <?php
                  if(!isset($_SESSION["giris"])){
                    print('
                      <li><a href="uye-girisi.php">Üye Girişi</a></li>
                      <li><a href="uye-ol.php">Üye Ol</a></li>
                      ');
                  }else{
                    print('
                      <li><a href="new.php">Yeni Oluştur</a></li>
                      <li><a href="uye-cikis.php">Çıkış Yap</a></li>
                      ');
                  }
                  ?>
                  
                  
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">List Todo</h1>
            <?php
            if(isset($_SESSION["giris"])){
            if ($_GET){
              if (isset($_GET["islem"])){
                if ($_GET["islem"] == "sil"){
                  if (isset($_GET["id"])){
                    $id = $_GET["id"];
                    $query_delete = $db->prepare("DELETE FROM list WHERE id = ?");
                    $delete = $query_delete->execute(array($id));
                    if($delete){
                      print '
                            <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                              ×
                            </button>
                            <h4>
                              Başarılı!
                            </h4> <strong>İşlem Başarılı!</strong> Veritabanından '.$id.' numaralı kayıt silindi.
                          </div>';
                    }else{
                      print '
                            <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                              ×
                            </button>
                            <h4>
                              Hata!
                            </h4> <strong>İşlem Başarısız!</strong> Veritabanından silme işlemi sırasında hata oluştu. Tekrar Deneyiniz.
                          </div>';
                    }
                  }
                }
              }
            }

            $query_select = $db->query("SELECT * FROM list Where uye_id = '{$_SESSION["uid"]}'", PDO::FETCH_ASSOC);
            if ( $query_select->rowCount() ){
              print("<table class='table '>");
              print("<thead><tr><th>Başlık</th><th>#</th></tr></thead><tbody>");
                 foreach( $query_select as $row ){
                      print("<tr>");
                      print("<td>".$row['title']."</td><td><a href='?islem=sil&id=".$row['id']."' class='btn btn-info'>Sil</a></td>");
                      print("</tr>");
                 }
              print("</tbody></table>");
            }
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