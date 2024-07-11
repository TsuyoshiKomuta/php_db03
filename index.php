<?php
session_start();
?>
<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>そうぞくMAP</title>
    <link rel='stylesheet' href='styles.css'>
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code:wght@100..700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- ヘッダー -->
    <header class='header'>
        <div class='logo'>
            <a href='index.php'><img src='images/logo_souzokumap.png' alt='そうぞくMAPロゴ'></a>
        </div>
        <nav class='nav-links'>
            <!-- ナビゲーションリンクをここに追加する -->
        </nav>
        <div class='nav-buttons'>
            <button class='logout-button'>ログアウト</button>
        </div>
    </header>

    <!-- ウェルカムメッセージの表示 -->
    <div id="welcome-message" class="welcome-message">
        <h1>そうぞくMAPへようこそ</h1>
    </div>

    <div id="bubble-message" class="bubble-message" style="display: none;">
        <p>トラさんの遺産配分を考えています</p>
    </div>

    <div class='container'>
        <div class='row'>
            <div class='circle-container'>
                <div class='circle e-person highlight-third' id='person-E'></div>
                <span class='label'>トリ</span>
            </div>

            <div class='dotted-line with-vertical-line'></div>
            <div class='circle-container'>
                <div class='circle a-person highlight-decedent' id='person-A'></div>
                <span class='label'>トラ</span>
            </div>
            <div class='marriage with-vertical-line'></div>
            <div class='circle-container'>
                <div class='circle b-person highlight-heir' id='person-B'></div>
                <span class='label'>カモノハシ</span>
            </div>
        </div>
        <div class='row'>
            <div class='spacer'></div>
            <div class='circle-container'>
                <div class='circle f-person highlight-heir' id='person-F'></div>
                <span class='label'>ブタ</span>
            </div>
            <div class='spacer' style='margin-right: 30px'></div>
            <div class='circle-container'>
                <div class='circle c-person highlight-heir' id='person-C' style='margin-left: 10px;'></div>
                <span class='label'>クマ</span>
            </div>
            <div class='circle-container'>
                <div class='circle d-person highlight-heir' id='person-D'></div>
                <span class='label'>アライグマ</span>
            </div>
        </div>
    </div>

    <div id="circular-menu" class="circular-menu">
        <div class="menu-item" id="menu-details">詳細</div>
        <div class="menu-item" id="menu-input">入力</div>
        <div class="menu-item" id="menu-family">家族</div>
    </div>

    <!-- 入力フォーム -->
    <div id="input-form" class="details">
        <h2>入力</h2>
        <form id="asset-input-form">
            <div class="asset">
                <label>名前：</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="asset">
                <label>住所：</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="asset">
                <label>生年月日：</label>
                <input type="date" id="birth_date" name="birth_date" required>
            </div>
            <div class="asset">
                <label>死亡年月日：</label>
                <input type="date" id="death_date" name="death_date">
            </div>
            <div class="asset">
                <label>土地：</label>
                <input type="text" id="land" name="land" placeholder="場所の市町村を入力">
            </div>
            <div class="asset">
                <label>建物：</label>
                <input type="text" id="building" name="building" placeholder="場所の市町村を入力">
            </div>
            <div class="asset">
                <label>預貯金：</label>
                <input type="number" id="money" name="money" placeholder="「A銀行B支店」などを入力">
            </div>
            <button type="submit">保存</button>
        </form>
    </div>

    <!-- トラ用詳細フォーム -->
    <div id="details-tiger" class="details">
        <h2 id="details-title-tiger">詳細</h2>
        <!-- <p>ID：<span id="details-id-tiger"></span></p> -->
        <p>名前：<span id="details-name-tiger"></span></p>
        <p>住所：<span id="details-address-tiger"></span></p>
        <p>生年月日：<span id="details-birth-date-tiger"></span></p>
        <p>死亡年月日：<span id="details-death-date-tiger"></span></p>
        <p>土地：<span id="details-land-tiger"></span></p>
        <p>建物：<span id="details-building-tiger"></span></p>
        <p>預貯金：<span id="details-money-tiger"></span></p>
        <button id="update-button-tiger">編集</button>
        <button id="delete-button-tiger">削除</button>
    </div>

    <!-- トラ以外のキャラクター用詳細フォーム -->
    <div id="details" class="details">
        <h2 id="details-title">詳細</h2>
        <!-- <p>ID：<span id="details-id"></span></p> -->
        <p>名前：<span id="details-name"></span></p>
        <p>住所：<span id="details-address"></span></p>
        <p>生年月日：<span id="details-birth-date"></span></p>
        <p>死亡年月日：<span id="details-death-date"></span></p>
        <p>土地：<span id="details-land"></span></p>
        <p>建物：<span id="details-building"></span></p>
        <p>預貯金：<span id="details-money"></span></p>
        <p><strong>トラからの遺産（遺言書がない場合）：</strong></p>
        <p>土地：<span id="inherit-land"></span></p>
        <p>建物：<span id="inherit-building"></span></p>
        <p>預貯金：<span id="inherit-money"></span></p>
        <p><strong>法定相続人（法定相続分）：</strong></p>
        <ul id="details-inheritors"></ul>
        <button id="update-button">編集</button>
        <button id="delete-button">削除</button>
    </div>

    <!-- 編集フォーム -->
    <div id="edit-form" class="details">
        <h2>編集</h2>
        <form id="edit-character-form">
            <input type="hidden" id="edit-id" name="id">
            <div class="asset">
                <label>名前：</label>
                <input type="text" id="edit-name" name="name" required>
            </div>
            <div class="asset">
                <label>住所：</label>
                <input type="text" id="edit-address" name="address" required>
            </div>
            <div class="asset">
                <label>生年月日：</label>
                <input type="date" id="edit-birth-date" name="birth_date" required>
            </div>
            <div class="asset">
                <label>死亡年月日：</label>
                <input type="date" id="edit-death-date" name="death_date">
            </div>
            <div class="asset">
                <label>土地：</label>
                <input type="text" id="edit-land" name="land" placeholder="場所の市町村を入力">
            </div>
            <div class="asset">
                <label>建物：</label>
                <input type="text" id="edit-building" name="building" placeholder="場所の市町村を入力">
            </div>
            <div class="asset">
                <label>預貯金：</label>
                <input type="number" id="edit-money" name="money" placeholder="「A銀行B支店」などを入力">
            </div>
            <button type="submit">編集完了</button>
        </form>
    </div>

    <!-- フッター -->
    <footer>
        © 2024 com-office.
    </footer>

    <!-- jquery読み込み -->
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.min.js'></script>
    <script>
        // PHPからセッションデータを取得
        const tigerData = <?php echo json_encode($_SESSION['tiger'] ?? null); ?>;
        console.log("Tiger Data:", tigerData); // デバッグ用
    </script>
    <script src='script.js'></script>
</body>

</html>