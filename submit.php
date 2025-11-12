<?php
header('Content-Type: application/json; charset=utf-8');
function respond($success, $message){
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}
if($_SERVER['REQUEST_METHOD'] !== 'POST'){ respond(false, 'Invalid request method.'); }
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
if($name === '' || $email === '' || $message === '' || $captcha === ''){ respond(false, 'Please complete all required fields.'); }
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ respond(false, 'Please provide a valid email address.'); }
if($captcha !== '7'){ respond(false, 'Incorrect CAPTCHA answer.'); }
$ip = $_SERVER['REMOTE_ADDR'];
$rateDir = __DIR__ . '/submissions/_rate';
if(!is_dir($rateDir)){ @mkdir($rateDir, 0755, true); }
$rateFile = $rateDir . '/' . preg_replace('/[^a-z0-9.\-]/i','_', $ip) . '.txt';
if(file_exists($rateFile)){
    $last = intval(file_get_contents($rateFile));
    if(time() - $last < 30){ respond(false, 'You are sending messages too quickly. Please wait a moment.'); }
}
@file_put_contents($rateFile, strval(time()));
$subDir = __DIR__ . '/submissions';
if(!is_dir($subDir)){
    if(!@mkdir($subDir, 0755, true)){
        respond(false, 'Server error: cannot create submissions directory.');
    }
}
$ts = new DateTime('now', new DateTimeZone('UTC'));
$filename = 'contact_' . $ts->format('Y-m-d_H-i-s') . '_' . substr(md5($email . microtime(true)),0,6) . '.txt';
$filepath = $subDir . '/' . $filename;
$ipaddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
$content = "Name: " . $name . PHP_EOL;
$content .= "Email: " . $email . PHP_EOL;
$content .= "Message: " . PHP_EOL . $message . PHP_EOL;
$content .= "-----" . PHP_EOL;
$content .= "Date (UTC): " . $ts->format(DateTime::ATOM) . PHP_EOL;
$content .= "IP: " . $ipaddr . PHP_EOL;
$content .= "User-Agent: " . $userAgent . PHP_EOL;
if(@file_put_contents($filepath, $content) === false){
    respond(false, 'Server error: failed to write submission.');
}
@chmod($filepath, 0600);
respond(true, 'Thanks — your message was received. I will get back to you soon.');
?>