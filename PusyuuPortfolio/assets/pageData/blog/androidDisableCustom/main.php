        <section class="section">
          <h2>Androidの無効にできないアプリをRoot化せずアンインストールする方法</h2>
          <h3>目次</h3>
          <ol class="marukado_waku">
            <li><a href="#p1">ADBコマンドで行う</a></li>
            <li><a href="#p2">Package Disablerを使う</a></li>
            <li><a href="#p3">まとめ</a></li>
          </ol>
          <article class="article" id="p1">
            <h3>ADBコマンドで行う</h3>
            <p>androidアプリの中にこれ消したいのに全然消えないってアプリってありませんか？そんなアプリを強制無効化またはアンインストールさせることができます。案外簡単にできますし失敗したときは最悪初期化するだけでシステム（オペレーティングシステム）を破壊しない方法なのでもとに戻せます。では方法に移りましょう↓</p>
            <h4>1. 事前準備</h4>
            <p>まずはAdbコマンドを使える状態にしましょうパソコンでこれからも使う場合は<a href="https://xdaforums.com/t/official-tool-windows-adb-fastboot-and-drivers-15-seconds-adb-installer-v1-4-3.2588979/" target="_blank">こちらの15 seconds ADB Installer</a>を使用してインストールすることをおすすめします。</p>
            <ol>
              <li><img src="./assets/imageData/android-adb-disa-1.png" class="img-rs_tyuu image_zoom"></li>
              <li><img src="./assets/imageData/android-adb-disa-2.png" class="img-rs_tyuu image_zoom"></li>
              <li><img src="./assets/imageData/android-adb-disa-3.png" class="img-rs_tyuu image_zoom"></li>
              <li><img src="./assets/imageData/android-adb-disa-4.png" class="img-rs_tyuu image_zoom"></li>
            </ol>
            <p>もしも一度しかつかわないというのであればgoogleが公式で出している<a href="https://developer.android.com/tools/releases/platform-tools?hl=ja#downloads" target="_blank">こちらのプラットフォームツールズ</a>を使用することをおすすめします</p>
            <ol>
              <li><img src="" class="img-rs_tyuu image_zoom"></li>
              <li><img src="" class="img-rs_tyuu image_zoom"></li>
            </ol>
            <p>上記の項目が完了したら、デバイス（スマホなど）の設定を開き、デバイス情報または端末情報を開きビルド番号という項目を連打してください。すると隠された設定が一つ上のシステムという項目または設定のホーム画面に開発者オプションが表示されますのでOFFになってい場合があるのでONにしその場合にダイアログが表示されるのでOKを押しそのなかの<strong>adbデバッグ</strong>にチェックボックスにチェックるとダイアログが出る場合がありますがOKを押し準備は完了です。</p>
            <h4>2. 消したいアプリのパッケージ名を探す</h4>
            <p>アプリを消す際にみなさんが使っているようなアプリの名前ではコンピュータが理解するのは難しいためアプリを開発する前アプリにつけるパッケージ名を探す必要があります。とはいえそんなに心配しないでください、専用のアプリも存在するため難しくはありません。まずは<a href="https://play.google.com/store/apps/details?id=com.csdroid.pkg&hl=ja&gl=US&pli=1" target="_blank">こちらのPackage Name Viewer</a>をインストールしてください、インストールした開くとアプリが一覧で表示されるので削除したいアプリを選択しコピーしたあとにメモ帳などにコピーしておきADBをインストールししたパソコンにコピーしておいてください。</p>
            <h4>3. 無効化を行う方法</h4>
            <p>まずはパソコンにデバイス（スマホなど）をパソコンにUSBで接続しこのコマンドを実行してください。<code>adb devices</code>このコマンドが正常に実行されれば<strong>USBデバッグを許可しますか？</strong>というダイアログが表示されますので<strong>このパソコンからのUSBデバッグを常に許可する</strong>にチェックをいれOKボタンを押してください。</p>
            <p>無効化の場合はこのコマンドを使用して無効化を行います。<code>adb shell pm disable-user --user 0 先程コピーしたパッケージ名</code></p>
            <h4>4. アンインストールを行う方法</h4>
            <p>次はアンインストールしてしまう方法です。<code>adb shell pm uninstall -k --user 0 先程コピーしたパッケージ名</code></p>
          </article>
          <article class="article" id="p2">
            <h3>Package Disablerを使う方法</h3>
            <p>あとで書きます。</p>
          </article>
          <article class="article" id="p3">
            <h3>まとめ</h3>
            <p>なかなか手順が多いいですが、やってみるとなんとかなるのとその知識はあっても損はないと思います。もし今回のほうほうで失敗しできない場合は動画版もあるのでそちらを試してみてください。</p>
            <iframe class="img-rs_boxsaidai" src="https://www.youtube-nocookie.com/embed/Z0a1L1hlXB8?si=gcpuNnQmFSZKCzQJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <p>万が一デバイス（スマホなど）が起動不良に陥った場合はADBがまだ生きている場合はPCに接続し<code>adb reboot recovery</code>を実行し(menu)起動した画面をボリームのマイナスプラスボタンでfactoryReset(ファクトリーリセット)の項目から初期化を実行してください。ADBがﾀﾋしてしまっていた場合は手動で行いますまずはデバイスを60秒ほど長押しし強制的に電源を落すなどをしどうにかシャットダウンしてくださいその後メーカーによりますがボリュームのマイナスを押したまま電源を入れてください。※電源を入れてもボリュームマイナスボタンを押したままにしてください。すると(menu)の部分の画面が現れます。あとは同じです。</p>
            <p>今回の記事はいかがだったでしょうか、正直書くのって大変なんだなと言うのを痛感しました。それでも皆さんの知識の足しになれば嬉しいです。じゃ、バイバイ👋</p>
          </article>
        </section>
