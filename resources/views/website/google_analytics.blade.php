<?php if($tracking_code = settings('google_analytics_tracking_code')) { ?>
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $tracking_code }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $tracking_code }}');
</script>

<?php } ?>

