<?
include "./lib.php";


$item_list = item_data();
$mem_list = mem_data();
$mem_cnt = count($mem_list);

if($item !=""){
	list($type, $num) = explode("_", $item);
	if($type == 'item')	$ment = $item_list[$num]['ittext']."\n";
	$ment = $ment."<br/>가격은 ".$item_list[$num]['itcost'].$msg_list[10];
	$msg = $ment."<form name='buy' method='post' action='func_buy_use.php' target='text' style='margin:0px;'>\n";
	$msg = $msg."멤버 : <select name=buy_who size=1>\n";
	for($i=0;$i<$mem_cnt;$i++) {
	  $msg=$msg."<option value='".$mem_list[$i]['chname']."'>".$mem_list[$i]['chname']."</option>\n";
	}//이름 선택
	$msg=$msg."</select>\n";
	$msg = $msg."비번 : <input type='password' name='buy_pass' size='10'><br/>\n";
	$msg = $msg."<input type='submit' name='buy_submit' value='구매'><br/>\n";
	$msg = $msg."<input type='hidden' name='buy_code' value='".$item_list[$num]['itkey']."'>\n";
	$msg = $msg."<input type='hidden' name='form_sig' value='buy_ok'></form>\n";
}
else if($sig !="")	$msg = $msg_list[$sig];
else $msg = $msg_list[0];
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="./style.css" rel="stylesheet" type="text/css" />
</head>

<body class="talk">

<table class="talkbox"><tr><td align="center" class="talkcell">
<?
echo $msg;
?>
</td></tr></table>

<? include_once "./menu.php"; ?>
</body>
</html>