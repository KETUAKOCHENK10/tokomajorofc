<?php
system("clear");
include"proxy.php";

//error_reporting(0);
function device($r32,$r15,$r16){
$res=curl(["Host: gw-napi.zepeto.io","x-zepeto-duid: ".$r32,"user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$r15." ".$r16.")","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/DeviceAuthenticationRequest','{"deviceId":"'.$r32.'"}');
$js=json_decode($res,true);
$auth=$js["authToken"];
return $auth;
}
function save($auth,$uuid,$ua1,$ua2,$nama){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/SaveProfileRequest_v2','{"job":"","name":"'.$nama.'","nationality":"","statusMessage":""}');
}
function saveCharacter($auth,$uuid,$ua1,$ua2){
return curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/CopyCharacterByHashcode','{"hashCode":"ZPTO'.rand(10,99).'","characterId":""}');
}
function follow($auth,$uuid,$ua1,$ua2,$target,$nama){
global $hijau,$off;
$request=curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/FollowRequest_v2','{"followUserId":"'.$target.'"}');
if(json_decode($request,true)["isSuccess"] == "true"){
echo "$nama success\n";
$op=fopen("tumbal.txt","a+");
fputs($op,PHP_EOL."auth:$auth|uuid:$uuid|nama:$nama|");
fclose($op);
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
function ceklimit($uid,$auth,$uuid,$ua1,$ua2){
$req=curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/UserVisitRequest_v2','{"visitUserId":"'.$uid.'","resolve":true}');
return ex('"followerCount":',',',1,$req);
}



$target=$argv[1];
$limit=$argv[2];


while(true){
$uuid=random(32);
$ua1=random(15);
$ua2=random(16);
$auth=device($uuid,$ua1,$ua2);
//$foll=ceklimit($target,$auth,$uuid,$ua1,$ua2);
//if($foll >= $limit){
//echo "$hijau success mencapai target\n";
//exit;
//}
$name=nama($uuid,$ua1,$ua2);
$save=save($auth,$uuid,$ua1,$ua2,$name);
$save=saveCharacter($auth,$uuid,$ua1,$ua2);
$follow=follow($auth,$uuid,$ua1,$ua2,$target,$name);
}








