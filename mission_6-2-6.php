<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>首都圏近郊の山(ユーザー情報の編集)</title>
	<style> h1 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		h1 {text-align:center}
		h2 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		div {font-family: 'メイリオ', Meiryo, }
		div {text-align:center}
		body {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		body {background-color: #90ee90; }</style>
</head>
<body>
<?php
//ユーザー情報の編集のボタンが押された場合
if(isset($_POST['edit'])){
	$pas4 = isset($_POST['pas4']) ? $_POST['pas4'] : '';
	$count = 0;

	//データベースへのアクセス
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql = 'SELECT * FROM userdata';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($row['password']==$pas4){
			$editnum = $row['id'];
			$a = $row['username'];
			$b = $row['toshi'];
			$c = $row['reki'];
			$d = $row['hin'];
			$e = $row['mail'];
			echo "以下のフォームの項目において修正したい箇所を直してください。<br>
";
			echo "内容が正しければ送信ボタンを押してください。<br>";
			$count = 1;
		}
	}
	if($count == 0){
		echo "<h1>"."パスワードが正しくありません。ブラウザを戻ってもう一度パスワードを入力してください。"."</h1>";
	}
}
?>
<form method="POST" action="send_test.php"><br>
	ユーザー名：<input type="text" name="user" size="30" value="<?php if(isset($a)){echo $a;}?>"><br>
	メールアドレス:<input type="text" name="mail" size="50" value="<?php if(isset($e)){echo $e;}?>"><br>
	パスワード：<input type="password" name="pas" size="20" value="<?php if(isset($pas4)){echo $pas4;}?>"><br>
	パスワード（確認）：<input type="password" name="kaku" size="20" value="<?php if(isset($pas4)){echo $pas4;}?>"><br>
	年齢：<input type="number" name="toshi" value="<?php if(isset($b)){echo $b;}?>"min="10" max="100"><br>※半角数字でご記入ください<br>
	登山歴：<select name="reki" value="<?php if(isset($c)){echo $c;}?>">
		<option value="1年未満" label="1年未満">1年未満</option>
		<option value="1年以上3年未満" label="1年以上3年未満">1年以上3年未満</option>
		<option value="3年以上5年未満" label="3年以上5年未満">3年以上5年未満</option>
		<option value="5年以上10年未満" label="5年以上10年未満">5年以上10年未満</option>
		<option value="10年以上" label="10年以上">10年以上</option></select><br>
	登山頻度：<select name="hin" value="<?php if(isset($d)){echo $d;}?>">
		<option value="普段は登らない" label="普段は登らない">普段は登らない</option>
		<option value="年に1回程度" label="年に1回程度">年に1回程度</option>
		<option value="年に3,4回程度" label="年に3,4回程度">年に3,4回程度</option>
		<option value="月に1回程度" label="月に1回程度">月に1回程度</option>
		<option value="月に2回程度" label="月に2回程度">月に2回程度</option>
		<option value="毎週" label="毎週">毎週</option></select><br><br>
	<input type="hidden" name="num" value="<?php if(isset($editnum)){echo $editnum;}?>">
	<input type="submit" name="send1" value="送信"><br><br>
</form>
</body>
</html>
