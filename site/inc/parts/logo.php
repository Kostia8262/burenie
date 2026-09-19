<?php
/** Знак: капля воды, внутри — буровая штанга с долотом. */
$logo_id = 'lg' . substr(md5((string) mt_rand()), 0, 5);
?>
<svg class="logo__mark" viewBox="0 0 40 40" aria-hidden="true">
  <defs>
    <linearGradient id="<?= $logo_id ?>" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="#2e9bc4"/>
      <stop offset="1" stop-color="#12527e"/>
    </linearGradient>
  </defs>
  <path fill="url(#<?= $logo_id ?>)"
        d="M20 2.5c6.4 7.7 11.5 14.2 11.5 20.3C31.5 30.3 26.3 36 20 36S8.5 30.3 8.5 22.8C8.5 16.7 13.6 10.2 20 2.5z"/>
  <rect x="18.4" y="11" width="3.2" height="14.5" rx="0.4" fill="#fff"/>
  <path d="M15.9 25.5h8.2L20 32z" fill="#ef7b1c"/>
</svg>
