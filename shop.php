<?
include "./lib.php";

$item_list = item_data();
$icnt = count($item_list);	//총 아이템갯수
$t_cols = 3;	//한 줄에 보일 아이템 수


?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="./style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="item_box">
	<table class="item_list">
<?
$c_cnt=0;
for($cnt=0; $cnt<$icnt; $cnt++){
	if($c_cnt==0)	echo "<tr>\n";
	if($c_cnt<3){
		echo "<td class='item_cell'><a href='./talk.php?item=item_$cnt' target=text>";
		echo "<img src='./img/".$item_list[$cnt]['itimg']."'><br>".$item_list[$cnt]['itname']."</a></td>\n";
	}
	if($c_cnt==2){
		echo "</tr>\n";
		$c_cnt=0;
	}
	else	$c_cnt++;
}
?>
	</table>
</div>
</body>
</html>