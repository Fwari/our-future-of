<?
if(count($_POST)>0)	foreach($_POST as $key=>$val)	$$key= $val;
if(count($_GET)>0)	foreach($_GET as $key=>$val)	$$key= $val;


//--------------
$passwd = "12345";  //관리자 패스워드.숫자와 영문 조합 권장
//---------------


//------상점주인의 대사목록. 말투는 바꿔도 되지만 의도는 아래의 내용을 담도록 하자.---------

$msg_list[0]="어서왕, 손님. 여기는 중립지대니까 느긋하게 둘러봐.<br />\n";	//처음인사
$msg_list[1]="고맙당, 손님. 사줘서 땡큐다냥.<br />\n";						//구매인사
$msg_list[2]="누구냥, 손님. 나는 손님 모른다냥.<br />\n";					//잘못된 회원이름
$msg_list[3]="누구냥, 손님. 사칭하면 혼난다냥.<br />\n";					//회원패스워드 틀림
$msg_list[4]="아깝당, 손님. 돈이 모자란다냥.<br />\n";						//소지금 부족
$msg_list[6]="여깄당, 손님. 상점에 있는 설명서 꼭 읽어보고 쓰라냥.<br />\n";//구매성공
$msg_list[7]="어서왕, 손님. 누구의 소지품을 보고 싶은거냥?<br />\n";		//소지품사용메뉴

//이하는 조합형 고정 메세지
$msg_list[10]=" 포인트다냥.<br/>\n\n";	//talk.php 아이템 선택시 설명 말미에 가격을 표시할 때.
$msg_list[11]=" 냥, 네가 가진 포인트는 ";	//mine.php 소지품 확인사용시 아이템 표시. (ex:고양이 냥, 네가 가진 포인트는 ~
$msg_list[12]=" 이다냥.<br />\n";		//mine.php 소지품 확인사용시 윗 글 다음에. (ex: ~ (100) 이다냥.
$msg_list[13]="그리고 네가 가진 아이템은 ";	//mine.php 소지품 확인사용시 소지아이템 표시. (ex: ~ 그리고 네가 가진 아이템은~
$msg_list[14]="개다냥.<br />\n";			//mine.php 소지품 확인사용시 윗 글 다음에. (ex: (3 개다냥.
$msg_list[15]="...이상이다냥.<br />뭔가 사용하겠냥?<br />\n";//mine.php 소지품 확인사용시 마지막에. (ex: 뫄뫄, 모모, 무무, ...이상이다냥.
$msg_list[16]="암것도 없구냥...쯧쯧.<br/>\n";//mine.php 소지품 확인사용시 아이템이 0개일 때.


//------상점주인의 대사목록 끝. 여기까지만 수정하고 이하는 수정하지 않는 것을 권장합니다.---------
//$msg_list[5]="얼라링, 손님. 그거 이미 하나 갖고 있다냥.<br />\n";			//중복구매금지. 사용하지않습니다. 수정금지.

//------멤버리스트 및 멤버 1인 데이터(arg로 이름이 입력되면 1인만 뽑음)---------
function mem_data($arg=""){
	$mcnt=0;
	$fname="./data/members.txt";
	if(!file_exists($fname))  exit('err');

	$fp = fopen($fname,"r");
	while(!feof($fp)){
		$buffer = chop(fgets($fp, 4096));
		$data = explode("|", $buffer);

		if($buffer!=""){
			$mem_list[$mcnt]['chname'] = $data[0];	//캐릭터이름
			$mem_list[$mcnt]['chpasswd'] = base64_decode($data[1]);	//계좌비번
			$mem_list[$mcnt]['chpoint'] = $data[2];	//소유포인트
			$mem_list[$mcnt]['chitemkey'] = $data[3];	//소유아이템들
			$mcnt++;
		}

		if($arg !="" && $data[0] == $arg){
			$mem_data['chname'] = $data[0];	//캐릭터이름
			$mem_data['chpasswd'] = base64_decode($data[1]);	//계좌비번
			$mem_data['chpoint'] = $data[2];	//소유포인트
			$mem_data['chitemkey'] = explode(",", $data[3]);	//소유아이템들
			fclose($fp);
			return $mem_data;
		}
	}
	fclose($fp);

	return $mem_list;
} // end func



