/*****************************************
  *----------------------------------
  |  ThisCssVersion: 1.18.1       |
  |  © 2021-2024 By PusyuuWanko/  |
  |  LastUpdate: 2024-03-21       |
  |  License: MITLicense          |
  |  PusyuuPortfolio(^v^)/        |
----------------------------------*
******************************************/

/* Contact
---------------------------------*/

let validate = function() {

  let flag = true;

  removeElementsByClass("error-info");
  removeClass("error-form");

  // お名前の入力をチェック
  if (document.form.name.value == "") {
    errorElement(document.form.name, "お名前が入力されていません。");
    flag = false;
  } else {
  // お名前の形式をチェック
  if (!validateName(document.form.name.value)) {
    errorElement(document.form.name, "アルファベットと”-”以外の文字が入っています。");
    flag = false;
  }
}

// メールアドレスの入力をチェック
if (document.form.email.value !== "") {
  // メールアドレスの形式をチェック
  if (!validateMail(document.form.email.value)) {
    errorElement(document.form.email, "メールアドレスが正しくありません。");
    flag = false;
  }
}

// お問い合わせ項目の選択をチェック
if (document.form.item.value == "") {
  errorElement(document.form.item, "お問い合わせ項目が選択されていません。");
  flag = false;
}

// お問い合わせ内容の入力をチェック
if (document.form.content.value == "") {
  errorElement(document.form.content, "お問い合わせ内容が入力されていません。");
  flag = false;
}
  return flag;
}

let errorElement = function(form, msg) {
  form.className = "error-form";
  let newElement = document.createElement("div");
  newElement.className = "error-info";
  newElement.style.color = "#ff0000";
  newElement.style.margin = "0px 5px 10px 5px";
  newElement.style.padding = "3px";
  newElement.style.border = "1px solid #ff0000";
  let newText = document.createTextNode(msg);
  newElement.appendChild(newText);
  form.parentNode.insertBefore(newElement, form.nextSibling);
}


let removeElementsByClass = function(className){
  let elements = document.getElementsByClassName(className);
  while (elements.length > 0){ 
    elements[0].parentNode.removeChild(elements[0]);
  }
}

let removeClass = function(className){
  let elements = document.getElementsByClassName(className);
  while (elements.length > 0) {
    elements[0].className = "";
  }
}

let validateMail = function (val){
  if (val.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)==null) {
    return false;
  } else {
    return true;
  }
}

let validateNumber = function (val){
  if (val.match(/[^0-9]+/)) {
    return false;
  } else {
    return true;
  }
}

let validateTel = function (val){
  if (val.match(/^[0-9-]{6,13}$/) == null) {
    return false;
  } else {
    return true;
  }
}

let validateName = function (val){
  if (val.match(/^[a-z,A-Z,-]+$/) == null) {
    return false;
  } else {
    return true;
  }
}

/* PusyuuOfMesseage
---------------------------------*/

const pusyuu = "あ、あ、テステス、テストコメントです。まだまだプログラミング初心者です。応戦よろしくお願いします。";
  console.log(pusyuu);

/* OnClickMusic
---------------------------------*/

window.onload = function() {
  const audioFiles = [
    { id: 'audioBtn1', src: '../MusicData/hage.mp3' },
    { id: 'audioBtn2', src: '../MusicData/another_audio.mp3' },
    { id: 'audioBtn3', src: '../MusicData/yet_another_audio.mp3' }
  ];

  let currentAudio = null;

  function playAudio(audioSrc) {
    const audio = new Audio(audioSrc);
    audio.play();
    return audio;
  }

  function getAudioSrcById(id) {
    const audioData = audioFiles.find(item => item.id === id);
    return audioData ? audioData.src : null;
  }

  // クリックイベントを追加
  audioFiles.forEach(audioData => {
    const button = document.getElementById(audioData.id);
    if (button) {
      button.onclick = function() {
        if (currentAudio && !currentAudio.paused) {
          currentAudio.pause();
          currentAudio.currentTime = 0;
        }

        const audioSrc = getAudioSrcById(audioData.id);
        if (audioSrc) {
          currentAudio = playAudio(audioSrc);
        }
      };
    }
  });
};

/* LoadingDisplay
---------------------------------*/

document.addEventListener("DOMContentLoaded", function() {
  let spinner = document.getElementById('loading');
  spinner.style.display = "block";

  function loaded() {
    let spinner = document.getElementById('loading');
    // 条件文で要素が存在しない場合に処理をスキップ
    if (!spinner) {
      console.log(`Element with ID "loading" not found.`);
      return;
    }
    spinner.classList.add('loaded');
  }
  setTimeout(loaded, 1000);
});

/* select kabegami
---------------------------------*/

