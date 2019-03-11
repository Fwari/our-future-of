<?
include "./lib.php";

if($form_sig=='buy_ok'){
	$mem_data=mem_data($buy_who);
	$item_data=item_data($buy_code);

	if($mem_data['chname']==$buy_who){
		if($mem_data['chpasswd']==$buy_pass){
			/*
			$own_cnt=count($mem_data['chitemkey']);
			for($k=0; $k<$own_cnt; $k++){
				if($buy_code == $mem_data['chitemkey'][$k]){
					$sig=5;
					break;
				}
			}
			*/

			if($sig!=5){
				$temp = $mem_data['chpoint']-$item_data['itcost'];
				if($temp < 0) $sig=4;
				else{
					$mem_data['chpoint']=$temp;
					$temp=implode(",", $mem_data['chitemkey']);
					if($temp=="") $temp=$buy_code;
					else $temp=$temp.",".$buy_code;
					$mem_data['chitemkey']=$temp;
					mem_update($mem_data);

					$log=date("m-d")." ".$mem_data['chname']."(구매) : ".$item_data['itname'];
					log_insert($log);

					$sig=1;
				}
			}
		}
		else $sig=3;
	}
	else $sig=2;
}
else if($form_sig=='use_ok'){
	$mem_data=mem_data($use_who);

	if($mem_data['chname']==$use_who){
		/*
		foreach($mem_data['chitemkey'] as $key => $value){
			if($use_code==$value) continue;
			$mine_temp[] = $value;
		}
		*/

		for($cnt=0; $cnt<count($mem_data['chitemkey']);$cnt++){
			if($use_code==$cnt){
				$use_code_tmp = $mem_data['chitemkey'][$cnt];
				continue;
			}
			$mine_temp[] = $mem_data['chitemkey'][$cnt];
		}
		$item_data=item_data($use_code_tmp);
		$mem_data['chitemkey']=implode(",", $mine_temp);
		mem_update($mem_data);

		$log=date("m-d")." ".$mem_data['chname']."(사용) : ".$item_data['itname'];
		log_insert($log);
		$sig=6;
	}
	else $sig=2;
}
if($sig!=""){
echo <<<END
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="./style.css" rel="stylesheet" type="text/css" />
</head>

<body class="talk">

<script language="javascript">
location.href="./talk.php?sig=$sig";
</script>
</body>
</html>
END;
}

?>


