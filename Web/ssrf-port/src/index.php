<?php
$url = "http://127.0.0.1:80/meow.html";

if (!empty($_GET["url"])) {
    $url = $_GET["url"];
}

$content = "";
$error = "";

if (isset($_GET["fetch"])) {
    $content = @file_get_contents($url);
    if ($content === false) {
        $error = "Fetch failed";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Web Fetcher</title>

<style>
body {
    margin: 0;
    background: #0f1115;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #e5e7eb;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* 卡片 */
.container {
    width: 820px;
    background: #161922;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}

/* 标题 */
h1 {
    font-size: 20px;
    margin-bottom: 16px;
    font-weight: 600;
}

/* 输入区域 */
form {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}

input {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #2a2f3a;
    background: #0f1115;
    color: #fff;
    outline: none;
}

button {
    padding: 12px 18px;
    border-radius: 10px;
    border: none;
    background: #4f46e5;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background: #4338ca;
}

/* 预览框 */
.preview {
    margin-top: 12px;
    background: #0b0d12;
    border: 1px solid #2a2f3a;
    border-radius: 12px;
    padding: 14px;
    height: 420px;
    overflow: auto;
    white-space: pre-wrap;
    font-family: monospace;
    font-size: 13px;
    color: #d1d5db;
}

/* error */
.error {
    color: #f87171;
    margin-top: 10px;
}
</style>
</head>

<body>

<div class="container">
    <h1>📡 Web Fetcher</h1>

    <form method="GET">
        <input name="url" value="<?php echo htmlspecialchars($url); ?>">
        <button type="submit" name="fetch">Fetch</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="preview">
<?php if ($content) {
    echo htmlspecialchars($content);
} else {
    echo "Click Fetch to load content...";
} ?>
    </div>
</div>

</body>
</html>
