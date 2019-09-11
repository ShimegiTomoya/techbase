<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>首都圏近郊の山</title>
	<style> h1 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		h1 {text-align:center}
		h2 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		h4 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		div {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		div {text-align:left}
		body {background-color: #90ee90; }</style>
</head>
<body>
<h1>首都圏近郊の山</h1>
<hr size="1" color="black">
<div>この度は首都圏近郊の山のサイトにログインいただき誠にありがとうございます。<br>
下記の検索フォームから首都圏近郊の山を検索してください。
<hr size="1" color="black">
<h2>山の検索</h2>

<form method="POST" action="mission_6-2-5.php">

	<h4>(1)山の所在地</h4>
		<input type="checkbox" name="syo[]" value="神奈川県" label="神奈川県">神奈川県
		<input type="checkbox" name="syo[]" value="静岡県" label="静岡県">静岡県
		<input type="checkbox" name="syo[]" value="東京都" label="東京都">東京都
		<input type="checkbox" name="syo[]" value="山梨県" label="山梨県">山梨県
		<input type="checkbox" name="syo[]" value="長野県" label="長野県">長野県
		<input type="checkbox" name="syo[]" value="埼玉県" label="埼玉県">埼玉県
		<input type="checkbox" name="syo[]" value="群馬県" label="群馬県">群馬県
		<input type="checkbox" name="syo[]" value="栃木県" label="栃木県">栃木県
		<input type="checkbox" name="syo[]" value="茨城県" label="茨城県">茨城県
		<input type="checkbox" name="syo[]" value="千葉県" label="千葉県">千葉県<br><br>

	<h4>(2)新宿駅から電車を使った場合の登山口にたどり着くまでの目安時間</h4><input type="number" name="inf1" min="0" max="1000">分以上<input type="number" name="sup1" min="0" max="1000">分未満<br>
	(半角数字でご記入ください)<br><br>

	<h4>(3)登山するのにかかる時間</h4><input type="number" name="inf2" min="0" max="1000">分以上<input type="number" name="sup2" min="0" max="1000">分未満<br>
	(半角数字でご記入ください)<br><br>

	<h4>(4)標高</h4><input type="number" name="inf3" min="0" max="4000">m以上<input type="number" name="sup3" min="0" max="4000">m未満<br>
	(半角数字でご記入ください)<br><br>

	<h4>(5)おすすめの季節</h4><select name="ki">
		<option value="選択しない" label="選択しない">選択しない</option>
		<option value="春" label="春">春</option>
		<option value="夏" label="夏">夏</option>
		<option value="秋" label="秋">秋</option>
		<option value="冬" label="冬">冬</option></select><br><br>
	<input type="submit" name="kensaku" value="検索">
<br><br><br><hr size="1" color="black">
</form>

<form method="POST" action="mission_6-2-6.php">
<h2>ユーザー情報の修正</h2><br>
以下のフォームにパスワードを打ち込むと自信のユーザー情報を変更することができます。<br>
パスワード:<input type="password" name="pas4"><br>
<input type="submit" name="edit" value="修正"><br><br>
</form>
<hr size="1" color="black">
<form method="POST" action="mission_6-2-4.php">
<h2>山に関する掲示板</h2><br>
こちらは首都圏近郊の山に関する掲示板となっております。<br>
首都圏近郊の山に関する情報を掲載してください。<br><br>
投稿内容:<input type="text" name="comment"><br>
パスワード:<input type="password" name="pas1" size="20"><br>
<input type="submit" name="toukou" value="投稿"><br><br>
</form>


<form method="POST" action="mission_6-2-4.php">
自分が投稿したものを削除したい場合は削除したい投稿のユーザー名の左側にある番号を以下のフォームに入力してください。<br><br>
番号:<input type="text" name="num" size="10"><br>
パスワード:<input type="password" name="pas2"><br>
<input type="submit" name="del" value="削除"><br><br>
</form>
<h4>-------------------------------------------------掲示板-------------------------------------------------</h4><br>
<?php
//データベースアクセス
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//データベース作成(投稿機能:id,usrname,reki,hindo,)
	$sql = "CREATE TABLE IF NOT EXISTS toukou"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(30),"
	. "toshi char(5),"
	. "reki char(10),"
	. "hindo char(15),"
	. "creation_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,"
	. "comment TEXT"
	.");";
	$stmt = $pdo->query($sql);

if(isset($_POST['toukou'])){
//投稿された場合の処理
	if(!empty($_POST['pas1'])&&!empty($_POST['comment'])){
		$pas1 = isset($_POST['pas1']) ? $_POST['pas1'] : '';
		$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
		$count = 0;

		//userdataから必要な情報を取り出す
		$sql ='SELECT * FROM userdata';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach($results as $row){
			if($row['password']==$pas1){
				$name = $row['username'];
				$toshi = $row['toshi'];
				$reki = $row['reki'];
				$hin = $row['hin'];
				$count = 1;
			}
		}
		if($count==1){
			//toukouにデータを入力
			$sql = $pdo -> prepare("INSERT INTO toukou (name, toshi, reki, hindo, comment) VALUES (:name, :toshi, :reki, :hindo, :comment)");
			$sql -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql -> bindParam(':toshi', $toshi, PDO::PARAM_STR);
			$sql -> bindParam(':reki', $reki, PDO::PARAM_STR);
			$sql -> bindParam(':hindo', $hin, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> execute();

			//toukouの全データを降べきの順で表示
			$max = 0;
			$sql ='SELECT * FROM toukou';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach($results as $row){
				if($max < $row['id']){
					$max = $row['id'];
				}
			}
			for($i = $max; $i >= 1; $i--){
				foreach($results as $row){
					if($row['id']==$i){
						echo $row['id'].'　';
						echo "ユーザー名:".$row['name'].'　';
						echo $row['toshi']."歳".'　';
						echo "登山歴:".$row['reki'].'　';
						echo "登山頻度:".$row['hindo'].'　';
						echo "コメント日時:".$row['creation_time'].'<br>';
						echo '　 '."コメント内容:".$row['comment'];
						echo '<br><br>';
					}
				}
			}

		}
		else{
			echo "パスワードが違います";
		}
	}
	else{
		echo "入力に不備があります";
	}
}
elseif(isset($_POST['del'])){
	//delボタンが押された時の処理
	$pas2 = isset($_POST['pas2']) ? $_POST['pas2'] : '';
	$pas3 ="NULL";
	$del = isset($_POST['num']) ? $_POST['num'] : '';
	$count = 0;

	//$delの値から投稿者のユーザー名をとってくる
	$sql ='SELECT * FROM toukou';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
		if($del==$row['id']){
			$name = $row['name'];
		}
	}
	$sql1 ='SELECT * FROM userdata';
	$stmt = $pdo->query($sql1);
	$result = $stmt->fetchAll();
	foreach($result as $row){
		if($name==$row['username']){
			$pas3 = $row['password'];
		}
	}
	if($pas3==$pas2){
		//passwordが投稿者のパスワードと一致していた場合の処理
		$sql2 = 'delete from toukou where id=:id';
		$stmt = $pdo->prepare($sql2);
		$stmt->bindParam(':id', $del, PDO::PARAM_INT);
		$stmt->execute();
	}
	else{
		echo "パスワードが違います".'<br>';
	}
	//掲示板の表示
	$max = 0;
	$sql ='SELECT * FROM toukou';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
		if($max < $row['id']){
			$max = $row['id'];
		}
	}
	for($i = $max; $i >= 1; $i--){
		foreach($results as $row){
			if($row['id']==$i){
				echo $row['id'].'　';
				echo "ユーザー名:".$row['name'].'　';
				echo $row['toshi']."歳".'　';
				echo "登山歴:".$row['reki'].'　';
				echo "登山頻度:".$row['hindo'].'　';
				echo "コメント日時:".$row['creation_time'].'<br>';
				echo '　 '."コメント内容:".$row['comment'];
				echo '<br><br>';
			}
		}
	}
}
else{
	//toukouの全データを降べきの順で表示
	$max = 0;
	$sql ='SELECT * FROM toukou';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
		if($max < $row['id']){
			$max = $row['id'];
		}
	}
	for($i = $max; $i >= 1; $i--){
		foreach($results as $row){
			if($row['id']==$i){
				echo $row['id'].'　';
				echo "ユーザー名:".$row['name'].'　';
				echo $row['toshi']."歳".'　';
				echo "登山歴:".$row['reki'].'　';
				echo "登山頻度:".$row['hindo'].'　';
				echo "コメント日時:".$row['creation_time'].'<br>';
				echo '　 '."コメント内容:".$row['comment'];
				echo '<br><br>';
			}
		}
	}
}
?>
</div>
</body>
</html>
