<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>首都圏近郊の山</title>
	<style> h1 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		h1 {text-align:center}
		h2 {font-family: 'Yu Mincho Light','YuMincho','Yu Mincho','游明朝体'}
		div {font-family: 'メイリオ', Meiryo, }
		div {text-align:center}
		body {background-color: #90ee90; }</style>
</head>
<body>
<?php

$a = isset($_POST['mail']) ? $_POST['mail'] : '';
$b = isset($_POST['user']) ? $_POST['user'] : '';
$c = isset($_POST['pas']) ? $_POST['pas'] : '';
$d = isset($_POST['reki']) ? $_POST['reki'] : '';
$e = isset($_POST['hin']) ? $_POST['hin'] : '';
$f = isset($_POST['toshi']) ? $_POST['toshi'] : '';
$g = isset($_POST['kaku']) ? $_POST['kaku'] : '';

//通常処理
if(!empty($a)&&!empty($b)&&!empty($c)&&!empty($f)&&isset($_POST['send'])&&$c==$g){

	//データベースへのアクセス
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//データベースがなかったら作成
	$sql = "CREATE TABLE IF NOT EXISTS userdata"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "mail char(50),"
	. "username char(30),"
	. "password char(20),"
	. "toshi char(10),"
	. "reki char(15),"
	. "hin char(15)"
	.");";
	$stmt = $pdo->query($sql);

	//既存のデータと被っていないか確認
	$count1 = 0;
	$count2 = 0;
	$sql = 'SELECT * FROM userdata';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($row['username']==$b){
			$count1 = 1;
		}
		if($row['password']==$c){
			$count2 = 1;
		}
	}
	if($count1==0&&$count2==0){
		//データベースへの入力
		$sql = $pdo -> prepare("INSERT INTO userdata (mail, username, password, toshi, reki, hin) VALUES (:mail, :username, :password, :toshi, :reki, :hin)");
		$sql -> bindParam(':mail', $a, PDO::PARAM_STR);
		$sql -> bindParam(':username', $b, PDO::PARAM_STR);
		$sql -> bindParam(':password', $c, PDO::PARAM_STR);
		$sql -> bindParam(':toshi', $f, PDO::PARAM_STR);
		$sql -> bindParam(':reki', $d, PDO::PARAM_STR);
		$sql -> bindParam(':hin', $e, PDO::PARAM_STR);
		$sql -> execute();

		//メール処理
		require 'src/Exception.php';
		require 'src/PHPMailer.php';
		require 'src/SMTP.php';
		require 'setting.php';

		// PHPMailerのインスタンス生成
    		$mail = new PHPMailer\PHPMailer\PHPMailer();

    		$mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    		$mail->SMTPAuth = true;
    		$mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    		$mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    		$mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    		$mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    		$mail->Port = SMTP_PORT; // 接続するTCPポート

    		// メール内容設定
    		$mail->CharSet = "UTF-8";
    		$mail->Encoding = "base64";
    		$mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    		$mail->addAddress($a, '受信者さん'); //受信者（送信先）を追加する(アカウント設定の際に情報を受け取る)
		//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');	//必要に応じて
		//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加	//必要に応じて
		//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加	//必要に応じて
		$mail->Subject = MAIL_SUBJECT; // メールタイトル
		$mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
		$body1 = $b.'様';
		$body2 = '「首都圏近郊の登山」の事務局です。';
		$body3 = 'この度は当サイトに興味を持っていただき誠にありがとうございます。';
		$body4 = '本サイトの登録が完了しました。下記の情報はログインの際に必要となりますので外部に漏れることがないように大切に保管しておいてください。';
		$body5 = 'こちらからログインをお願いします。';
    		$body6 = '-------------------------------------------';
    		$body7 = '首都圏近郊の登山運営事務局';
    		$body8 = 'mail:メールアドレス';
    		$body9 = '↓';
    		$body10 = 'https://tb-210089.tech-base.net/mission_6-2-1.html';
    		$body11 = 'ユーザー名:'.$b;
    		$body12 = 'パスワード:(ご自身で設定されたもの)';
    
    		$mail->Body  = $body1."<br><br>".$body2."<br><br>".$body3.$body4."<br><br>".$body11."<br>".$body12."<br><br>".$body5."<br>".$body9."<br>".$body10."<br><br>".$body6."<br>".$body7."<br>".$body8."<br>".$body6; // メール本文

    		// メール送信の実行
    		if(!$mail->send()) {
    			echo "記入ミスの恐れがあります。内容を確認してから再度送信をしてください。";
    			echo "Mailer Error:" . $mail->ErrorInfo;
    		} else {
    			echo "送信が完了しました。メールを参照してください。";
			echo "<br>";
			echo "もしメールが届かなかった場合は、ブラウザを戻ってメールアドレスをご確認ください。";
    		}
	}
	elseif($count1==1){
		echo "登録しようとしたユーザー名は既に使用されているため、ブラウザを戻って別のユーザー名に変更してください。";
	}
	elseif($count2==1){
		echo "登録しようとしたパスワードは既に使用されているため、ブラウザを戻って別のパスワードに変更してください。";
	}
}

