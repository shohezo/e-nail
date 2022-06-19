<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo wp_get_document_title();?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <!-- OGP -->
    <meta property="og:url" content="https://e-nail-fukuoka.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="e-nail" />
    <meta property="og:description" content="福岡天神薬院にある完全予約制のプライベートネイルサロンです。" />
    <meta property="og:site_name" content="e-nail" />
    <meta property="og:image" content="https://e-nail-fukuoka.com/wp-content/themes/e-nail/img/logo.png" />

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
    <!-- Adobe Fonts -->
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

<body>
    <!-- HEADER -->
    <header class="ly_header">
        <div class="ly_header_inner">
            <div class="bl_headerLogo">
                <a href="#"><img src="<?php bloginfo('template_url');?>/img/logo.png" alt="サイトのロゴ"
                        class="bl_headerLogo_img" /></a>
                <a href="#" class="bl_headerLogo_ttl change-color"><img
                        src="<?php bloginfo('template_url');?>/img/header_logo.png" alt="e-nail" border="0" /></a>
                <a href="#" class="sp-only"><img src="<?php bloginfo('template_url');?>/img/header_logo_sponliy.png"
                        alt="e-nail" border="0" /></a><br />
            </div>
            <nav class="bl_headerNav">
                <ul class="bl_headerNav_list">
                    <li class="bl_headerNav_item"><a href="#about">ABOUT</a></li>
                    <li class="bl_headerNav_item"><a href="#menu">STYLES</a></li>
                    <li class="bl_headerNav_item"><a href="#gallery">GALLERY</a></li>
                    <li class="bl_headerNav_item"><a href="#access">ACCESS</a></li>
                </ul>
            </nav>
            <a href="<?php bloginfo('url');?>/reserved" class="el_btn el_btn__rsv" target="_blank"
                rel="noopener noreferrer">ご予約はこちら</a>
            <!-- drawer-menu -->
            <div id="nav-drawer">
                <input id="nav-input" type="checkbox" class="nav-unshown" />
                <label id="nav-open" for="nav-input">
                    <span></span>
                </label>
                <label id="nav-close" for="nav-input" class="nav-unshown"></label>
                <div id="nav-content">
                    <ul class="burger-list">
                        <li class="burger-item">
                            <a class="burger-link" href="#about">ABOUT</a>
                        </li>
                        <li class="burger-item">
                            <a class="burger-link" href="#menu">STYLES</a>
                        </li>
                        <li class="burger-item">
                            <a class="burger-link" href="#gallery">GALLERY</a>
                        </li>
                        <li class="burger-item">
                            <a class="burger-link" href="#access">ACCESS</a>
                        </li>
                    </ul>
                    <a href="<?php bloginfo('url');?>/reserved" class="el_btn el_btn__rsv" target="_blank"
                        rel="noopener noreferrer">ご予約はこちら</a>
                </div>
            </div>
        </div>
        <?php wp_head(); ?>
    </header>