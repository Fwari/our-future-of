<?
include "./lib.php";

$log_arr = log_list(60);//한 페이지 당 몇 줄 보일 것인가?

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="./style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function chg_combo(){
  form1.submit();
}

function chg_log(num){
  form_log.log_old.value = num;
  form_log.submit();
}
</script>
</head>

<body class="talk">

<table class="talkbox"><tr><td align="center" class="talkcell">
<?
$lg_cnt=$log_arr['cnt'];
$lg_list=$log_arr['list'];
if($log_old=="")  $log_old=$lg_cnt-1;

echo <<<END
<table border="0" cellspacing="0" width="300" bordercolordark="black" bordercolorlight="white">
<form name="form_log" method="post" action="$PHP_SELF">
<tr><td align="center">*상점 장부*<br>
<textarea name="log_list" cols="50" rows="20">$lg_list[$log_old]</textarea><br><br>
이전 장부 보기 : 예전<<.
END;

 for($i=0;$i<$lg_cnt;$i++) echo "<a href='#' onclick=\"chg_log('".$i."');\">".$i."</a> . ";

echo <<<END
>>최근
<input type="hidden" name="log_old">
</form></td></tr></table>
END;
?>
</td></tr></table>

<? include_once "./menu.php"; ?>
</body>
</html>