<?php try {
    $pdo = new PDO("mysql:host=localhost;dbname=bbs-db;", "root", "");
    $stmt = $pdo->prepare("SELECT COUNT(*) AS num FROM post");
    $stmt->execute();
    foreach ($stmt as $row) {
        $counter = $row["num"];
    }
    $c = json_encode($counter);
    $stmt = $pdo->prepare("SELECT * FROM post");
    $stmt->execute();
    $userData = [];
    $status_array = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rtns[] = [
            "id" => $row["id"],
            "name" => $row["text"],
            "status" => $row["status"],
        ];
        $a = 0;
        do {
            $max_id = $row["id"];
            $a++;
        } while ($row["id"] < $a);
        $status_array[] = $row["status"];
        echo '<script>';
        echo 'console.log("⚙️array:" + ' . json_encode($status_array) . ')';
        echo '</script>';
        $i = 0;
        $loop = false;
        do {
            $loop = false;
            $a = mt_rand(000000000000000000, 999999999999999999);
            $b = mt_rand(0, 9);
            $status = array($a . $b);
            foreach ($status as $key => $value) {
                $test = $value;
            }
            if (count(array_diff($status, $status_array)) !== 0) {
                $loop = true;
            }
            $i++;
        } while ($loop == false);
    }
    error_reporting(0);
    $json = json_encode($rtns);
    $stmt = $pdo->prepare(
        "INSERT INTO post (text, status) VALUES(:text, :status)"
    );
    if (isset($_POST["commit"])) {
        $commit = $_POST["commit"];
        $stmt->bindValue(":text", $commit);
        $stmt->bindValue(":status", $test);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header("Location:index.php");
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
        <div class="DivLink0" style="height: 173px;">
            <p class="home">ホーム</p>
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
                                <form action="index.php?" method="post">
                                    <input id="commit" type="text" type="hidden" name="commit" placeholder="いまどうしてる？" />
                                    <button class="" id="but" type="submit" disabled>ツイートする</button>
                                </form>
                            </div>
                            <div class="twitter__icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacing" id="spacing">
        </div>
    </div>
    <div class="localNavigation">
        <h1><b class="dev" style="color: #000;">開発者のツイート</b></h1>
        <a class="twitter-timeline" data-width="348" data-theme="light" href="https://twitter.com/doremire0?ref_src=twsrc%5Etfw">Tweets by doremire0</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <script src="./script.js"></script>
    <script>
        const array = <?php echo $json; ?>;
        const c = <?php echo $c; ?>;
        let i = 0
        const post = document.getElementById('text');
        while (i < c) {
            const element = document.getElementById('spacing');
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
            ${array[i].name}
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
            element.parentNode.insertBefore(div, element.nextSibling);
            i++;
        }
    </script>

</html>