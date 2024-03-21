<?php

//echo "<strong style='font-size: 50px; color: #fff000;'>お知らせ：現在メンテナンス中です、使用は可能ですが動作が不安定になったり、アクセスが突然できなくなる可能性があります。</strong>";

function version() {
  return "1.4.1";
}

function scanMainDirectory() {
  $mainContent = [];

  $mainDir = "./assets/pageData/main";
  $mainFiles = glob("$mainDir/*/main.php");
  foreach ($mainFiles as $file) {
    $dirName = basename(dirname($file));
    $mainContent[$dirName] = $file;
  }

  return $mainContent;
}
$mainContent = scanMainDirectory();
//print_r($mainContent);

function scanBlogDirectory() {
  $blogContent = [];

  $blogDir = "./assets/pageData/blog";
  $blogFiles = glob("$blogDir/*/main.php");
  foreach ($blogFiles as $file) {
    $dirName = basename(dirname($file));
    $blogContent[$dirName] = $file;
  }

  return $blogContent;
}
$blogContent = scanBlogDirectory();
//print_r($blogContent);

function headNavContent($mainContent) {
  $order = ['home', 'service', 'about', 'contact'];
  uksort($mainContent, function($a, $b) use ($order) {
    return array_search($a, $order) - array_search($b, $order);
  });
  foreach ($mainContent as $key => $value) {
    echo "<li><a href='./?{$key}'>{$key}</a></li>";
  }
}

function pageTitle($blogContent, $mainContent) {
  $title = "存在しないページ";
  $description = "存在しないページです。";

  foreach ($mainContent as $mkey => $mvalue) {
    if (isset($_GET[$mkey])) {
      $infoFile = "./assets/pageData/main/{$mkey}/info.json";
      if (file_exists($infoFile)) {
        $info = json_decode(file_get_contents($infoFile), true);
        if ($info !== null) {
          $title = isset($info['title']) ? $info['title'] : '';
          $description = isset($info['description']) ? $info['description'] : '';
          $imageSrc = isset($info['image']) ? $info['image'] : '';
          break;
        }
      }
    }
  }

  if (isset($_GET["service"]) && isset($_GET["blog"])) {
    foreach ($blogContent as $bkey => $bvalue) {
      if ($bkey === $_GET["blog"]) {
        $infoFile = "./assets/pageData/blog/{$bkey}/info.json";
        if (file_exists($infoFile)) {
          $info = json_decode(file_get_contents($infoFile), true);
          if ($info !== null) {
            $title = isset($info['title']) ? $info['title'] : '';
            $description = isset($info['description']) ? $info['description'] : '';
            break;
          }
        }
      }
    }
  }

  return array("title" => $title, "description" => $description, "image" => $imageSrc);
}
$result = pageTitle($blogContent, $mainContent);
$formatTitle = $result["title"];
$description = $result["description"];
$imageSrc = $result["image"];

function blogNav($blogContent) {

/*
ソートできない
function blogNav($blogContent) {
  function compareTime($a, $b) {
    foreach ($blogContent as $bkey => $bvalue) {
      $infoFile = "assets/pageData/blog/{$bkey}/info.json";
      $info = json_decode(file_get_contents($infoFile), true);
      $info['time'];
   
    
      $a = isset($infoA['time']) ? strtotime() : 0;
      $b = isset($infoB['time']) ? strtotime() : 0;
    
      return $a - $b;
    }
  }

  // ブログコンテンツを時間順にソート
  usort($blogContent, 'compareTime');

時間の媒体に使用してるJSONは各フォルダーにあるためそれらをい一回まとめる必要がありforeachによりフォルダー名が入ったbkeyとbvalueに分けそれらを代入し各フォルダー名にあて時間を抽出したのですがソート関数は渡す口が二つもあって難しいです。$info['time']のレングス分の値から差をとってソートして$a - $b;で返せるようにしたいです
*/

  foreach ($blogContent as $bkey => $bvalue) {
    $infoFile = "./assets/pageData/blog/{$bkey}/info.json";
    if (file_exists($infoFile)) {
      $info = json_decode(file_get_contents($infoFile), true);
      if ($info !== null) {
        $title = isset($info['title']) ? $info['title'] : '';
        $description = isset($info['description']) ? $info['description'] : '';
        $imageSrc = isset($info['image']) ? $info['image'] : '';
        $time = isset($info['time']) ? $info['time'] : '';
        $status = isset($info['status']) ? $info['status'] : '';
        echo '
          <article class="card_with_image">
            <a aria-label="ブログリンク" href="./?service&blog=' . $bkey . '">
              <span>' . $status . '</span>
              <img src="' . $imageSrc . '">
              <div>
                <time>' . $time . '</time>
                <h3>' . $title . '</h3>
                <p>' . $description . '</p>
              </div>
            </a>
          </article>
        ';
      } else {
        echo "内部エラー：{$bkey}のinfo.jsonを正しく読み込めませんでした。あなたに解決する手立てはありません<a href='https://21emon.wjg.jp/contact_form/contact.php'>開発者に報告</a>してください。";
      }
    } else {
      echo "内部エラー：{$bkey}の詳細情報が見つかりません。そのことを<a href='https://21emon.wjg.jp/contact_form/contact.php'>開発者に報告</a>してください。";
    }
  }
}

