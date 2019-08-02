<!DOCTYPE html>
<head>
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
</head>
<body>
<?php
$fp = fopen("mission_2-1.txt","a");
$comment = $_POST["comment"];

echo $comment."を受け付けました";
fputs($fp,$comment);
fclose($fp);
?>
<p></p>
</body>
</html>
