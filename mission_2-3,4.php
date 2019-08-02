<!DOCTYPE html>
<html lang = “ja”>


<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>mission_2-4</title>
</head>


<body>
<form method="POST" action="mission_2-3,4.php">
	コメント：<textarea name="comment" placeholder="コメント" ></textarea><br>
	<input type="submit" value="送信">
</form>


</body>
</html>

<?php
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';

if('' != $comment){

      $fp = fopen("mission_2-4.txt","a");  //ファイル更新
      fwrite($fp,$comment."\n");

      $ret_array = file("mission_2-4.txt");

      echo '<br>';

      foreach($ret_array as $x){    //ループさせて表示
           echo $x;
           echo '<br>';
      }

      fclose($fp);
}

else{
    $fp = fopen("mission_2-4.txt","a");
    fwrite($fp,$comment."\n");

      $ret_array = file("mission_2-4.txt");

      echo '<br>';

      foreach($ret_array as $x){    //ループさせて表示
           echo $x;
           echo '<br>';
      }

      fclose($fp);
}
?>

