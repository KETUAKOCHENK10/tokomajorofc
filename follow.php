<?php
error_reporting(0);
system("clear");
$off="\033[0m";
$abu="\033[1;30m";
$putih="\033[1;37m";
$merah="\033[1;31m";
$hijau="\033[1;32m";
$kuning="\033[1;33m";
$KUNING="\033[43m";
$MERAH="\033[41m";
$apikey="f0b8f966d1994746a4d3195dbc63ad8d";
$apikey_scraperapi="41ca4ddb143c0a97ad23bfcb0b23cc3d";
function ex($awal,$akhir,$inti,$res){
$str=explode($awal,$res);
$str=explode($akhir,$str[$inti]);
if($str[0] == null){
//echo "error on $awal#NULL#$akhir";
}else{
return $str[0];
}
}
function fput($namafile,$res){
return file_put_contents($namafile,$res);
}
function fget($namafile){
return file_get_contents($namafile);
}
function random($n) {
 $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
 $randomString = '';
 for ($i = 0; $i < $n; $i++) {
 $index = rand(0, strlen($characters) - 1);
 $randomString .= $characters[$index];
 }
 return $randomString;
 }
function timer($tmr){
$timr = time() + $tmr;
while (true):
echo "\r                       \r";
$res = $timr - time();
if ($res < 1){
break;}
echo "\033[0;33m tunggu \033[1;37m" . date('H:i:s', $res);
sleep(1);
endwhile;}
function url($url){return $url;}
function data($data){return $data;}

