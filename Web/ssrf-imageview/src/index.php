<?php
function fetch($url)
{
    return @file_get_contents($url);
}

// 默认图片列表
$images = [
    "file:///var/www/html/images/cat0.png",
    "file:///var/www/html/images/cat1.jpeg",
    "file:///var/www/html/images/cat2.jpg",
];

// 当前图片（从 URL 获取）
$current = isset($_GET["img"]) ? $_GET["img"] : $images[0];

// 找索引（用于左右切换）
$index = array_search($current, $images);
if ($index === false) {
    $index = 0;
}

// 渲染当前图片
$data = fetch($current);
$img_src = "";
if ($data) {
    $img_src = "data:image/*;base64," . base64_encode($data);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gallery</title>
<style>
body {
    margin: 0;
    background: #0d0d0d;
    color: #fff;
    font-family: Arial;
    text-align: center;
}

.viewer {
    margin-top: 80px;
    position: relative;
    display: inline-block;
}

img {
    width: 500px;
    border-radius: 12px;
    box-shadow: 0 0 30px rgba(0,0,0,0.6);
}

button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.1);
    border: none;
    color: white;
    font-size: 24px;
    padding: 10px;
    cursor: pointer;
}

.prev { left: -60px; }
.next { right: -60px; }

button:hover {
    background: rgba(255,255,255,0.2);
}
</style>
</head>
<body>

<h2>Photo Gallery</h2>

<div class="viewer">
    <button class="prev" onclick="go(-1)">◀</button>
    <img src="<?php echo $img_src; ?>">
    <button class="next" onclick="go(1)">▶</button>
</div>

<script>
let images = <?php echo json_encode($images); ?>;
let current = "<?php echo htmlspecialchars($current, ENT_QUOTES); ?>";

let index = images.indexOf(current);
if (index === -1) index = 0;

function go(step) {
    let nextIndex = (index + step + images.length) % images.length;
    let nextUrl = images[nextIndex];

    // 👉 关键：切换时 URL 也变化
    window.location.href = "?img=" + encodeURIComponent(nextUrl);
}
</script>

</body>
</html>
