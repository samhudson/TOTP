<?php
/*
OPT */


include('./lib/phpqrcode-master/qrlib.php');
include('./lib/base32.php');

function TOTP($key, $tframe, $otp_length, $timeprint) {
    $key_decoded = \Base32::decode($key);
    $shift = Array();
    while($timeprint > 0) {
        $shift[] = chr($timeprint & 255);
        $timeprint >>= 8;
    }
    $joined_shifted = join(array_reverse($shift));
    $counter_bytes = str_pad($joined_shifted, 8, "\000", STR_PAD_LEFT);
    $the_hash = hash_hmac('sha1', $counter_bytes, $key_decoded);
    for($i=0;$i<(strlen($the_hash));$i=$i+2) {
     $hm[] = hexdec($the_hash[$i].$the_hash[$i+1]);
    }
    $o = end($hm) & 15;
    $code = ($hm[$o+0] & 127) << 24 ^ ($hm[$o + 1] & 255) << 16 ^ ($hm[$o + 2] & 255) << 8 ^($hm[$o + 3] & 255);
    $divider = pow(10, $otp_length);
    return (string) ($code % $divider);

}
//Change parameters at will
$key = "$KEY"; //(already base32 encoded)
$otp_length = 6;
$tframe = 10;
$issuer = "$USER";
$account = "$EMAIL";
$algorithm = "SHA1";


if($argc < 2) {
echo "Usage: php submission.php --parameter\n";
echo "Available parameters:\n1. --generate-qr\n2. --get-otp\n";
} 
else if($argv[1]=="--generate-qr") {
echo "You've selected --generate-qr\n";
$dataText   = 'otpauth://totp/'.$issuer.':'.$account.'?secret='.$key.'&issuer='.$issuer.'&algorithm=SHA1&digits='.$otp_length.'&period='.$tframe;
$svgTagId   = time().'.svg';
$svgCode = QRcode::svg($dataText, $svgTagId);
}
else if($argv[1]=="--get-otp") {
echo "You've selected --get-otp\nThis will cycle every ".$tframe." seconds.\n";
echo "OTP:";
while(1) {
$timestamp = time();
$timeprint = (int)((int)$timestamp/$tframe);
(string)$code = TOTP($key,$tframe,$otp_length,$timeprint);
//Case for handling leading zeros!
if(strlen($code)<6) {
    $zeros ="";
    for($i=0;$i<(6-strlen($code));$i++)
        $zeros .="0";
$code = $zeros.$code;
}
echo "\033[10D";
echo str_pad("OTP:".((string)$code), 6, ' ', STR_PAD_LEFT);
sleep(1);
}
}
?>
