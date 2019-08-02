<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>mission_3-3</title>
</head>
<body>
<form method="POST" action="mission_3-3.php">
	名前：<textarea name="name" placeholder="名前を入力してください" ></textarea><br>
        コメント:<textarea name="comment" placeholder="コメントを入力してください" ></textarea><br>
	<input type="submit" name="send" value="送信">
        <br><br>    
</form>
<form method="POST" action="mission_3-3.php">
        削除:<textarea name="erase" placeholder="削除番号" ></textarea><br>
        <input type="submit" name="delete" value="送信"><br>
</form>
<?php

//投稿された場合の処理
if(isset($_POST['send'])){
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    //通常の処理
    if('' != $comment&&'' != $name){

        $fp = fopen("mission_3-3.txt","a");
        $ret_array = file("mission_3-3.txt");
        $date = date('Y/m/d/h:i:s');  //日付自動入力
        $number = count($ret_array) + 1;
        
        fwrite($fp,$number."<>".$name."<>".$comment."<>".$date."\n");  //テキストファイルへの書き込み
        $ret_array = file("mission_3-3.txt");

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
    
    //記入なしでの送信処理
    else{
        $fp = fopen("mission_3-3.txt","w");
        $ret_array = file("mission_3-3.txt");
        
        foreach($ret_array as $x){
            echo $x;
            echo '<br>';
        }
        fclose($fp);
    }
}

//削除のボタンが押された場合の処理
if(isset($_POST['delete'])){
    $erase = isset($_POST["erase"]) ? $_POST["erase"] : '';
    $del = file("mission_3-3.txt");
    $a = count($del);

    $fp = fopen("mission_3-3.txt","w");

    for($i = 0; $i < count($del); $i++){
        $a = explode("<>",$del[$i]);        //配列の要素を<>で区切る
        if($a[0] != $erase){
            fwrite($fp,$del[$i]."\n");
            foreach($a as $c){
                echo "$c";
                echo " ";
            }
            echo "<br>";
        }
        else{
            for($j = $i; $j < count($del)-1; $j++){
                $del[$j] = $del[$j+1];
                fwrite($fp,$del[$j]."\n");
                $y = explode("<>",$del[$j]);
                foreach($y as $b){
                    echo "$b";
                    echo " ";
                }
                echo "<br>";
                
            }
        break;
        }
    }
    fclose($fp);

}
?>
</body>
</html>


