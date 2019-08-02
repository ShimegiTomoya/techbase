<?php

//1-6-1
for($i = 0; $i < (19/4); $i++){
  echo 2000+($i*4);
  echo '<br>';
}

//1-6-2
$siritori = array("しりとり","りんご","ごりら","らっぱ","ぱんだ");
echo $siritori[2];
echo '<br>';
//1-6-3
$y = NULL;  //変数の初期化
foreach($siritori as $x){
  $y = $y.$x;  //現在の配列をつなげる
  echo $y;
  echo '<br>';
}
?>