function pageContent($mainContent, $blogContent) {
  //print_r($mainContent);
  //print_r($blogContent);

  $pageTest = false;

  foreach ($mainContent as $mkey => $mvalue) {
    if (isset($_GET[$mkey]) == $mkey && !isset($_GET["blog"])) {
      $pageTest = true;
      $mainPath = $mainContent[$mkey];
      if (isset($mainPath)) {
        include($mainPath);
      } else {
        echo "内部エラー：お探しのメインページが見つかりませんでした。";
      }
      break;
    }
  }

  foreach ($blogContent as $bkey => $bvalue) {
    if (isset($_GET["service"]) && isset($_GET["blog"])) {
      $pageTest = true;
      if (isset($_GET["blog"]) == $bkey) {
        $requestedBlog = $_GET["blog"];
        $blogPath = $blogContent[$requestedBlog];
        if (isset($blogPath)) {
          include($blogPath);
        } else {
          echo "内部エラー：お探しのブログが見つかりませんでした。";
        }
      }
    }
    break;
  }

  if (!$pageTest && !isset($_GET["/"])) {
    echo "内部エラー：お探しのグローバルページが見つかりませんでした。すべてのページでも発生する場合は<a href='https://21emon.wjg.jp/contact_form/contact.php'>開発者に報告</a>してください。";
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=yes,maximum-scale=6.0,minimum-scale=1.0">
    <meta name='description' content='<?php echo $description; ?>'>
    <meta name="keywords" content="PusyuuPortfolio,プシューポートフォリオ,プシューわんこ/,プシュー">
    <meta name="copyright" content="© 2020-2024 created by PusyuuWanko/">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@PusyuuWanko">
    <meta name="twitter:title" content="<?php echo $formatTitle; ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">
    <meta name="twitter:image" content="<?php echo $imageSrc; ?>">
    <title><?php echo $formatTitle; ?></title>
    <link rel="shortcut icon" href="https://21emon.wjg.jp/SystemFolder/IconData/favicon.ico">
    <link rel="stylesheet" href="./assets/cssData/pusyuuStyle.css">
    <script rel="javascript" src="./assets/jsData/pusyuuScript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <script>
      window.addEventListener("DOMContentLoaded", function() {
        VANTA.GLOBE({
          el: "footer",
          mouseControls: true,
          touchControls: true,
          gyroControls: false,
          minHeight: 100.00,
          minWidth: 100.00,
          scale: 1.00,
          scaleMobile: 1.00,
          color: 0xff00,
          color2: 0x3f5d8,
          size: 1.00,
          backgroundColor: 0xaa33a
        })
      });
    </script>
    <!--
      *----------------------------------
      |  ThisPageVersion: <?php echo version(); ?>    |
      |  © 2021-2024 By PusyuuWanko/  |
      |  LastUpdate: 2024-01-23       |
      |  License: none                |
      |  PusyuuPortfolio(^v^)/        |
      *----------------------------------
    -->
  </head>
  <body>
    <div id="loading">
      <div class="load_content">
        <img src="https://21emon.wjg.jp/Profile/pro.jpg" alt="ローディング画像" class="avater_image" style="display: block; box-shadow: 2px 2px 5px #ccc;" oncontextmenu="return false;" onselectstart="return false;" onmousedown="return false;">
      </div>
      <div style="margin: 10px;" class="load_content"> みすぼらしい画面消去中。。。少々お待ちください。 </div>
      <div style="margin: 10px;" class="load_content">
        <details class="center">
          <summary>（ヘルプ）画面が自動的に切り替わりませんか？</summary>
          <div class="box-6">
            <p>次の可能性が考えられます。</p>
            <div class="box-7">
              <h3>このページとの互換性がブラウザに無い↓</h3>
              <p>新しいバージョンのブラウザにアップデートするか別のブラウザで開いてください。</p>
            </div>
            <div class="box-7">
              <h3>途中でキャッシュが削除され、ループ状態になっている↓</h3>
              <p>このページをリロードしてみてください。</p>
            </div>
            <div class="box-7">
              <h3>JavaScriptが無効になっている↓</h3>
              <p>ブラウザ設定で有効になっているか確認してみてください。</p>
            </div>
            <div class="box-7">
              <h3>手動で強制的に画面を切り替える↓</h3>
              <p>こちらのボタンを押して強制的に切り替えてみてください。</p>
              <p>※こちらの機能は、javascriptが有効になってないと機能しません。</p>
              <button style="margin: 10px;" onclick="document.getElementById('loading').classList.add('loaded')">強制切り替え</button>
            </div>
          </div>
        </details>
      </div>
    </div>
    <div class="show">
      <div class="content">
        <div class="titleBox">
          <strong>ほしいという気持ちに正直に！！！</strong>
          <p>Pusyuu Portfolio</p>
        </div>
        <div class="subTitleBox">
          <strong><?php echo $formatTitle ?></strong>
        </div>
      </div>
      <div id="imageSlide">
        <div id="img-01"></div>
        <div id="img-02"></div>
        <div id="img-03"></div>
        <div id="img-04"></div>
      </div>
    </div>
    <header class="header">
      <div class="header_nav">
        <h1 class="header_logo"><a href="#"><img src="https://21emon.wjg.jp/PusyuuPage/IconData/logo-black.png" alt="ロゴ画像" oncontextmenu="return false;" onselectstart="return false;" onmousedown="return false;"></a></h1>
        <a href="#modal_ham_nav" class="modal_menu-btn"></a>
        <div id="modal_ham_nav">
          <div>
            <a href="#navmc"></a>
            <div>
              <nav>
                <ul>
                  <?php headNavContent($mainContent); ?>
                  <li><a href="#websetting">PageSettings</a></li>
                  <li><a href="#webhelp">PageHelp</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
    </header>
    <div id="webhelp" class="modal">
      <div>
        <a aria-label="拡大を閉じるボタン" href="#mc"></a>
        <span>ページヘルプ</span>
        <div>
          <h4>ヘルプ</h4>
          <p>この画面では、直感的な操作で様々なページのセクションにほぼスクロールすることなく、簡単に飛ぶ事ができます。</p>
          <p>ナビゲーションの使用方法：ハンバーガーメニュー（三本線のボタン）または、ナビゲーションバー下に表示されてるバーにある<strong>各自ボタン</strong>をクリックすることで、各コンテンツに移動することができます。</p>
          <h5>こんな時は↓。</h5>
          <ol>
            <li><strong>画面がうまく表示されない、おかしい。</strong>ブラウザの設定でJSやcookieの有効化等の確認と、ブラウザが最新であることを確認してください。</li>
          </ol>
        </div>
      </div>
    </div>
    <div id="websetting" class="modal">
      <div>
        <a aria-label="拡大を閉じるボタン" href="#mc"></a>
        <span>ページ設定</span>
        <div>
          <h3>ページ設定</h3>
          <h4>壁紙変更はこちらからできます</h4>
          <p>※ブラウザキャッシュを削除すると戻ってしまうのでご注意ください。</p>
          <h5>あなたの好きな画像を壁紙を追加↓<h5>
          <input type="file" id="upload-input">
          <h5>壁紙を選択↓</h5>
          <select id="background-select">
          </select>
        </div>
      </div>
    </div>
    <main class="main" style="min-height: 100vh;">
      <div class="main_wrapper">
        <?php pageContent($mainContent, $blogContent);?>
      </div>
    </main>
    <footer class="footer center">
      <div class="column normal-box">
        <h3>サイト概要</h3>
        <p>このサイトはプシューという人のポートフォリオと名乗ってる場所です。</p>
        <div class="img-frame">
          <div class="img-01" style="background-image: url('./assets/imageData/1.jpg');"></div>
          <div class="img-02" style="background-image: url('./assets/imageData/2.jpg');"></div>
          <div class="img-03" style="background-image: url('./assets/imageData/3.jpg');"></div>
        </div>
      </div>
      <div class="column normal-box">
        <h3>システム情報</h3>
        <?php
          $ipAddress = $_SERVER['REMOTE_ADDR'];
          echo "<p>あなたのIPアドレスは： " . $ipAddress . "</p>";
          echo "<p>ページのバージョンは：" . version() . "</p>"; 
                ?>
      </div>
      <div class="column normal-box">
        <h3>その他のプロダクト</h3>
        <a href="https://21emon.wjg.jp/Profile/?hatatinaritakunai" target="_blank">二十歳にはなりたくないー、そんなプシューの気持ちのサイト</a>
        <a href="https://21emon.wjg.jp/oldPusyuuPage" target="_blank">古代プシュー</a>
        <a href="https://21emon.wjg.jp/bbs_of_php" target="_blank">プシューIPS/PusyuuIPS</a>
        <a href="https://21emon.wjg.jp/Profile" target="_blank">プシューわんこ/プロフィール</a>
        <a href="https://21emon.wjg.jp/PusyuuAppStore" target="_blank">プシューアプリストア</a>
        <a href="https://21emon.wjg.jp/koukaon" target="_blank">プシュー効果音</a>
        <a href="https://21emon.wjg.jp/japan" target="_blank">美しい日本の文化を〜</a>
        <a href="https://21emon.wjg.jp/PusyuuPage/PageData/p1" target="_blank">プシューページ</a>
        <a href="https://21emon.wjg.jp" target="_blank">プシューゲートウェイ</a>
      </div>
      <div class="column normal-box">
        <h3>規約等</h3>
        <a href="https://21emon.wjg.jp/TermsAndPrivacypolicy/terms" target="_blank">利用規約</a>
        <a href="https://21emon.wjg.jp/TermsAndPrivacypolicy/privacypolicy" target="_blank">プライバシーポリシー</a>
        <small>© 2020-2024 Created By PusyuuWanko/</small>
      </div>
    </footer>
  </body>
</html>
