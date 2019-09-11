<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
        <title>首都圏近郊の登山</title>
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
	$i = 0;

	//データベースへのアクセス
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


	//検索ボタンが押された場合
	if(isset($_POST['kensaku'])){

		//所在地を調べる
		if(isset($_POST['syo']) && is_array($_POST['syo'])){
			foreach( $_POST['syo'] as $value ){
				$sql = 'SELECT * FROM tozan';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach ($results as $row){
					if(strpos($row['syo'],'or')){
						$v = explode("or",$row['syo']);
						foreach($v as $w){
							if($w==$value){
								$name[$i] = $row['name'];
								$syo[$i] = $row['syo'];
								$mo[$i] = $row['mo'];
								$ac[$i] = $row['ac'];
								$ki[$i] = $row['ki'];
								$hyo[$i] = $row['hyo'];
								$me[$i] = $row['me'];
								$i = $i + 1;
							}
						}
					}
					elseif($row['syo']==$value){
						$name[$i] = $row['name'];
						$syo[$i] = $row['syo'];
						$mo[$i] = $row['mo'];
						$ac[$i] = $row['ac'];
						$ki[$i] = $row['ki'];
						$hyo[$i] = $row['hyo'];
						$me[$i] = $row['me'];
						$i = $i + 1;
					}
				}
			}
		}
		else{
			$sql = 'SELECT * FROM tozan';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				$name[$i] = $row['name'];
				$syo[$i] = $row['syo'];
				$mo[$i] = $row['mo'];
				$ac[$i] = $row['ac'];
				$ki[$i] = $row['ki'];
				$hyo[$i] = $row['hyo'];
				$me[$i] = $row['me'];
				$i = $i + 1;
			}
		}

		//新宿からの時間を調べる
		if(!empty($_POST['inf1'])){
			$inf1 = isset($_POST['inf1']) ? $_POST['inf1'] : '';
		}
		else{
			$inf1 = 0;
		}
		if(!empty($_POST['sup1'])){
			$sup1 = isset($_POST['sup1']) ? $_POST['sup1'] : '';
		}
		else{
			$sup1 = 1000;
		}

		$k = 0;
		$m = 0;

		if($i != 0){
			for($j = 0; $j <= $i - 1; $j++){
				if($ac[$j] >= $inf1){
					$name[$k] = $name[$j];
					$syo[$k] = $syo[$j];
					$mo[$k] = $mo[$j];
					$ac[$k] = $ac[$j];
					$ki[$k] = $ki[$j];
					$hyo[$k] = $hyo[$j];
					$me[$k] = $me[$j];
					$k = $k + 1;
				}
			}
			if($k != 0){
				for($l = 0; $l <= $k - 1; $l++){
					if($ac[$l] < $sup1){
						$name[$m] = $name[$l];
						$syo[$m] = $syo[$l];
						$mo[$m] = $mo[$l];
						$ac[$m] = $ac[$l];
						$ki[$m] = $ki[$l];
						$hyo[$m] = $hyo[$l];
						$me[$m] = $me[$l];
						$m = $m + 1;
					}
				}
			}
		}

		//登山するのにかかる時間を調べる
		if(!empty($_POST['inf2'])){
			$inf2 = isset($_POST['inf2']) ? $_POST['inf2'] : '';
		}
		else{
			$inf2 = 0;
		}
		if(!empty($_POST['sup2'])){
			$sup2 = isset($_POST['sup2']) ? $_POST['sup2'] : '';
		}
		else{
			$sup2 = 1000;
		}

		$n = 0;
		$o = 0;

		if($m != 0){
			for($j = 0; $j <= $m - 1; $j++){
				if($me[$j] >= $inf2){
					$name[$n] = $name[$j];
					$syo[$n] = $syo[$j];
					$mo[$n] = $mo[$j];
					$ac[$n] = $ac[$j];
					$ki[$n] = $ki[$j];
					$hyo[$n] = $hyo[$j];
					$me[$n] = $me[$j];
					$n = $n + 1;
				}
			}
			if($n != 0){
				for($l = 0; $l <= $n - 1; $l++){
					if($me[$l] < $sup2){
						$name[$o] = $name[$l];
						$syo[$o] = $syo[$l];
						$mo[$o] = $mo[$l];
						$ac[$o] = $ac[$l];
						$ki[$o] = $ki[$l];
						$hyo[$o] = $hyo[$l];
						$me[$o] = $me[$l];
						$o = $o + 1;
					}
				}
			}
		}
		//標高を調べる
		if(!empty($_POST['inf3'])){
			$inf3 = isset($_POST['inf3']) ? $_POST['inf3'] : '';
		}
		else{
			$inf3 = 0;
		}
		if(!empty($_POST['sup3'])){
			$sup3 = isset($_POST['sup3']) ? $_POST['sup3'] : '';
		}
		else{
			$sup3 = 4000;
		}
		$s = 0;
		$t = 0;

		if($o != 0){
			for($j = 0; $j <= $o - 1; $j++){
				if($hyo[$j] >= $inf3){
					$name[$s] = $name[$j];
					$syo[$s] = $syo[$j];
					$mo[$s] = $mo[$j];
					$ac[$s] = $ac[$j];
					$ki[$s] = $ki[$j];
					$hyo[$s] = $hyo[$j];
					$me[$s] = $me[$j];
					$s = $s + 1;
				}
			}
			if($s != 0){
				for($l = 0; $l <= $s - 1; $l++){
					if($hyo[$l] < $sup3){
						$name[$t] = $name[$l];
						$syo[$t] = $syo[$l];
						$mo[$t] = $mo[$l];
						$ac[$t] = $ac[$l];
						$ki[$t] = $ki[$l];
						$hyo[$t] = $hyo[$l];
						$me[$t] = $me[$l];
						$t = $t + 1;
					}
				}
			}
		}

		//おすすめの季節を調べる
		$r = 0;
		if($_POST['ki']!='選択しない'){
			$ki1 = isset($_POST['ki']) ? $_POST['ki'] : '';
			$p = 'or';
			if($t != 0){
				for($j = 0; $j <= $t - 1; $j++){
					if(strpos($ki[$j],$p)){
						$ki2 = explode("or",$ki[$j]);
						foreach($ki2 as $q){
							if($ki1==$q){
								$name[$r] = $name[$j];
								$syo[$r] = $syo[$j];
								$mo[$r] = $mo[$j];
								$ac[$r] = $ac[$j];
								$ki[$r] = $ki[$j];
								$hyo[$r] = $hyo[$j];
								$me[$r] = $me[$j];
								$r = $r + 1;
							}
						}
					}
					elseif($ki[$j]==$ki1){
						$name[$r] = $name[$j];
						$syo[$r] = $syo[$j];
						$mo[$r] = $mo[$j];
						$ac[$r] = $ac[$j];
						$ki[$r] = $ki[$j];
						$hyo[$r] = $hyo[$j];
						$me[$r] = $me[$j];
						$r = $r + 1;
					}
				}
			}
		}
		else{
			if($t != 0){
				for($j = 0; $j <= $t - 1; $j++){
					$name[$r] = $name[$j];
					$syo[$r] = $syo[$j];
					$mo[$r] = $mo[$j];
					$ac[$r] = $ac[$j];
					$ki[$r] = $ki[$j];
					$hyo[$r] = $hyo[$j];
					$me[$r] = $me[$j];
					$r = $r + 1;
				}
			}
		}
		//検索結果の表示
		if($r != 0){
			echo '<h3>'."検索結果".'</h3>';
			echo '　※新宿からの時間についてはすべて鈍行列車で行く場合の目安時間となっております。';
			echo '<hr>';
			for($j = 0; $j <= $r - 1; $j++){
				echo '<h4>'.$name[$j].'</h4><br>';
				echo $syo[$j].'<br>';
				echo "電車で行く場合の最寄り駅:".$mo[$j].'<br>';
				if($ac[$j]>=60){
					$hour = floor($ac[$j]/60);
					$minute = $ac[$j]%60;
					echo "新宿から".$hour."時間".$minute."分".'<br>';
				}
				else{
					echo "新宿から".$ac[$j]."分".'<br>';
				}
				echo "おすすめの季節:".$ki[$j].'<br>';
				echo "標高:".$hyo[$j]."m".'<br>';
				if($me[$j]>=60){
					$hour = floor($me[$j]/60);
					$minute = $me[$j]%60;
					echo "登山目安時間:".$hour."時間".$minute."分".'<br>';
				}
				else{
					echo "登山目安時間:".$me[$j]."分".'<br>';
				}
				echo '<hr>';
			}
		}
		else{
			echo "該当する山が見つかりませんでした";
		}
	}
	//意図しないアクセス
	else{
		echo "error";
	}

?>
</body>
</html>