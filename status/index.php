<?php try {
    $pdo = new PDO("mysql:host=localhost;dbname=bbs-db;", "root", "");
    $stmt = $pdo->prepare("SELECT COUNT(*) AS num FROM reply");
    $stmt->execute();
    foreach ($stmt as $row) {
        $counter = $row["num"];
    }
    $c = json_encode($counter);
    $pass = (int)substr($_SERVER['REQUEST_URI'], 8);
    $stmt = $pdo->prepare("SELECT * FROM post WHERE status = " . $pass . "");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rtns[] = [
            "id" => $row["id"],
            "name" => $row["text"],
            "status" => (int)$row["status"],
        ];
    }
    error_reporting(0);
    $json = json_encode($rtns);
    $passs = json_encode($pass);
    $stmt = $pdo->prepare("SELECT * FROM reply WHERE status = " . $pass . "");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rtnss[] = [
            "id" => $row["id"],
            "name" => $row["text"],
            "status" => $row["status"],
        ];
    }
    error_reporting(0);
    $jsons = json_encode($rtnss);
    $stmt = $pdo->prepare(
        "INSERT INTO reply (text, status) VALUES(:text, :status)"
    );
    if (isset($_POST["commit"])) {
        $commit = $_POST["commit"];
        $stmt->bindValue(":text", $commit);
        $stmt->bindValue(":status", (int)$pass);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header("location:index.php");
    }
    if (!empty($commit)) {
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo $e->getMessage();
} finally {
    $pdo = null;
} ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>

<body>
    <div class="grovalNavigation">
    </div>
    <div class="post">
        <div class="DivLink1" id="DivLink1">
            <p class="home">ツイート</p>
        </div>
        <div class="DivLink0" style="height: 152px;">
            <div class="twitter__container">
                <div class="twitter__title">
                    <span class="twitter-logo"></span>
                </div>
                <div class="twitter__contents scroll">
                    <div class="twitter__block">
                        <figure>
                            <img src="icon.png" />
                        </figure>
                        <div class="twitter__block-text">
                            <div class="text" style="margin-top: 15px;">
                                <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
                                    <input id="commit" type="text" type="hidden" name="commit" placeholder="返信をツイート" />
                                    <button class="" id="but" type="submit" disabled>返信</button>
                                </form>
                            </div>
                            <div class="twitter__icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacing1" id="spacing1"></div>
    </div>
    <div class="localNavigation">
        <h1><b class="dev" style="color: #000;">開発者のツイート</b></h1>
        <a class="twitter-timeline" data-width="348" data-theme="light" href="https://twitter.com/doremire0?ref_src=twsrc%5Etfw">Tweets by doremire0</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <script src="./script.js"></script>
    <script>
        const array = <?php echo $json; ?>;
        const arrays = <?php echo $jsons; ?>;
        const pass = <?php echo $passs; ?>;
        const c = <?php echo $c; ?>;
        let i = 0
        let o = 0
        const but = document.getElementById('but');
        const tweet_but = document.getElementById('commit').addEventListener('click', function(e) {
            but.style.marginTop = "27px";
        });
        if (location.pathname == "/status/index.php") {
            document.location.href = `${document.referrer}`;
        }
        if (o == 0) {
            const post = document.getElementById('text');
            const element = document.getElementById('spacing');
            const element0 = document.getElementById('DivLink1');
            var div = document.createElement('div');
            div.innerHTML = `<div class="DivLink">
            <div class="twitter__container">
            <div class="twitter__title">
            <span class="twitter-logo"></span>
            </div>
            <div class="twitter__contents scroll">
            <div class="twitter__block">
            <figure>
            <img src="icon.png" />
            </figure>
            <div class="twitter__block-text">
            <div class="name">ゲスト<span class="name_reply">@guest _user</span></div>
            <div class="date">YYYY/MM/DD</div>
            <div class="text">
            ${array[0].name}
            </div>
            <div class="twitter__icon">
            <span class="twitter-bubble"></span>
            <span class="twitter-loop"></span>
            <span class="twitter-heart"></span>
            </div>
            </div>
            </div>
            </div>
            </div>
            <a tabindex="0" class="Link" href="http://localhost:3000/status/${array[i].status}"></a>
            </div>
            <div class="spacing" id="spacing"></div>`;
            element0.parentNode.insertBefore(div, element0.nextSibling);
        }
        while (i < c) {
            const post = document.getElementById('text');
            const element = document.getElementById('spacing1');
            const element0 = document.getElementById('DivLink0');
            var div = document.createElement('div');
            div.innerHTML = `<div class="DivLink">
            <div class="twitter__container">
            <div class="twitter__title">
            <span class="twitter-logo"></span>
            </div>
            <div class="twitter__contents scroll">
            <div class="twitter__block">
            <figure>
            <img src="icon.png" />
            </figure>
            <div class="twitter__block-text">
            <div class="name">ゲスト<span class="name_reply">@guest _user</span></div>
            <div class="date">YYYY/MM/DD</div>
            <div class="text">
            ${arrays[i].name}
            </div>
            <div class="twitter__icon">
            <span class="twitter-bubble"></span>
            <span class="twitter-loop"></span>
            <span class="twitter-heart"></span>
            </div>
            </div>
            </div>
            </div>
            </div>
            <a tabindex="0" class="Link" href="http://localhost:3000/status/${arrays[i].status}"></a>
            </div>
            <div class="spacing" id="spacing"></div>`;
            element.parentNode.insertBefore(div, element.nextSibling);
            i++;
        }
    </script>

</html>