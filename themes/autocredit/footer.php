</main>
<footer class="footer">
    <div class="container">
        <div class="mt-5 mb-3"><? the_field('footer_1', 'option') ?></div>
        <div class="semi-weight"><? the_field('footer_2', 'option') ?></div>
        <div class="copyright text-center"><? the_field('copyright', 'option') ?></div>
        <div class="text-center"><? the_field('footer_3', 'option') ?></div>
    </div>
</footer>
<? get_template_part('views/callback') ?>
<? get_template_part('views/success') ?>
<? get_template_part('views/GeoApi') ?>
<? wp_footer() ?>
<script type="text/javascript">
    WebFontConfig = {
        google: { families: [ 'Montserrat:300,300i,400,400i,500,600,700,900' ] }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
    // ]]>
</script>
</body>
</html>