//------멤버 1인데이터 업---------
function mem_update($arg){
	$fname='./data/members.txt';
	if(!file_exists($fname))  exit("$fname 파일이 없습니다.\n");

	$mem_list = mem_data();
	$mem_cnt = count($mem_list);

	proclock();
	$fp = fopen("$fname","w");
	for($cnt=0;$cnt<$mem_cnt;$cnt++){
		if($mem_list[$cnt]['chname']==$arg['chname']){
			$mem_list[$cnt]=$arg;
		}
		//if($mem_list[$cnt]['chitemkey']=="")	$mem_data['chpoint']=$mem_data['chpoint']."|";
		$mem_list[$cnt]['chpasswd'] = base64_encode($mem_list[$cnt]['chpasswd']);
		$buffer = implode("|", $mem_list[$cnt]);
		fputs($fp, $buffer);
		if($cnt<$mem_cnt-1) fputs($fp,"\r\n");
	}	
	procunlock();

	return true;
} // end func

//------멤버 1인데이터 인---------
function mem_insert($arg){
	$fname='./data/members.txt';
	if(!file_exists($fname))  exit("$fname 파일이 없습니다.\n");

	$mem_list = mem_data();
	$mem_cnt = count($mem_list);

	if($mem_cnt>0)	$modes="a";
	else	$modes="w";

	proclock();
	$fp = fopen("$fname",$modes);
	//if($arg['chitemkey']=="")	$arg['chpoint']=$arg['chpoint']."|";
	$arg['chpasswd'] = base64_encode($arg['chpasswd']);
	$buffer = implode("|", $arg);
	if($mem_cnt>0) fputs($fp,"\r\n");
	fputs($fp, $buffer);
	procunlock();

	return true;
} // end func

//------상점 데이터 업---------
function shop_update($arg){
	$fname='./data/items.txt';
	if(!file_exists($fname))  exit("$fname 파일이 없습니다.\n");

	proclock();
	$fp = fopen("$fname","w");
	fputs($fp, $arg);
	fclose($fp);
	procunlock();

	return true;
} // end func

//------아이템리스트 및 아이템 1개 데이터(arg로 아이템키값이 입력되면 1개만 뽑음)---------
function item_data($arg=""){
	$icnt=0;
	$fname="./data/items.txt";
	if(!file_exists($fname))  exit('err');

	$fp = fopen($fname,"r");
	while(!feof($fp)){
		$buffer = chop(fgets($fp, 4096));
		$data = explode("|", $buffer);

		$item_list[$icnt]['itkey'] = $data[0];	//아이템 키값
		$item_list[$icnt]['itname'] = $data[1];	//아이템 이름
		$item_list[$icnt]['itimg'] = $data[2];	//아이템 이미지
		$item_list[$icnt]['itcost'] = $data[3];	//아이템 가격
		$item_list[$icnt]['ittext'] = $data[4];	//아이템 설명
		$icnt++;

		if($arg !="" && $data[0] == $arg){
			$item_data['itkey'] = $data[0];	//아이템 키값
			$item_data['itname'] = $data[1];	//아이템 이름
			$item_data['itimg'] = $data[2];	//아이템 이미지
			$item_data['itcost'] = $data[3];	//아이템 가격
			$item_data['ittext'] = $data[4];	//아이템 설명
			return $item_data;
		}
	}
	fclose($fp);

	return $item_list;
} // end func



//------샵 변경사항 로그 추가---------
function log_insert($arg){
	$fp = fopen("./data/log.txt", "a");
	fputs($fp, "\r\n".$arg);
	fclose($fp);
	
	return true;
} // end func


//------샵 변경사항 로그 보기---------
function log_list($arg){
	$lg_temp=file("./data/log.txt");
	$lg_temp2=array_chunk($lg_temp, $arg);
	$lg_cnt=count($lg_temp2);
	for($i=0;$i<$lg_cnt;$i++)	  $lg_list[$i] = implode("", $lg_temp2[$i]);
	$output = array( 'cnt' => $lg_cnt, 'list' =>  $lg_list);
	return $output;
} // end func


//----------- 데이터 쓰기 보호 lock -------------
$lockfile = "./data/lock.dat";
function proclock()
{
	global $lockfile;
	for($count=0;$count<10;$count++){
if(file_exists($lockfile) and (time() - filemtime($lockfile)) > 15) procunlock();
			if(file_exists($lockfile))
			{
					sleep(1);
			}
			else
			{
					$fp = fopen($lockfile,"w");
					fclose($fp);
					return 1;
			}
	}
	return 0; //락실패
}

function procunlock()
{
	global $lockfile;
	unlink($lockfile);
}
?>