document.addEventListener('DOMContentLoaded', function() {
  const select = document.getElementById('background-select');
  const uploadInput = document.getElementById('upload-input');
  if (select && uploadInput) {
    const body = document.body;
    const maxFileSize = 1 * 1024 * 1024; // 1MB in bytes
    const selectedImage = localStorage.getItem('PusyuuPortfolio_selectedImage');
    if (selectedImage) {
      body.style.backgroundImage = `url(${selectedImage})`;
      select.value = selectedImage;
    }

    select.addEventListener('change', function() {
      const selectedImage = select.value;
      body.style.backgroundImage = `url(${selectedImage})`;
      localStorage.setItem('PusyuuPortfolio_selectedImage', selectedImage); // Changed the key to 'PusyuuMultiApp_selectedImage'
    });

    uploadInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      if (file.size > maxFileSize) {
        alert('The file size exceeds the maximum limit of 1MB.');
        return;
      }

      reader.onload = function() {
        const uploadedImage = reader.result;
        const randomThreeDigitNumber = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        const imageName = 'Your wallpaper' + randomThreeDigitNumber;
        localStorage.setItem(imageName, uploadedImage);
        addImageOption(imageName, uploadedImage);
      };
      reader.readAsDataURL(file);
    });

    for (let i = 0; i < localStorage.length; i++) {
      const key = localStorage.key(i);
      if (key.startsWith('Your wallpaper')) {
        const uploadedImage = localStorage.getItem(key);
        addImageOption(key, uploadedImage);
      }
    }

    function addImageOption(imageName, uploadedImage) {
      const option = document.createElement('option');
      option.value = uploadedImage;
      option.text = imageName;
      select.add(option);

      if (uploadedImage === selectedImage) {
        option.selected = true;
      }
    }

    function applyBackgroundStyles() {
      body.style.backgroundSize = 'cover';
      body.style.backgroundRepeat = 'no-repeat';
      body.style.backgroundPosition = 'center';
      body.style.backgroundAttachment = 'fixed';
    }
  
    applyBackgroundStyles();

    function addPreloadedImages() {
      const preloadedImages = [
        'https://21emon.wjg.jp/PusyuuPage/ImageData/sys_wallpaper/1.JPG',
      ];
      addImageOption("Select Wallpaper", "");
      preloadedImages.forEach(function(image, index) {
        const wallpaperNumber = (index + 1).toString();
        const imageName = 'wallpaper ' + wallpaperNumber;
        addImageOption(imageName, image);
      });
    }

    addPreloadedImages();
  } else {
    console.log('Element with ID "background-select" and "upload-input" not found.');
  }
});

/* Nav List
---------------------------------*/

let navlist = [
  {
    image: "../../IconData/img-1.png",
    title: "HOME",
    link: "../p1/content.php",
    lktitle: "HOME",
  },
  {
    image: "../../IconData/img-30.png",
    title: "PLOG",
    link: "../p2/content.php",
    lktitle: "PUSYUU LOG",
  },
  {
    image: "../../IconData/img-31.png",
    title: "PROOM",
    link: "../p3/content.php",
    lktitle: "PUSYUU ROOM",
  },
  {
    image: "../../IconData/img-29.png",
    title: "PNEWS",
    link: "../p4/content.php",
    lktitle: "PUSYUU NEWS",
  },
  {
    image: "../../IconData/img-32.png",
    title: "CONTACT",
    link: "../p5/content.php",
    lktitle: "CONTACT",
  },
];

function createNavItem(nav) {
  let navItem = document.createElement("div");
  navItem.className = "draggable-item";

  let aLink = document.createElement("a");
  aLink.className = "app_link";
  aLink.href = nav.link;
  aLink.title = nav.lktitle;

  let appWrapper = document.createElement("div");
  appWrapper.className = "app_wrapper";

  let appImage = document.createElement("div");
  appImage.className = "app_box-1";

  let img = document.createElement("img");
  img.src = nav.image;
  img.alt = "image of app";
  img.className = "img-rs_boxsaidai";
  img.oncontextmenu = function () {
    return false;
  };
  img.onselectstart = function () {
    return false;
  };
  img.onmousedown = function () {
    return false;
  };
  img.border = "0";

  let appName = document.createElement("p");
  appName.className = "app_name";
  appName.textContent = nav.title;

  appImage.appendChild(img);
  appWrapper.appendChild(appImage);
  appWrapper.appendChild(appName);
  aLink.appendChild(appWrapper);
  navItem.appendChild(aLink);

  return navItem;
}
document.addEventListener("DOMContentLoaded", function () {
  let navListWrapper = document.getElementById("nav_list_wrapper");
  if (!navListWrapper) {
    console.log("Element with ID 'nav_list_wrapper' not found.");
  } else {
    for (let i = 0; i < navlist.length; i++) {
      let navItem = createNavItem(navlist[i]);
      navListWrapper.appendChild(navItem);
    }
  }
});

/* Drag and drop
---------------------------------*/

