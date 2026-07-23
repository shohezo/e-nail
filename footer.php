<!-- FOOTER -->
<footer class="ly_footer">
    <a href="<?php bloginfo('template_url');?>" class="bl_footerLogo"><img
            src="<?php bloginfo('template_url');?>/img/logo.svg" alt="e-nail" class="bl_footerLogo_img" border="0" /></a>
    <br />
    <p>©e-nail, All Rights Reserved.</p>
    <a href="https://ss-design1104.com/" target="_blank" rel="noopener noreferrer" class="bl_production">
        <p>produced by</p>
        <img src="<?php bloginfo('template_url');?>/img/ss-design_logo.png" alt="SS-DESIGNのロゴ">
    </a>
</footer>

<!-- js読み込み -->
<script src="<?php bloginfo('template_url');?>/js/script.js?v=<?php echo filemtime(get_template_directory() . '/js/script.js'); ?>"></script>
<script src="<?php bloginfo('template_url');?>/js/index.js?v=<?php echo filemtime(get_template_directory() . '/js/index.js'); ?>"></script>
<!-- aosライブラリの実装 -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
<?php wp_footer(); ?>

<div class="loading">
    <div class="loading-animation">
        <img src="<?php bloginfo('template_url');?>/img/opening.gif" alt="オープニングアニメーションGIF">
    </div>
</div>
</body>

</html>