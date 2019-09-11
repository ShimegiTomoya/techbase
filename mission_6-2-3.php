<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>首都圏近郊の登山</title>
	<style> h1 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		h1 {text-align:center}
		h2 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		div {font-family: 'メイリオ', Meiryo, }
		div {text-align:center}
		body {background-color: #90ee90; }</style>
</head>
<body>
<?php

$name = isset($_POST['name']) ? $_POST['name'] : '';
$pas = isset($_POST['pas']) ? $_POST['pas'] : '';
$ken = isset($_POST['ken']) ? $_POST['ken'] : '';

if(isset($_POST['send'])&&!empty($name)&&!empty($pas)){
	$count = 0;

	//データベースへのアクセス
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//データベースでユーザー名とパスワードを探す
	$sql = 'SELECT * FROM userdata';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($name==$row['username']){
			$count = 1;
			if($pas==$row['password']){
				$count = 2;
			}
		}
	}

	if($count==2){
		$url = "https://tb-210089.tech-base.net/mission_6-2-4.php";
		$conn = curl_init($url);
		curl_setopt($conn, CURLOPT_URL, $url); //取得するURLを指定
		$res =  curl_exec($conn);
		curl_close($conn); //セッションの終了
		
	}
	elseif($count==1){
		echo 'パスワードが違います';
	}
	else{
		echo 'ユーザー名をお確かめください';
	}
}
elseif(isset($_POST['send'])){
	echo '未入力項目があります';
}
else{
	echo "error";
}
?>
</body>
</html>