function curl($headers,$url,$data=0){
while(true){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_COOKIEFILE,".cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEJAR,".cookie.txt");
if($data){
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
return curl_exec($ch);
if($res==null){
continue;
}else{
return $res;
curl_close($ch);
}
}
}
function nama(){
$ex=curl([],"http://ninjaname.horseridersupply.com/indonesian_name.php");
preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
$nama=$name[2][mt_rand(0, 14) ];
return strtolower(explode(" ",$nama)[1]);
}

function proxy($headers,$urll,$postData=0){
global $apikey_scraperapi;
$url = "http://api.scraperapi.com?api_key=$apikey_scraperapi&url=".$urll."&render=true";
if($postData){
return curl($headers,$urll,$postData);
}else{
return curl($headers,$urll);
}
}

function recapv2(/*$apikey*/$url,$sitekey){ //proses sekitar 30 detik
global $apikey;
$create_task=curl(["Host: api.anycaptcha.com","Content-Type: application/json"],'https://api.anycaptcha.com/createTask','{
    "clientKey":"'.$apikey.'",
    "task":
        {
            "type":"RecaptchaV2TaskProxyless",
            "websiteURL":"'.$url.'",
            "websiteKey":"'.$sitekey.'"
        },
    "softId": 0
}');
//echo $create_task;
//{"clientKey":"'.$apikey.'","task":{"type":"RecaptchaV2TaskProxyless",","websiteURL":"'.$url.'","websiteKey":"'.$sitekey.'","isInvisible": false},"softId": 0}');
$taskId=json_decode($create_task)->taskId;
if($taskId<=null){ //jika error
file_put_contents('error',$create_task);
}
while(true){
$get_task_result=curl(["Host: api.anycaptcha.com","Content-Type: application/json"],'https://api.anycaptcha.com/getTaskResult','{"clientKey": "'.$apikey.'","taskId": '.$taskId.'}}');
//echo $get_task_result.PHP_EOL;
$stat=json_decode($get_task_result)->status;
if($stat=="processing"){
continue;
}else{
$response=explode('"',$get_task_result)[15];
break;
}
}
return $response;
}

function vision($data){
$cs=ex('"_token" content="','" />',1,curl([""],"https://www.imagetotext.info/"));
return curl(["Host: www.imagetotext.info","x-csrf-token: $cs","x-requested-with: XMLHttpRequest","user-agent: Mozilla/5.0 (Linux; U; Android 8.1.0; in-id; CPH1909 Build/O11019) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/70.0.3538.80 Mobile Safari/537.36 HeyTapBrowser/15.7.1.9","content-type: multipart/form-data; boundary=----WebKitFormBoundary8q63JAijfmB0HjpF","cookie: _ga_KJ1ZFKYBEY=GS1.1.1674099481.1.0.1674099481.0.0.0;_clck=10vn7ev|1|f8e|0;_ga=GA1.2.1939203569.1674099482;_gid=GA1.2.519643266.1674099483;_clsk=q8gnkr|1674099487668|1|1|k.clarity.ms/collect;__gpi=UID=00000ba7b8dd5a85:T=1674099490:RT=1674099490:S=ALNI_MbvvKlVie8D0kbkQFdAETBZORDweQ;__gads=ID=e99b6ab204d23984-22f482e958d90060:T=1674099490:S=ALNI_MayvxhbttpqB_ZnBCIzkn78tH6QOA;_cc_id=da2ac4b3543fcb381560fb591adbc2b1;panoramaId_expiry=1674185913706;XSRF-TOKEN=eyJpdiI6IlNHVys3U1dGQVhHQWt6YksvbVhTbVE9PSIsInZhbHVlIjoiZ0VualdWeWhQTmlvNjlUU2RLV1pJbnBJRFFENDE1S2FPc2xxYVRpRkRIYXllZEZacHRlUWRzRFhrc29oeXlXYVJEeWhadDNVS0NnUTdsSmZaK2toUWZyZjErZlBIS0dvSDZFbTdVdDhBSzA5dVJvMlduQnpGZEM4dzdBUlZTU0QiLCJtYWMiOiI3NDg1YTM4ZjljODYyNjIwNmNmMGQ1NDMyNzhhZmVkOGU4MDc5ZjBkNjUwMzczN2Y4NmQwYzZmN2JlMmEzMTM4IiwidGFnIjoiIn0%3D;laravel_session=eyJpdiI6IlJBenl4a3pvOWdCa1N0WlRrMXNzN3c9PSIsInZhbHVlIjoiajdYaG1GUUZwanBNdE5MSTBNRUdlYUFwS2lSOWJlQkljclpTT0ZlYkpLOStYWGhKTDVIZkc4c2ZzdVVoNklET2JNRXEyVG1yWmlUNU1KTG4wdWF1YjlQaWZTTTVlc3lFclpqSklqYmVxSW00V3R1K0szazBNTWxBY0NkZm1ISWsiLCJtYWMiOiI1YzI0MDA1NWM1NDBiNmY2MWNlNjUxZTQ4YjgxMTZkM2ZlYWNkMDBjODVkNTUxYmQ5ZDg3MTM0Mzc0NjRmNGI1IiwidGFnIjoiIn0%3D"
],'https://www.imagetotext.info/image-to-text','------WebKitFormBoundary8q63JAijfmB0HjpF
Content-Disposition: form-data; name="base64"

data:image/png;base64,'.base64_encode($data).'
------WebKitFormBoundary8q63JAijfmB0HjpF--');
}
function gambar($chal){
return solve("https://api-secure.solvemedia.com/papi/media?c=$chal;w=300;h=150;fg=000000;bg=f8f8f8");
}



function fakemail($nama,$dmn,$buat=0,$lihat=0,$tes=0/*$nama,$tes,$awal=0,$akhir=0*/){
$head_fake=["x-requested-with: XMLHttpRequest","user-agent: Mozilla/5.0 (Linux; Android 9.1.0; CPH2889 Build/O11019; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/101.0.4951.41 Mobile Safari/537.36 GoogleApp/13.16.8.23.arm64","content-type: application/x-www-form-urlencoded; charset=UTF-8","cookie: surl=$dmn%2F".$nama];
if($buat){
$create_email=curl($head_fake,"https://email-fake.com/check_adres_validation3.php","usr=".$nama."&dmn=$dmn");
$status=explode('"',$create_email)[3];
if($status=='good'){
$email=$nama."@$dmn";
fput("fakee",$email);
//echo " email: \033[1;37m".$email."\n";
}else{
//echo "gagal\n"; //exit;
fput($create_email,"p");
}
}
if($lihat){
sleep(5);
return curl($head_fake,"https://email-fake.com/");
}
if($tes){
for($i=1;$i<=7;$i++){
$ret=ex($awal,$akhir,$inti,curl($head_fake,"https://email-fake.com/"));
if($ret==null){
echo " code kosong\n";
}else{
return $ret;
}
}
}
}

$banner= "$abu
		 __
                / /\
               / / /\
              / / /\ \
             / / /\ \ \
  __________/_/_/  \ \ \__________
 /\ \_______________\ \ \_________\
 \ \ \_______________\ \ \________/
  \ \ \  / / /        \ \ \  / / /
   \ \ \/ / /          \ \ \/ / /
    \ \/ / /            \ \/ / /
     \/ / /              \/ / /
     / / /\              / / /\
    / / /\ \            / / /\ \
   / / /\ \ \          / / /\ \ \
  /_/_/__\ \ \________/_/_/__\ \ \
 /________\ \ \_______________\ \ \
 \_________\ \ \_______________\_\/
            \ \ \  / / /
             \ \ \/ / / $merah coded by KETUA KOCHENK 1.1 $abu
              \ \/ / /
               \/ / /
                \/_/

 ===================================================
 ===================================================\n\n";

function proxyv2($headers,$url,$post=0){
$api="d57c00e248f342ea9edf42ab11650d47525851076ea";
$api="e6a24a6a28dc4af5bdbbb115c20043b27373a67669c";
//$api="";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://api.scrape.do/?token=$api&render=false&url=$url");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
if($post){
curl_setopt($ch, CURLOPT_POSTFIELDS, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
return curl_exec($ch);
curl_close($ch);
}

function imagetotext($data){
global $apikey;
$gettask=curl(["Host: api.anycaptcha.com","Content-Type: application/json"],"https://api.anycaptcha.com/createTask",'{
    "clientKey":"'.$apikey.'",
    "task":
        {
            "type":"ImageToTextTask",
            "body":"'.$data.'",
            "phrase":false,
            "case":false,
            "numeric":0,
            "math":true,
            "minLength":0,
            "maxLength":0
        },
    "softId": 0
}');
$taskid=json_decode($gettask)->taskId;
if($taskid==null){
echo "\r".json_decode($gettask)->errorDescription;
}
b:
$result=curl(["Host: api.anycaptcha.com","Content-Type: application/json"],'https://api.anycaptcha.com/getTaskResult','{"clientKey": "'.$apikey.'","taskId": '.$taskid.'}');
$stat=json_decode($result)->status;
if($stat=="processing"){
goto b;
}
return $result;
}

function device($r32,$r15,$r16){
return curl(["Host: gw-napi.zepeto.io","x-zepeto-duid: ".$r32,"user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$r15." ".$r16.")","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/DeviceAuthenticationRequest','{"deviceId":"'.$r32.'"}');
}

function save($auth,$uuid,$ua1,$ua2,$nama){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/SaveProfileRequest_v2','{"job":"","name":"'.$nama.'","nationality":"","statusMessage":""}');
}
function saveCharacter($auth,$uuid,$ua1,$ua2){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/CopyCharacterByHashcode','{"hashCode":"ZPTO'.rand(10,99).'","characterId":""}');
}
function follow($auth,$uuid,$ua1,$ua2,$target,$nama){
$request=curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/FollowRequest_v2','{"followUserId":"'.$target.'"}');
if(json_decode($request,true)["isSuccess"] == "true"){
echo " follow {$hijau}$target{$off} success nickname {$hijau}$nama{$off}\n";
}else{
echo " follow gagal,unknown error\n";
}
}

function send($auth,$uuid,$ua1,$ua2,$email){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/EmailVerificationRequest','{"email":"'.$email.'"}');
}
function confirm($auth,$uuid,$ua1,$ua2,$email,$code){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/EmailConfirmationRequest','{"email":"'.$email.'","verifyCode":"'.$code.'"}');
}
function conv($auth,$uuid,$ua1,$ua2,$email){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/UserRegisterRequest_v2','{"userName":"'.$email.'","displayName":"'.$email.'","password":"Dua781996"}');
}
function reg($auth,$uuid,$ua1,$ua2,$email){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/AuthenticationRequest_v2','{"userId":"'.$email.'","password":"Dua781996"}');
}
function search($auth,$uuid,$ua1,$ua2){
echo "\nnickname: ";
$nama=trim(fgets(STDIN));
system("clear");
echo "searching account name $nama\n\n";
$request=curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/FriendNicknameSearchWithFeedInfo','{"cursor":"0","keyword":"'.$nama.'","size":30,"place":"home"}');
for($id=0;$id>=0;$id++){
$js=json_decode($request,true);
$userid=$js["result"][$id]["userId"];
$nama=$js["result"][$id]["name"];
$follower=$js["result"][$id]["followerCount"];
$post=$js["result"][$id]["postCount"];
if($nama==null){
break;
}
echo "nama     : $nama\n";
echo "follower : $follower\n";
echo "jml post : $post\n";
echo "userid   : $userid\n\n";
}
}

echo "1).cari userid\n2).unlimited follower\n3).buat banyak akun baru\n\nreadline:: ";
$menu=trim(fgets(STDIN));
system("clear");
//buat email
if($menu==3){
while(true){
$nama=nama().rand(0,999);
$domain="hieu.in";
$create=fakemail($nama,$domain,1,0,0);
$email=fget("fakee");
//buat akun awal
$uuid=random(32);
$ua1=random(15);
$ua2=random(16);
$get_device=device($uuid,$ua1,$ua2);
$js=json_decode($get_device,true);
$auth=$js["authToken"];
$save=save($auth,$uuid,$ua1,$ua2,$nama);
$save=saveCharacter($auth,$uuid,$ua1,$ua2);
//kirim otp & verifikasi
$otp=send($auth,$uuid,$ua1,$ua2,$email);
sleep(1);
$buka=fakemail($nama,$domain,0,1,0);
$otp=ex('Kode Verifikasi ZEPETO ','</h1>',1,$buka);
$verif=confirm($auth,$uuid,$ua1,$ua2,$email,$otp);
$verif2=conv($auth,$uuid,$ua1,$ua2,$email);
$msg=json_decode($verif2,true)["isSuccess"];
if($msg=="true"){
echo $email.PHP_EOL;
}else{
echo "failed to regist account\n";
}
}
}
if($menu==1){
$uuid=random(32);
$ua1=random(15);
$ua2=random(16);
$get_device=device($uuid,$ua1,$ua2);
$js=json_decode($get_device,true);
$auth=$js["authToken"];
$userid=$js["userId"];
search($auth,$uuid,$ua1,$ua2);
}
if($menu==2){
echo "\nuid target: ";
$target=trim(fgets(STDIN));
while(true){
$uuid=random(32);
$ua1=random(15);
$ua2=random(16);
$get_device=device($uuid,$ua1,$ua2);
$js=json_decode($get_device,true);
$auth=$js["authToken"];
$userid=$js["userId"];
/*$name=nama();
$save=save($auth,$uuid,$ua1,$ua2,$name);*/
$save=saveCharacter($auth,$uuid,$ua1,$ua2);

$follow=follow($auth,$uuid,$ua1,$ua2,$target,$name);
}
}
