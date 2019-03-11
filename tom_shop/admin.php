<?

include "./lib.php";
$item_list = item_data();
$mem_list = mem_data();
$mem_cnt = count($mem_list);
$item_cnt = count($item_list);

//------------------------- 상점 관련 관리자 모드------------------------------------

//---------------캐릭터 수정 저장-------------
if($save=="c_save"){
	mem_update($mem_data);

	$log=date("m-d")." ".$mem_data['chname']." : 관리자가 수정";
	log_insert($log);
} //캐릭터 수정 저장

//---------------캐릭터 등록 저장-------------
if($save=="c_inst"){
	mem_insert($mem_data);

	$log=date("m-d")." ".$mem_data['chname']." : 관리자가 등록 ";
	log_insert($log);
} //캐릭터 등록 저장


//---------------상점 수정 저장------------------
elseif($save=="s_save"){
	shop_update($st_list);

	$log=date("m-d")." 상점 정보 : 관리자 수정 ";
	log_insert($log);
} //상점 수정 저장



//html 표시부
echo <<<END
<html><head>
<link href="./style.css" rel="stylesheet" type="text/css" />
</head><body>
<script language="javascript">
function chg_combo(){
  form1.submit();
}

function chg_log(num){
  form_log.log_old.value = num;
  form_log.submit();
}
</script>

<font size=2>
*관리자모드*<br>
<form name="form1" method="post" action="$PHP_SELF">
<input type="radio" name="chk" value="ins" onclick="chg_combo()">신규 캐릭터 등록
<input type="radio" name="chk" value="chr" onclick="chg_combo()">캐릭터 정보 수정
<input type="radio" name="chk" value="sto" onclick="chg_combo()">상점 물품 수정 
<a href="./shop.php" target="items">Back</a>
</form>

END;



//------------------------- 캐릭터 정보 수정------------------------------------
if($chk=="chr"){
echo <<<END
<form name="form7" method="post" action="$PHP_SELF">
대상 : <select name=pname size=1>

END;
//html 표시부

	for($i=0;$i<$mem_cnt;$i++) {
		if($pname==$mem_list[$i]['chname']) $sels=" selected";
		else $sels="";
		echo "<option value='".$mem_list[$i]['chname']."'".$sels.">".$mem_list[$i]['chname']."</option>\n";
	}//이름 선택

//html 표시부
echo <<<END
</select> &nbsp;관리자 비밀번호 : <input type="password" name="admin_pass" size="10"> 
<input type=hidden name=chk value=$chk><input type='submit' name='submit' value='선택'>
</form></font>

END;
//html 표시부

  if($admin_pass==$passwd){
	  $mem_data=mem_data($pname);
	  $mem_data['chitemkey']=implode(",", $mem_data['chitemkey']);
echo <<<END
* State *
<form name="form8" method="post" action="$PHP_SELF?pname=$pname">
<table border="1" cellspacing="0" width="400" bordercolordark="black" bordercolorlight="white">
<tr align="left"><td width="50">name</td><td width="350"><input type="text" name="mem_data[chname]" value="$mem_data[chname]" size="12"></td></tr>
<tr align="left"><td width="50">pass</td><td width="350"><input type="text" name="mem_data[chpasswd]" value="$mem_data[chpasswd]" size="12"></td></tr>
<tr align="left"><td width="50">point</td><td width="350"><input type="text" name="mem_data[chpoint]" value="$mem_data[chpoint]" size="12"></td></tr>
<tr align="left"><td width="50">items</td><td width="350"><input type="text" name="mem_data[chitemkey]" value="$mem_data[chitemkey]" size="50"></td></tr>
<tr align="center"><td colspan="2"><input type='submit' name='submit' value=' 저장하기 '></td></tr>
</table>
<input type=hidden name=admin_pass value=$admin_pass>
<input type=hidden name=save value="c_save">
</form>
END;
  }

  elseif($admin_pass=="");
  else  exit("비밀번호가 틀렸습니다.<br>\n");
  echo "</body><html>";
} //캐릭터 정보 수정

