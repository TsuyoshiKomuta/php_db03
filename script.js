$(document).ready(function () {
    setTimeout(function () {
        $('#welcome-message').fadeOut('slow', function () {
            $('#bubble-message').fadeIn('slow', function () {
                $('.container').fadeIn('slow');
            });
        });
    }, 3000);

    // ダイアログの初期化
    $('#input-form').dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        width: 400,
        title: "入力"
    });

    $('#details-tiger').dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        width: 400,
        title: "詳細"
    });

    $('#details').dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        width: 400,
        title: "詳細"
    });

    $('#edit-form').dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        width: 400,
        title: "編集"
    });
});

$(function () {
    const defaultData = {
        "person-A": {
            name: "トラ",
            address: "福岡市",
            birth_date: "1973-01-01",
            death_date: "",
            land: "",
            building: "",
            money: ""
        },
        "person-B": {
            name: "カモノハシ",
            address: "福岡市",
            birth_date: "1973-02-01",
            death_date: "",
            land: "",
            building: "",
            money: ""
        },
        "person-C": {
            name: "クマ",
            address: "東京都",
            birth_date: "2007-01-01",
            death_date: "",
            land: "",
            building: "",
            money: ""
        },
        "person-D": {
            name: "アライグマ",
            address: "福岡市",
            birth_date: "2009-01-01",
            death_date: "",
            land: "",
            building: "",
            money: ""
        },
        "person-E": {
            name: "トリ",
            address: "大阪市",
            birth_date: "1973-03-01",
            death_date: "",
            land: "",
            building: "",
            money: ""
        },
        "person-F": {
            name: "ブタ",
            address: "神戸市",
            birth_date: "2005-01-01",
            death_date: "",
            land: "",
            building: "",
            money: ""
        }
    };

    const inheritanceShare = {
        "person-B": 0.5,  // カモノハシ
        "person-C": 1 / 6,  // クマ
        "person-D": 1 / 6,  // アライグマ
        "person-F": 1 / 6   // ブタ
    };

    let selectedCharacterId = null;

    // 円形メニューの表示
    $('.circle').on('click', function (event) {
        event.stopPropagation(); // イベントのバブリングを防ぐ
        const characterPosition = $(this).offset();
        console.log("Character Position:", characterPosition); // デバッグ用
        $('#circular-menu').css({
            top: characterPosition.top + $(this).height() / 2 - $('#circular-menu').height() / 2,
            left: characterPosition.left + $(this).width() / 2 - $('#circular-menu').width() / 2
        }).show();
        selectedCharacterId = $(this).attr('id'); // 選択されたキャラクターのIDを保存
        console.log("Selected Character ID:", selectedCharacterId); // デバッグ用
    });

    // メニュー外をクリックしたら非表示にする
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.circle, #circular-menu').length) {
            $('#circular-menu').hide();
        }
    });

    // 入力メニューのクリックイベント
    $('#menu-input').on('click', function () {
        $('#circular-menu').hide();
        const characterData = defaultData[selectedCharacterId];
        console.log("Character Data for Input:", characterData); // デバッグ用
        $('#name').val(characterData.name);
        $('#address').val(characterData.address);
        $('#birth_date').val(characterData.birth_date);
        $('#death_date').val(characterData.death_date);
        $('#land').val(characterData.land);
        $('#building').val(characterData.building);
        $('#money').val(characterData.money);
        $('#input-form').dialog('open');
    });

    // バツボタンをクリックしてフォームを閉じる
    $(document).on('click', '.ui-dialog-titlebar-close', function () {
        $(this).closest('.ui-dialog-content').dialog('close');
    });

    // 詳細メニューのクリックイベント
    $('#menu-details').on('click', function () {
        $('#circular-menu').hide();

        if (selectedCharacterId === "person-A") {
            // トラの詳細を表示
            const characterData = defaultData[selectedCharacterId];
            console.log("Character Data for Details (Tiger):", characterData); // デバッグ用
            $.ajax({
                url: 'get_details.php',
                method: 'GET',
                data: { name: characterData.name },
                dataType: 'json',
                success: function (data) {
                    console.log("Response Data for Tiger:", data); // デバッグ用
                    $('#details-id-tiger').text(data.id);
                    $('#details-name-tiger').text(data.name);
                    $('#details-address-tiger').text(data.address);
                    $('#details-birth-date-tiger').text(data.birth_date);
                    $('#details-death-date-tiger').text(data.death_date);
                    $('#details-land-tiger').text(data.land);
                    $('#details-building-tiger').text(data.building);
                    $('#details-money-tiger').text(data.money);
                    $('#details-tiger').dialog('open');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('詳細情報の取得に失敗しました:', textStatus, errorThrown);
                }
            });
        } else {
            // トラ以外のキャラクターの詳細を表示
            const characterData = defaultData[selectedCharacterId];
            console.log("Character Data for Details:", characterData); // デバッグ用

            $('#details-id').text(characterData.id);
            $('#details-name').text(characterData.name);
            $('#details-address').text(characterData.address);
            $('#details-birth-date').text(characterData.birth_date);
            $('#details-death-date').text(characterData.death_date);
            $('#details-land').text(characterData.land);
            $('#details-building').text(characterData.building);
            $('#details-money').text(characterData.money);

            // トラからの遺産分配を表示
            console.log("Selected Character ID:", selectedCharacterId); // デバッグ用
            console.log("Inheritance Share:", inheritanceShare[selectedCharacterId]); // デバッグ用
            console.log("Tiger Data:", tigerData); // デバッグ用

            if (inheritanceShare[selectedCharacterId] && tigerData) {
                const share = inheritanceShare[selectedCharacterId];
                $('#inherit-land').text(tigerData.land ? `${tigerData.land} / ${share}` : 'なし');
                $('#inherit-building').text(tigerData.building ? `${tigerData.building} / ${share}` : 'なし');
                $('#inherit-money').text(tigerData.money ? `${tigerData.money} / ${share}` : 'なし');
            } else {
                $('#inherit-land').text('なし（相続人ではない）');
                $('#inherit-building').text('なし（相続人ではない）');
                $('#inherit-money').text('なし（相続人ではない）');
            }

            // 相続分の表示
            if (inheritanceShare[selectedCharacterId]) {
                $('#details-inheritors').html(`<li>${characterData.name}: ${inheritanceShare[selectedCharacterId]}</li>`);
            } else {
                $('#details-inheritors').html('<li>なし</li>');
            }

            $('#details').dialog('open');
        }
    });

    // フォームの送信イベント
    $('#asset-input-form').on('submit', function (event) {
        event.preventDefault();
        const formData = $(this).serialize();

        // コンソールにデータをログ出力して確認
        console.log("送信データ:", formData);

        // サーバーにデータを送信
        $.ajax({
            url: 'create.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                alert('データが保存されました。');
                $('#input-form').dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('データの保存に失敗しました:', textStatus, errorThrown);
            }
        });
    });

    // フォーム外をクリックしたら非表示にする
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.ui-dialog, .circle, #circular-menu').length) {
            $('.ui-dialog-content').dialog('close');
        }
    });

    // 編集ボタンのクリックイベント
    $('#update-button').on('click', function () {
        const characterData = {
            id: $('#details-id').text(), // IDを追加,
            name: $('#details-name').text(),
            address: $('#details-address').text(),
            birth_date: $('#details-birth-date').text(),
            death_date: $('#details-death-date').text(),
            land: $('#details-land').text(),
            building: $('#details-building').text(),
            money: $('#details-money').text()
        };

        console.log("characterDataの内容", characterData);

        // 編集フォームを開いてデータをセット
        $('#edit-id').val(characterData.id);
        $('#edit-name').val(characterData.name);
        $('#edit-address').val(characterData.address);
        $('#edit-birth-date').val(characterData.birth_date);
        $('#edit-death-date').val(characterData.death_date);
        $('#edit-land').val(characterData.land);
        $('#edit-building').val(characterData.building);
        $('#edit-money').val(characterData.money);

        // 詳細ダイアログを閉じて編集ダイアログを開く
        $('#details').dialog('close');
        $('#edit-form').dialog('open');
    });

    // 編集フォームの送信イベント
    $('#edit-character-form').on('submit', function (event) {
        event.preventDefault();
        const formData = $(this).serialize();

        // コンソールにデータをログ出力して確認
        console.log("送信データ:", formData);

        // データをサーバーに送信して更新
        $.ajax({
            url: 'update.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                console.log('サーバーレスポンス:', response);
                alert('データが更新されました。');
                $('#edit-form').dialog('close');
                // location.reload(); // ページをリロードして変更を反映
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('データの更新に失敗しました:', textStatus, errorThrown);
            }
        });
    });

    // 削除ボタンのクリックイベント
    $('#delete-button').on('click', function () {
        const confirmDelete = confirm('本当に削除しますか？');
        if (confirmDelete) {
            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: { id: $('#details-id').text() }, // データベースのIDを送信
                success: function (response) {
                    alert('データが削除されました。');
                    location.reload(); // ページをリロードして変更を反映
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('データの削除に失敗しました:', textStatus, errorThrown);
                }
            });
        }
    });

});