elseif(!empty($a)&&!empty($b)&&!empty($c)&&!empty($f)&&isset($_POST['send1'])&&!empty($_POST['num'])&&$c==$g){

	//データベースへのアクセス
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//データベースがなかったら作成
	$sql = "CREATE TABLE IF NOT EXISTS userdata"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "mail char(50),"
	. "username char(30),"
	. "password char(20),"
	. "toshi char(10),"
	. "reki char(15),"
	. "hin char(15)"
	.");";
	$stmt = $pdo->query($sql);

	//既存のデータと情報がかぶっていないか確認
	$count1 = 0;
	$count2 = 0;
	$sql = 'SELECT * FROM userdata';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($row['id'] != $_POST['num']){
			if($row['username']==$b){
				$count1 = 1;
			}
			if($row['password']==$c){
				$count2 = 1;
			}
		}
	}
	//$row['id']とhiddenがあっていたらデータを書き換える
	$id = isset($_POST['num']) ? $_POST['num'] : ''; //変更するユーザーのID
	if($count1==0&&$count2==0){
		//編集
		$sql = 'update userdata set mail=:mail,username=:username,password=:password,toshi=:toshi,reki=:reki,hin=:hin where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':mail', $a, PDO::PARAM_STR);
		$stmt->bindParam(':username', $b, PDO::PARAM_STR);
		$stmt->bindParam(':password', $c, PDO::PARAM_STR);
		$stmt->bindParam(':toshi', $f, PDO::PARAM_STR);
		$stmt->bindParam(':reki', $d, PDO::PARAM_STR);
		$stmt->bindParam(':hin', $e, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		//変更を知らせるメールを送る
		//メール処理
		require 'src/Exception.php';
		require 'src/PHPMailer.php';
		require 'src/SMTP.php';
		require 'setting1.php';

		// PHPMailerのインスタンス生成
    		$mail = new PHPMailer\PHPMailer\PHPMailer();

    		$mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    		$mail->SMTPAuth = true;
    		$mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    		$mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    		$mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    		$mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    		$mail->Port = SMTP_PORT; // 接続するTCPポート

    		// メール内容設定
    		$mail->CharSet = "UTF-8";
    		$mail->Encoding = "base64";
    		$mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    		$mail->addAddress($a, '受信者さん'); //受信者（送信先）を追加する(アカウント設定の際に情報を受け取る)
		//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');	//必要に応じて
		//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加	//必要に応じて
		//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加	//必要に応じて
		$mail->Subject = MAIL_SUBJECT; // メールタイトル
		$mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
		$body1 = $b.'様';
		$body2 = '「首都圏近郊の登山」の事務局です。';
		$body3 = 'この度はユーザー情報の変更が完了いたしましたので、連絡させていただきました。';
		$body4 = '今までと同様に、パスワードは大切に保管しておいてください。';
		$body5 = 'これからもよろしくお願いします。';
    		$body6 = '-------------------------------------------';
    		$body7 = '首都圏近郊の登山運営事務局';
    		$body8 = 'mail:メールアドレス';
    		$body9 = '↓';
    		$body10 = 'https://tb-210089.tech-base.net/mission_6-2-1.html';
    		$body11 = 'ユーザー名:'.$b;
    		$body12 = 'パスワード:(ご自身で設定されたもの)';
    
    		$mail->Body  = $body1."<br><br>".$body2."<br><br>".$body3.$body4."<br>".$body5."<br><br>".$body6."<br>".$body7."<br>".$body8."<br>".$body6; // メール本文

    		// メール送信の実行
    		if(!$mail->send()) {
    			echo "記入ミスの恐れがあります。内容を確認してから再度送信をしてください。";
    			echo "Mailer Error:" . $mail->ErrorInfo;
    		} else {
    			echo "送信が完了しました。メールを参照してください。";
			echo "<br>";
			echo "もしメールが届かなかった場合は、ブラウザを戻ってメールアドレスをご確認ください。";
    		}
	}
	else{
		echo "変更したユーザー名またはパスワードは既に使われています。";
	}
}
elseif($c!=$g){
	echo "パスワードを正しく入力してください";
}
//記入漏れの処理
else{
	echo "記入漏れがあります。入力しなおしてから、再度送信してください。";
}
?>
</body>
</html>
