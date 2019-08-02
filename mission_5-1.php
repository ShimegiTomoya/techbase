<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>mission_5-1</title>
</head>
<body>
<?php
	//編集ボタンが押されたとき
	if(isset($_POST['edit'])&&$_POST['pas3']=="tttt"){
		$editnum = isset($_POST['editnum']) ? $_POST['editnum'] : '';

		$dsn = 'データベース名';
		$user = 'ユーザー名';
		$password = 'パスワード';
		$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

		$sql = 'SELECT * FROM tbtest';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if($editnum == $row['id']){
				$name = $row['name'];
				$comment = $row['comment'];
				break;
			}
		}
	}
	else if(isset($_POST['edit'])&&$_POST['pas3']!="tttt"){
		echo "<h2>パスワードが違います</h2>";
	}
?>
<form method="POST" action="mission_5-1.php">
	名前：<input type="text" name="name" value = "<?php if(isset($name)){echo $name;}?>" ><br>
        コメント:<input type="text" name="comment" value = "<?php if(isset($comment)){echo $comment;}?>" ><br>
	パスワード：<input type="password" name="pas1" ><br>
        <input type="hidden" name="num" value="<?php if(isset($editnum)){echo $editnum;}?>">
	<input type="submit" name="send" value="送信">
        <br><br>    
</form>
<form method="POST" action="mission_5-1.php">
        削除:<input type="text" name="erase" placeholder="削除番号" ><br>
	パスワード:<input type="text" name="pas2"><br>
        <input type="submit" name="delete" value="削除">
        <br><br>
</form>
<form method="POST" action="mission_5-1.php">
        編集:<input type="text" name="editnum" placeholder="編集番号" ><br>
	パスワード:<input type="text" name="pas3"><br>
        <input type="submit" name="edit" value="編集"><br>
</form>
<?php
	//データベースへのアクセス
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	if(!isset($_POST['send'])&&!isset($_POST['delete'])&&!isset($_POST['edit'])){
		//テーブルがなければ作成
		$sql = "CREATE TABLE IF NOT EXISTS tbtest"
		." ("
		. "id INT AUTO_INCREMENT PRIMARY KEY,"
		. "name char(32),"
		. "comment TEXT,"
		. "creation_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP"
		.");";
		$stmt = $pdo->query($sql);

		//selectによってinsertしたデータの表示
		$sql = 'SELECT * FROM tbtest';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['creation_time']. '<br>';
			echo "<hr>";
		}
	}
	//投稿フォームが押された時の処理
	if(isset($_POST['send'])&&empty($_POST['num'])&&$_POST['pas1']=="tttt"){
		//フォームからのデータを受け取る
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$comment = isset($_POST['comment']) ? $_POST['comment'] : '';

		//通常の処理(フォーム内が空文でないとき)
		if('' != $comment&&'' != $name){

			//データベースへの入力
			$sql1 = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
			$sql1 -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql1 -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql1 -> execute();

			//データの表示
        		$sql1 = 'SELECT * FROM tbtest';
			$stmt = $pdo->query($sql1);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				//$rowの中にはテーブルのカラム名が入る
				echo $row['id'].',';
				echo $row['name'].',';
				echo $row['comment'].',';
				echo $row['creation_time'].'<br>';
			echo "<hr>";
			}
		}
		//記入なしでの送信処理
		else{
        		$sql1 = 'SELECT * FROM tbtest';
			$stmt = $pdo->query($sql1);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				//$rowの中にはテーブルのカラム名が入る
				echo $row['id'].',';
				echo $row['name'].',';
				echo $row['comment'].',';
				echo $row['creation_time'].'<br>';
			echo "<hr>";
			}
		}
	}
	//hiddenに値が入っている場合
	else if(isset($_POST['send'])&&isset($_POST['num'])&&$_POST['pas1']=="tttt"){
		$id = isset($_POST['num']) ? $_POST['num'] : ''; //変更する投稿番号
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
		$sql = 'update tbtest set name=:name,comment=:comment where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$sql1 = 'SELECT * FROM tbtest';
		$stmt = $pdo->query($sql1);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['creation_time'].'<br>';
			echo "<hr>";
		}
	}
	else if(isset($_POST['send'])&&$_POST['pas1']!="tttt"){
		echo "<h2>パスワードが違います</h2>";
	}


	//削除のボタンが押された場合の処理
	if(isset($_POST['delete'])&&$_POST['pas2']=="tttt"){
		$erase = isset($_POST["erase"]) ? $_POST["erase"] : '';
		$id = $erase;
		$sql1 = 'delete from tbtest where id=:id';
		$stmt = $pdo->prepare($sql1);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$sql = 'SELECT * FROM tbtest';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//データの表示
        		$sql1 = 'SELECT * FROM tbtest';
			$stmt = $pdo->query($sql1);
			$results = $stmt->fetchAll();
				//$rowの中にはテーブルのカラム名が入る
				echo $row['id'].',';
				echo $row['name'].',';
				echo $row['comment'].',';
				echo $row['creation_time'].'<br>';
			echo "<hr>";
		}
	}
	else if(isset($_POST['delete'])&&$_POST['pas2']!="tttt"){
		echo "<h2>パスワードが違います</h2>";
	}
?>
