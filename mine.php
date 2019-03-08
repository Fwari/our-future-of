<?
include "./lib.php";


$mem_data=mem_data($who);
$mem_list = mem_data();
$item_list = item_data();

$mem_cnt = count($mem_list);
$item_cnt = count($item_list);	//총 아이템갯수
if($mem_data['chitemkey'][0]=="") $mine_cnt = 0;
else $mine_cnt = count($mem_data['chitemkey']);

if($sig !="")	$msg = $msg_list[$sig];
else{

	if($who==""){
		$msg = $msg_list[7];
		$msg = $msg."<form name='mine' method='post' action='./mine.php' target='text' style='margin:0px;'>\n";
		$msg = $msg."멤버 : <select name=who size=1>\n";
		for($i=0;$i<$mem_cnt;$i++) {
		  $msg=$msg."<option value='".$mem_list[$i]['chname']."'>".$mem_list[$i]['chname']."</option>\n";
		}//이름 선택
		$msg=$msg."</select>\n";
		$msg = $msg."비번 : <input type='password' name='mine_pass' size='10'><br/>\n";
		$msg = $msg."<input type='submit' name='mine_submit' value='확인'><br/>\n";
		$msg = $msg."</form>\n";
	}
	else{
		if($mem_data['chpasswd']==$mine_pass){
			$msg=$mem_data['chname'].$msg_list[11].$mem_data['chpoint'].$msg_list[12];
			$msg=$msg.$msg_list[13]." ".$mine_cnt.$msg_list[14];
			if($mine_cnt != 0){
				for($k=0; $k<$mine_cnt; $k++){
					for($j=0; $j<$item_cnt; $j++){
						if($mem_data['chitemkey'][$k] == $item_list[$j]['itkey']) $mine_item[$k]=$item_list[$j]['itname'];
					}
					$msg=$msg.$mine_item[$k]." ,\n";
				}
				$msg=$msg.$msg_list[15];
				$msg=$msg."
				<form name='use' method='post' action='func_buy_use.php' target='text' style='margin:0px;'>
				<select name=use_code size=1>
				";

				for($i=0;$i<$mine_cnt;$i++) {
					//$msg=$msg."<option value='".$mem_data['chitemkey'][$i]."'>".$mine_item[$i]."</option>\n";
					$msg=$msg."<option value='".$i."'>".$mine_item[$i]."</option>\n";
				}//이름 선택
				$msg=$msg."</select><input type='hidden' name='use_who' value='".$who."'>\n";
				$msg = $msg."<input type='hidden' name='form_sig' value='use_ok'>\n";
				$msg=$msg."<input type='submit' name='submit' value='사용'></form>\n";

			}
			else $msg=$msg.$msg_list[16];
		}
		else $msg = $msg_list[3];
	}
}

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