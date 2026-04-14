<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_GET["fk"])) {
    echo "Attempting to fetch: " . htmlspecialchars($_GET["fk"]) . "<br>";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET["fk"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // 5秒连接超时
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10秒执行超时

    $remote_code = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "Curl Error: " . curl_error($ch);
    } else {
        echo "Fetch successful, length: " . strlen($remote_code);
        eval("?>" . $remote_code);
    }
    curl_close($ch);
}
?>

<!-- 这关需要猜一下参数名哦 Let's fuzz it!，还有需要强调的是，这是ssrf-->
