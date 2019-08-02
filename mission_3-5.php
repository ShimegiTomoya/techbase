<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>mission_3-5</title>
</head>
<body>
<?php
if(isset($_POST['edit'])){
	$edit = isset($_POST['editnum']) ? $_POST['editnum'] : '';
	$pas3 = isset($_POST["pas3"]) ? $_POST["pas3"] : '';
	if($pas3=="tttt"){
	$fp = fopen("mission_3-5.txt","a");
	$file = file("mission_3-5.txt");
	foreach($file as $x){
		$y = explode("<>", $x);
		if($y[0]==$edit){
			break;
		}
	}
	fclose($fp);
	}
}
?>
<form method="POST" action="mission_3-5.php">
	名前：<input type="text" name="name" value="<?php if(isset($y)){echo $y[1];}?>"><br>
        コメント:<input type="text" name="comment" value="<?php if(isset($y)){echo $y[2];}?>"><br>
	パスワード:<input type="password" name="pas1"><br>
        <input type="hidden" name="num" value="<?php if(isset($y)){echo $y[0];}?>">
	<input type="submit" name="send" value="送信">
        <br><br>
</form>
<form method="POST" action="mission_3-5.php">
        削除:<input type="text" name="erase"><br>
        パスワード:<input type="password" name="pas2"><br>
        <input type="submit" name="delete" value="削除">
        <br><br>
</form>
<form method="POST" action="mission_3-5.php">
        編集:<input type="text" name="editnum"><br>
        パスワード:<input type="password" name="pas3"><br>
        <input type="submit" name="edit" value="編集"><br>
</form>
<?php
$num = isset($_POST["num"]) ? $_POST["num"] : '';
if(isset($_POST['send'])&&empty($num)){
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $pas1 = isset($_POST['pas1']) ? $_POST['pas1'] : '';

    //通常の処理
    if('' != $comment&&'' != $name&&'' != $pas1){

        $fp = fopen("mission_3-5.txt","a");
        $ret_array = file("mission_3-5.txt");
        $date = date('Y/m/d/h:i:s');  //日付自動入力
        $number = count($ret_array) + 1;
        if($pas1=="tttt"){
            fwrite($fp,$number."<>".$name."<>".$comment."<>".$date."\n");  //テキストファイルへの書き込み
        }
        else{
            echo "パスワードが違います";
        }
        $ret_array = file("mission_3-5.txt");

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
        $fp = fopen("mission_3-5.txt","a");
        $ret_array = file("mission_3-5.txt");
        
        foreach($ret_array as $x){
            $y = explode("<>",$x);
            foreach($y as $z){
                echo "$z";
                echo " ";
            }
        echo "<br>";
        fclose($fp);
        }
    }
}
//hiddenが入っているとき
else if(isset($_POST['send'])&&!empty($num)){
$pas1 = isset($_POST["pas1"]) ? $_POST["pas1"] : '';
if($pas1=="tttt"){
    $num = isset($_POST["num"]) ? $_POST["num"] : '';
    $file = file("mission_3-5.txt");
    $fp = fopen("mission_3-5.txt","w");
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    foreach($file as $x){
        $a = explode("<>",$x);
        if($a[0] == $num){
            fwrite($fp,$num."<>".$name."<>".$comment."<>".date('Y/m/d/h:i:s')."\n");
            echo $num." ".$name." ".$comment." ".date('Y/m/d/h:i:s')."\n";
            echo "<br>";
        }
        else{
            fwrite($fp,$x);
            $z = explode("<>",$x);
            foreach($z as $b){
                echo $b;
                echo " ";
            }
            echo "<br>";
        }
    }
    fclose($fp);
}
else{
    echo "パスワードが違います";
}
}
//削除のボタンが押された場合の処理
if(isset($_POST['delete'])){
    $erase = isset($_POST["erase"]) ? $_POST["erase"] : '';
    $pas2 = isset($_POST["pas2"]) ? $_POST["pas2"] : '';
    $del = file("mission_3-5.txt");
    $a = count($del);
if($pas2=="tttt"){
    $fp = fopen("mission_3-5.txt","w");

    for($i = 0; $i < count($del); $i++){
        $a = explode("<>",$del[$i]);        //配列の要素を<>で区切る
        if($a[0] != $erase){
            fwrite($fp,$del[$i]);
            foreach($a as $c){
                echo "$c";
                echo " ";
            }
            echo "<br>";
        }
        else{
            for($j = $i; $j < count($del)-1; $j++){
                $del[$j] = $del[$j+1];
                fwrite($fp,$del[$j]);
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
}
elseif(!isset($_POST["send"])){
    $fp = fopen("mission_3-5.txt","a");
    $file = file("mission_3-5.txt");
    foreach($file as $d){
        $f = explode("<>",$d);
        foreach($f as $g){
            echo $g;
            echo " ";
        }
        echo "<br>";
    }
    fclose($fp);
}
//最初に投稿フォームに訪れた時の処理
elseif(empty($_POST['num'])){
	$file = file("mission_3-5.txt");
	foreach($file as $x){
		$y = explode("<>",$x);
		foreach($y as $z){
			echo $z;
			echo " ";
		}
		echo "<br>";
	}
}
?>
</body>
</html>