document.addEventListener('DOMContentLoaded', function () {
  const draggableItems = document.querySelectorAll('.draggable-item');

  let draggedItem = null;
  const appOrderKey = 'PusyuuPage';


  // ドラッグ開始時の処理
  function dragStart(e) {
    draggedItem = this;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
  }

  // ドラッグ中の処理
  function dragOver(e) {
    if (e.preventDefault) {
      e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
  }

  // ドロップ時の処理
  function drop(e) {
    if (e.stopPropagation) {
      e.stopPropagation();
    }

    if (draggedItem !== this) {
      draggedItem.innerHTML = this.innerHTML;
      this.innerHTML = e.dataTransfer.getData('text/html');
      updateLocalStorageOrder();
    }

    return false;
  }

  // ドラッグ要素にイベントリスナーを追加
  draggableItems.forEach(item => {
    item.addEventListener('dragstart', dragStart);
    item.addEventListener('dragover', dragOver);
    item.addEventListener('drop', drop);
  });

  // ローカルストレージの順番を更新
  function updateLocalStorageOrder() {
    const appLinkElements = document.querySelectorAll('.draggable-item');
    const order = Array.from(appLinkElements).map(item => item.outerHTML);
    localStorage.setItem(appOrderKey, JSON.stringify(order));
  }

  // ローカルストレージから順番を復元
  function restoreOrderFromLocalStorage() {
    const appOrder = JSON.parse(localStorage.getItem(appOrderKey));
    if (appOrder) {
      const appContainer = document.getElementById("nav_list_wrapper");
      if (!appContainer) {
        console.log("Element with ID 'nav_list_wrapper' not found.");
      } else {
        const appLinkElements = Array.from(appContainer.querySelectorAll('.draggable-item'));

        const updatedOrder = [];

        for (const item of appOrder) {
          const matchingElement = appLinkElements.find(element => element.outerHTML === item);
          if (matchingElement) {
            updatedOrder.push(matchingElement.outerHTML);
          }
        }

        for (const element of appLinkElements) {
          if (!updatedOrder.includes(element.outerHTML)) {
            updatedOrder.push(element.outerHTML);
          }
        }

        while (updatedOrder.length > appLinkElements.length) {
          updatedOrder.pop();
        }
        while (updatedOrder.length > appLinkElements.length) {
          updatedOrder.push(appLinkElements[updatedOrder.length].outerHTML);
        }

        appContainer.innerHTML = updatedOrder.join('');
        addDragListeners();
      }
    }
  }

  // ドラッグ要素にイベントリスナーを再度追加
  function addDragListeners() {
    const draggableItems = document.querySelectorAll('.draggable-item');
    draggableItems.forEach(item => {
      item.addEventListener('dragstart', dragStart);
      item.addEventListener('dragover', dragOver);
      item.addEventListener('drop', drop);
    });
  }

  // ページ読み込み時にローカルストレージから順番を復元
  restoreOrderFromLocalStorage(); // ローカルストレージからの復元を行う

});

/* OsiraseSyoukai
---------------------------------*/

window.onload = function() {
  const info = "お知らせ紹介：プシューポートフォリオへようこそ！！ PageSettingsの中の壁紙機能を使うことでもっとおしゃれにかっこよくできます！！";
  let visitedBefore = sessionStorage.getItem("visitedBefore");
  if (visitedBefore === null) {
    alert (info);
    sessionStorage.setItem("visitedBefore", "true")
  } else {
    
  }
}

/* OnClickImageModal
---------------------------------*/

function imageModal() {
  const imageTags = document.querySelectorAll(".image_zoom");
  imageTags.forEach(item => {
    item.addEventListener('click', () => {
      const imageUrl = item.src;

      const modalDiv = document.createElement('div');
      modalDiv.id = 'imgButton';
      modalDiv.classList.add('modal');

      modalDiv.innerHTML = `
        <div>
          <a aria-label="拡大を閉じるボタン" href="#mc" id="close"></a>
          <span>拡大画像</span>
          <div>
            <img src="${imageUrl}" alt="画像" class="img-rs_saidai" oncontextmenu="return false;" onselectstart="return false;" onmousedown="return false;">
          </div>
        </div>
      `;
      document.body.appendChild(modalDiv);
      location.href = '#imgButton';
    });
  });

  // クリックイベントが発生したらclose IDを検索するロジック
  document.addEventListener('click', (event) => {
    const close = document.getElementById('close');
    const modalDiv = document.getElementById('imgButton');

    // クリックされた要素がcloseボタンであるかどうかを確認
    if (event.target === close) {
      document.body.removeChild(modalDiv);
    }
  });
}
setTimeout(imageModal, 1000); 

/* observeAnimetion
---------------------------------*/

window.addEventListener("DOMContentLoaded", function() {
  var imgEle = [...document.querySelectorAll("main img")];
  if (imgEle.length < 1) { //画像があるところではオブザーバーがバグるので画像が無いときのみ発動させる。
    var observedEle = [...document.querySelectorAll("section")];
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0px)";
        } else {
          entry.target.style.opacity = "0";
          entry.target.style.transform = "translateY(10px)";
        }
      });
    }, { threshold: 0.5 });
    observedEle.forEach(function(item, index) {
      item.style.opacity = "0";
      item.style.transform = "translateY(10px)";
      item.style.transition = "all 0.5s";
      observer.observe(item);
    });
  }
});
