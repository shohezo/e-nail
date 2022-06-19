/* smooth scroll */
$(function () {
  var headerHight = 74;
  $('a[href^="#"]').click(function () {
    var speed = 1200;
    var href = $(this).attr("href");
    var target = $(href == "#" || href == "" ? "html" : href);
    var position = target.offset().top - headerHight;
    $("html, body").animate({ scrollTop: position }, speed, "easeOutCirc");
    return false;
  });
});

/* drawer-menu */
$(".burger-item a").click(function () {
  //burger-item
  $("#nav-input").prop("checked", false);
});

$(function () {
  var webStorage = function () {
    if (sessionStorage.getItem("access")) {
      /*
        2回目以降アクセス時の処理
      */
      $(".loading").addClass("is-active");
    } else {
      /*
        初回アクセス時の処理
      */
      sessionStorage.setItem("access", "true"); // sessionStorageにデータを保存
      $(".loading-animation").addClass("is-active"); // loadingアニメーションを表示
      setTimeout(function () {
        // ローディングを数秒後に非表示にする
        $(".loading").addClass("is-active");
        $(".loading-animation").removeClass("is-active");
      }, 6000); // ローディングを表示する時間
    }
  };
  webStorage();
});

/* instagram jQery実装 */
$.ajax({
  type: "GET",
  url:
    "https://graph.facebook.com/v8.0/17841445649801644?fields=name%2Cmedia.limit(9)%7Bcaption%2Clike_count%2Cmedia_url%2Cpermalink%2Cthumbnail_url%7D&access_token=EAA3t5EUWZA3IBAFvQkrSaAGdDHZCZCv1CFB2MosMhZCPdmZAP6Ueg3WRobmNFwZBYEQO0k6k1BMaXZAO8aHPV28KfEq8ijmnmsoE0gVKzdSUYaETMZCTOJwRfzkD03Fime68LtKX0nv3xrXpyD7I64fO0v0DFZBACemMoJNDWIX94312JQ9ZCnXLpglXDMrlo9utIZD",
  dataType: "json",
  success: function (json) {
    var ig = json.media.data;
    var html = "";
    var caption;
    for (var i = 0; i < ig.length; i++) {
      var link = ig[i].permalink;
      var image;
      caption = ig[i].caption;
      if (!ig[i].thumbnail_url) {
        // 動画の場合はこちら
        image = ig[i].media_url;
      } else {
        // 写真の場合はこちら
        image = ig[i].thumbnail_url;
      }
      html +=
        '<div><a href="' +
        link +
        '" target="_blank"><img src="' +
        image +
        '"></a></div>';
    }
    $(".bl_instagram").append(html);
  },
});

/* ローディングアニメーション */
// var time = new Date().getTime();
// $(function () {
//   var h = $(window).height();

//   $("#global__wrapper").css("display", "none");
//   $("#loader-bg ,#loader").height(h).css("display", "block");
// });

// //全ての読み込みが完了したら実行
// $(window).on("load", function () {
//   var now = new Date().getTime(); //読み込みが終わった時に経過時間が3秒あるか確認して、あれば表示、なければ5秒との差分待ってから表示します
//   if (now - time <= 3000) {
//     setTimeout("stopload()", 5000 - (now - time));
//     return;
//   } else {
//     stopload();
//   }
// });

//10秒たったら強制的にロード画面を非表示
// $(function () {
//   setTimeout("stopload()", 10000);
// });

// function stopload() {
//   $("#global__wrapper").css("display", "block");
//   $("#loader-bg").delay(900).fadeOut(800);
//   $("#loader").delay(600).fadeOut(300);
// }

//.ly_fvまでスクロールするとheaderの色が変化
("use strict");

jQuery(window).on("scroll", function () {
  if (jQuery(".ly_fv").height() < jQuery(this).scrollTop()) {
    jQuery(".ly_header").addClass("change-color");
  } else {
    jQuery(".ly_header").removeClass("change-color");
  }
});