//------------------------- 캐릭터 정보 등록------------------------------------
if($chk=="ins"){
echo <<<END
<form name="form7" method="post" action="$PHP_SELF">
관리자 비밀번호 : <input type="password" name="admin_pass" size="10"> 
<input type=hidden name=chk value=$chk><input type='submit' name='submit' value='선택'>
</form></font>

END;
//html 표시부

  if($admin_pass==$passwd){
	  $mem_data=mem_data($pname);
	  $mem_data['chitemkey']=implode(",", $mem_data['chitemkey']);
echo <<<END
* State *
<form name="form8" method="post" action="$PHP_SELF">
<table border="1" cellspacing="0" width="400" bordercolordark="black" bordercolorlight="white">
<tr align="left"><td width="50">name</td><td width="350"><input type="text" name="mem_data[chname]" value="" size="12"></td></tr>
<tr align="left"><td width="50">pass</td><td width="350"><input type="text" name="mem_data[chpasswd]" value="" size="12"></td></tr>
<tr align="left"><td width="50">point</td><td width="350"><input type="text" name="mem_data[chpoint]" value="" size="12"></td></tr>
<tr align="left"><td width="50">items</td><td width="350"><input type="text" name="mem_data[chitemkey]" value="" size="50"></td></tr>
<tr align="center"><td colspan="2"><input type='submit' name='submit' value=' 저장하기 '></td></tr>
</table>
<input type=hidden name=admin_pass value=$admin_pass>
<input type=hidden name=save value="c_inst">
</form>
END;
  }

  elseif($admin_pass=="");
  else  exit("비밀번호가 틀렸습니다.<br>\n");
  echo "</body><html>";
} //캐릭터 정보 등록

//------------------------- 상점 정보 수정------------------------------------
elseif($chk=="sto"){
echo <<<END
<form name="form7" method="post" action="$PHP_SELF">
관리자 비밀번호 : <input type="password" name="admin_pass" size="10"> 
<input type=hidden name=chk value=$chk><input type='submit' name='submit' value='선택'>
</form></font>
END;

	if($admin_pass==$passwd){
		for($i=0;$i<$item_cnt; $i++){
			$temp[$i] = implode("|", $item_list[$i]);
		}
		$st_list = implode("\r\n", $temp);

echo <<<END
<table border="1" cellspacing="0" width="500" bordercolordark="black" bordercolorlight="white">
<tr><td align="center">*상점 물품 목록*<br>
<form name="form8" method="post" action="$PHP_SELF">
<textarea name="st_list" cols="65" rows="15">$st_list</textarea><br><br>
<input type=hidden name=admin_pass value=$admin_pass>
<input type=hidden name=save value="s_save">
<input type='submit' name='submit' value=' 저장하기 '><br>
</form></td></tr>
<tr><td align="left">
** 양식 **<br>
아이템번호|아이템명|아이콘이미지파일명|가격|설명<br>
** 설명 **<br>
줄바꿈(엔터)가 되면 그 것까지 한 아이템으로 인정합니다. 줄바꿈(엔터)에 주의 해 주세요.<br>
아이템 번호: it001, it002, ... 으로 해 주세요. 이론상 100개까지 가능합니다.<br>
아이템 이름: 너무 길지 않은 편이 좋습니다.<br>
아이콘이미지: img 폴더에 ftp로 수동으로 올리 신 뒤 파일명을 써 주세요. 영문과 숫자가 좋습니다.<br>
가격 :1의 단위부터 가능합니다.<br>
설명 : 왼쪽에서 설명이 나타납니다. 너무 길지 않은 편이 좋습니다.
</td></tr>
</table>

END;
  }
 
  elseif($admin_pass=="");
  else  exit("비밀번호가 틀렸습니다.<br>\n");
  echo "</body><html>";
} //상점 정보 수정


?>