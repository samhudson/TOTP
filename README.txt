I've implemented TOTP in PHP. 

To generate a QR code run the following:

php submission.php --generate-qr

This will create a svg file named with the current timestamp on creation. I've included an example svg file that I created earlier named 1497169099.svg for your convience. Also feel free to alter any parameters within the file:

$key = "<base32_encoded_key>"
$otp_length = <otp_key_length>
$tframe = <rotating_time_for_key_in_seconds>
$issuer = "<issuer>"
$account = "<account_name>"
$algorithm = "<algorithm>"

Once you've generated the SVG open it in google chrome or another SVG viewer. Once it's open use the Google Authenticator application to scan the QR.

Once that's complete you can now go ahead and run get opt via the following:

php submission.php --get-otp

You'll see an output similar to:

You've selected --get-otp
This will cycle every 10 seconds.
OTP:675467

I've added some padding left functionality to make the key auto update in place. 

Also I handled the edge case where leading zeros are cut with a simple prepend.