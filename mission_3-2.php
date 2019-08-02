<!DOCTYPE html>
<html lang = “ja”>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>mission_3-2</title>
</head>
<body>
<form method="POST" action="mission_3-2.php">
	名前：<textarea name="name" placeholder="名前を入力してください" ></textarea><br>
        コメント:<textarea name="comment" placeholder="コメントを入力してください" ></textarea><br>
	<input type="submit" value="送信">
</form>
</body>
</html>

<?php
$name = isset($_POST['name']) ? $_POST['name'] : '';
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';


    //通常の処理
    if('' != $comment&&'' != $name){

        $fp = fopen("mission_3-2.txt","a");
        $ret_array = file("mission_3-2.txt");
        $date = date('Y/m/d/h:i:s');  //日付自動入力
        $number = count($ret_array) + 1;
        fwrite($fp,$number."<>".$name."<>".$comment."<>".$date."\n");
        $ret_array = file("mission_3-2.txt");
      
      

        foreach($ret_array as $x){
            $y = explode("<>",$x);
            foreach($y as $z){
                echo "$z";
                echo " ";
            }
            echo "<br>";
        }
        fclose($fp);
    }
    else{
        $fp = fopen("mission_3-2.txt","a");
        $ret_array = file("mission_3-2.txt");
        
        foreach($ret_array as $x){
            echo $x;
            echo '<br>';
        }
        fclose($fp);
    }

?>