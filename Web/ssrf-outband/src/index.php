<?php
// 宇宙最高机密 Flag
$FLAG = "flag{test_flag}";

// 拦截并处理前端的建立连接请求
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] === "broadcast"
) {
    header("Content-Type: application/json");

    $receiver_url = $_POST["url"] ?? "";

    if (empty($receiver_url)) {
        echo json_encode([
            "status" => "error",
            "message" => "系统警告：未检测到目标接收器坐标！",
        ]);
        exit();
    }

    // 【核心 SSRF 漏洞点 (POST请求版)】：
    // 构建要 POST 给目标 URL 的外星数据
    $alien_payload = http_build_query([
        "source" => "Orion_Cygnus_Arm",
        "encryption" => "Quantum_Entanglement",
        "secret_message" => $FLAG,
    ]);

    // 配置流上下文，发起 POST 请求
    $context = stream_context_create([
        "http" => [
            "method" => "POST",
            "header" =>
                "Content-Type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " .
                strlen($alien_payload) .
                "\r\n" .
                "X-Transmitter-Location: Singapore-Deep-Space-Array\r\n" . // 伪造的科幻请求头
                "User-Agent: A.E.T.I-Core-Relay/v2026.04\r\n",
            "content" => $alien_payload,
            "timeout" => 3,
            "ignore_errors" => true,
        ],
    ]);

    // 服务器向用户指定的 URL 发送 POST 请求，泄露 Flag
    $response = @file_get_contents($receiver_url, false, $context);

    if ($response !== false || isset($http_response_header)) {
        echo json_encode([
            "status" => "success",
            "message" =>
                "折跃成功！已通过 HTTP POST 协议将高维数据块推送至目标节点。",
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "通讯崩溃：目标节点拒绝接收量子数据包。",
        ]);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>A.E.T.I - 中国深空前哨</title>
    <style>
        body {
            background-color: #050510;
            color: #00ffcc;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            background-image: radial-gradient(circle, #050510 0%, #001122 100%);
        }
        .container {
            text-align: center;
            border: 1px solid #00ffcc;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 40px rgba(0, 255, 204, 0.15);
            background: rgba(0, 15, 20, 0.85);
            width: 600px;
            backdrop-filter: blur(10px);
        }
        h1 {
            text-transform: uppercase;
            letter-spacing: 5px;
            text-shadow: 0 0 15px #00ffcc;
            margin-bottom: 5px;
            font-size: 1.8em;
        }
        .subtitle {
            font-size: 0.85em;
            color: #00aa88;
            margin-bottom: 20px;
            border-bottom: 1px dashed #00aa88;
            padding-bottom: 10px;
        }
        .story-box {
            text-align: left;
            font-size: 0.9em;
            line-height: 1.5;
            color: #aaaacc;
            background: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-left: 3px solid #00aa88;
            margin-bottom: 25px;
        }
        .highlight { color: #ffbb00; font-weight: bold; }

        /* CSS 雷达动画 */
        .radar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #00ffcc;
            margin: 0 auto 20px auto;
            position: relative;
            overflow: hidden;
            background: repeating-radial-gradient(
                rgba(0, 255, 204, 0.05) 0%,
                rgba(0, 255, 204, 0.05) 10%,
                transparent 11%,
                transparent 20%
            );
        }
        .radar::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ffcc);
            transform-origin: left center;
            animation: scan 1.5s linear infinite;
        }
        @keyframes scan {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }
        input[type="text"] {
            width: 85%;
            padding: 12px;
            background: #000;
            border: 1px solid #00ffcc;
            color: #00ffcc;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 20px;
            outline: none;
            text-align: center;
        }
        input[type="text"]:focus {
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.5);
        }
        button {
            background: rgba(0, 255, 204, 0.1);
            color: #00ffcc;
            border: 1px solid #00ffcc;
            padding: 12px 25px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }
        button:hover {
            background: #00ffcc;
            color: #000;
            box-shadow: 0 0 20px #00ffcc;
        }
        #terminal {
            margin-top: 25px;
            font-size: 0.9em;
            color: #ff3366;
            min-height: 40px;
            text-align: left;
            background: #000;
            padding: 10px;
            border-left: 3px solid #ff3366;
        }
        .success-text {
            color: #00ffcc !important;
            border-left: 3px solid #00ffcc !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>A.E.T.I 深空前哨站</h1>
        <div class="subtitle">DATE: 2026.04.14 | LOCATION: SINGAPORE ARRAY | STATUS: OVERLOAD</div>

        <div class="story-box">
            > <strong>日志档案 #774-Alpha:</strong><br>
            位于中国的深空监听阵列截获了一段来自猎户座天鹅臂的异常高频脉冲。<br>
            硅基外星实体拒绝使用低效的 GET 请求，它们正在尝试通过 <span class="highlight">HTTP POST 协议</span> 强行下发包含“宇宙终极秘密”的加密数据块。<br>
            > <strong>系统警告：</strong> 本地缓冲池即将溢出！必须立即提供一个外部接收器 URL，由主服务器将数据 <span class="highlight">POST</span> 转发出去！
        </div>

        <div class="radar"></div>

        <input type="text" id="urlInput" placeholder="输入外部接收节点">
        <br>
        <button onclick="establishConnection()">初始化 POST 折跃引击</button>

        <div id="terminal">[系统待机] 等待接收节点坐标...</div>
    </div>

    <script>
        function typeWriter(text, elementId, isSuccess, speed=25) {
            const terminal = document.getElementById(elementId);
            terminal.innerHTML = "";
            terminal.className = isSuccess ? "success-text" : "";

            let i = 0;
            function type() {
                if (i < text.length) {
                    terminal.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        function establishConnection() {
            const url = document.getElementById('urlInput').value;

            if (!url) {
                typeWriter("[!] 严重错误: 坐标丢失，无法建立引力波链路。", "terminal", false);
                return;
            }

            typeWriter("[*] 正在构建数据流... 准备执行 POST 协议中继...", "terminal", true);

            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=broadcast&url=' + encodeURIComponent(url)
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    typeWriter("[+] 传输完成! " + data.message, "terminal", true);
                } else {
                    typeWriter("[-] 错误: " + data.message, "terminal", false);
                }
            })
            .catch(error => {
                typeWriter("[-] 链路崩溃: 亚空间通讯受阻。", "terminal", false);
            });
        }
    </script>
</body>
</html>
