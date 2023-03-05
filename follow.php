<?php
system("clear");
include"proxy.php";
error_reporting(0);
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
global $hijau,$off;
$request=curl(["Host: gw-napi.zepeto.io","authorization: Bearer $auth","x-zepeto-duid: $uuid","user-agent: android.zepeto_global/3.22.200 (android; U; Android OS 8.1.0 / API-27 (O11019/9f4ea240fa3f5f83); id-ID; occ-ID; ".$ua1." ".$ua2.")","x-timezone: Asia/Jakarta","content-type: application/json; charset=utf-8"],'https://gw-napi.zepeto.io/FollowRequest_v2','{"followUserId":"'.$target.'"}');
if(json_decode($request,true)["isSuccess"] == "true"){
echo "{$hijau}$nama{$off} success\n";
}else{
echo " follow gagal,unknown error\n";
echo $request;exit;
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
$nama=readline("\nnickname: ");
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


$target=$argv[1];
while(true){
$uuid=random(32);
$ua1=random(15);
$ua2=random(16);
$get_device=device($uuid,$ua1,$ua2);
$js=json_decode($get_device,true);
$auth=$js["authToken"];
$userid=$js["userId"];
$name=nama();
$save=save($auth,$uuid,$ua1,$ua2,$name);
$save=saveCharacter($auth,$uuid,$ua1,$ua2);

$follow=follow($auth,$uuid,$ua1,$ua2,$target,$name);
}
