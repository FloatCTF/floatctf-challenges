<?php
/**
 * 完善后的高级 URL 调试工具
 * 目标：实现 SSRF 探测及 Redis 深度交互
 */

echo "<h3>Advanced Url Debug Tool</h3>";

$url = $_GET["url"] ?? "";

if (!$url) {
    echo '<form>
        <div style="margin-bottom:10px">
            <input name="url" style="width:400px; padding:5px;" placeholder="http://127.0.0.1">
            <button style="padding:5px 15px;">调试</button>
        </div>

    </form>';
    exit();
}

// 初始化 cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 1. 允许查看 Header（对探测非常有帮助）
curl_setopt($ch, CURLOPT_HEADER, true);

// 2. 这里的配置会影响 SSRF 的成败
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // 设为 false 可以练习 SSRF 中的重定向绕过
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // 连接超时
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 总执行超时（针对 Gopher 稍微调长一点）

// 3. 针对某些 SSRF 场景，禁用 SSL 验证
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$res = curl_exec($ch);
$info = curl_getinfo($ch);

echo "<div style='background:#f4f4f4; padding:10px; border:1px solid #ccc;'>";
echo "<strong>请求耗时:</strong> " . $info["total_time"] . "s | ";
echo "<strong>响应码:</strong> " . $info["http_code"] . " | ";
echo "<strong>接收字节:</strong> " . $info["size_download"] . " bytes<br>";
echo "</div>";

if (curl_errno($ch)) {
    echo "<p style='color:red'><strong>Debug Error:</strong> " .
        curl_error($ch) .
        "</p>";

    // 关键：即使报错（如超时），如果已经拿到了数据（如 Redis 的回复），也尝试强行输出
    if (!empty($res)) {
        echo "<strong>已接收到的残余数据:</strong><pre>" .
            htmlspecialchars($res) .
            "</pre>";
    }
} else {
    echo "<h4>响应内容:</h4>";
    echo "<pre style='background:#000; color:#0f0; padding:15px; overflow:auto;'>" .
        htmlspecialchars($res) .
        "</pre>";
}

curl_close($ch);
?>
<!-- 先探测端口试试 -->
