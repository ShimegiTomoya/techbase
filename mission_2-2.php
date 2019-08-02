<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
</head>
<head>
  <title>mission_2-2</title>
</head>

<body>
<form method="POST" action="mission_2-2.php">
	コメント：<textarea name="comment" placeholder="コメント" ></textarea><br>
	<input type="submit" value="送信">
</form>

</body>
</html>

<?php
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';

if('' != $comment){

   if($comment == "完成"){
       echo "おめでとう";
   }

   else{
      $fp = fopen("mission_2-2.txt","a");
      echo $comment."を受け付けました";
      fputs($fp,$comment."\n");
      fclose($fp);
   }
}

else{
      $fp = fopen("mission_2-2.txt","w");
      fputs($fp,$comment."\n");
      fclose($fp);
}

?>

