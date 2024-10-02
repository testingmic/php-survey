<?php
include_once 'headtags.php';

global $AppName, $baseURL;
?>
<?= dashboard_header($baseURL, 'both', $isLoggedIn) ?>
<div class="video-container">
    <video autoplay=true loop=true controls=true playsinline=true src="https://prod.smassets.net/assets/content/sm/hero-animation-homepage.webm"></video>
</div>
<?php include_once 'foottags.php'; ?>