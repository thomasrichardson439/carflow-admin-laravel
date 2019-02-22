<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo env('GA_TRACKING_CODE', 'YOUR_ID'); ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?php echo env('GA_TRACKING_CODE', 'YOUR_ID'); ?>');
</script>
