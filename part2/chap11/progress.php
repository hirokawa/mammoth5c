<?php
session_start();
if (isset($_GET['key'])) { // Ajaxサーバ側処理
  $status = $_SESSION[ini_get("session.upload_progress.prefix").$_GET['key']];
  header('Content-type: application/json; charset=utf-8');
  echo json_encode($status);  // JSON形式でステータスを返す
  exit;
}
?>
<script type="text/javascript"
    src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function() {  
 setInterval(function() {
   $.get("progress.php?key=<?php echo $_GET['id'];?>",function(data) {
     var percent = parseInt(data.bytes_processed/data.content_length*100);
     $('#outer').fadeIn(100);
     $("#inner").width(percent + "%");
     $('#completed').html(percent +"%");
     }, "json")}, 500);
});
</script>
<body>
<div id="outer" 
    style="width:300px;height:20px;border:1px solid black;display:block;">
  <div id="inner" style=
    "position:relative;height:20px;background-color:purple;width:0%;">
  <div id="completed" style="color: white"></div>
  </div>
</div></body>