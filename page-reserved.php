<?php
/* 
Template Name: reserved
*/
?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php the_title(); ?></title>
    <meta name="description" content="ゆびのさきから、そのさきへ。福岡天神薬院にある完全予約制のプライベートサロンです。" />
    <link rel="stylesheet" href="<?php bloginfo('template_url');?>/reset.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?php bloginfo('template_url');?>/img/favicon (1).ico" />
    <link rel="stylesheet" href="<?php bloginfo('template_url');?>/style.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_url');?>/responsive.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous" />

    <!-- aosライブラリの読み込み -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <script type="text/javascript" src="<?php bloginfo('template_url');?>/js/jquery-3.6.0.min.js"></script>
    <script type=" text/javascript" src="<?php bloginfo('template_url');?>/js/jquery-migrate-1.4.1.min.js"></script>
    <!-- jQuery.easingの読み込み -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url');?>/js/instafeed.min.js"></script>
    <!-- AdobeFonts -->
    <script>
    (function(d) {
        var config = {
                kitId: 'tbm4fwh',
                scriptTimeout: 3000,
                async: true
            },
            h = d.documentElement,
            t = setTimeout(function() {
                h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
            }, config.scriptTimeout),
            tk = d.createElement("script"),
            f = false,
            s = d.getElementsByTagName("script")[0],
            a;
        h.className += " wf-loading";
        tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
        tk.async = true;
        tk.onload = tk.onreadystatechange = function() {
            a = this.readyState;
            if (f || a && a != "complete" && a != "loaded") return;
            f = true;
            clearTimeout(t);
            try {
                Typekit.load(config)
            } catch (e) {}
        };
        s.parentNode.insertBefore(tk, s)
    })(document);
    </script>
</head>

<!-- ループ始まり -->
<?php if(have_posts()):while(have_posts()):the_post(); ?>
<div class="ly_reserved">
    <div class="ly_inner">
        <h1 class="bl_section_ttl"><?php the_title(); ?></h1>
        <p class="bl_section_subttl">ご予約</p>
        <?php the_content(); ?>
    </div>
</div>
<?php endwhile;endif; ?>
<!-- ループ終わり -->
<!-- FOOTER -->

<footer class=" ly_footer">
    <a href="<?php bloginfo('url');?>" class="bl_footerLogo_ttl"><img
            src="<?php bloginfo('template_url');?>/img/footer_logo.png" alt="american-gothic-font" border="0" /></a>
    <a href="<?php bloginfo('url');?>" class="sp-only"><img
            src="<?php bloginfo('template_url');?>/img/footer_logo_sponly.png" alt="e-nail" border="0" /></a>
    <br />
    <p>プライバシーポリシー</p>
    <p>個人商取引法に基づく表記</p>
    <p>©e-nail, All Rights Reserved.</p>
</footer>

<!-- js読み込み -->
<script src="<?php bloginfo('template_url');?>/js/script.js"></script>
<script src="<?php bloginfo('template_url');?>/js/index.js"></script>
<!-- aosライブラリの実装 -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
<?php wp_footer(); ?>
</body>

</html>