    <div class="border-top text-center p-2 pt-4">
            <strong>Powered By:</strong>
            <a href="https://emmallextech.com" target="_blank">
                Emmallex Technologies
            </a>
        </div>
    </div>
    <section hidden class="output"><div class="heading">Getting the visitor identifier...</div></section>
    <script>var baseURL = "<?= $baseURL ?>";</script>
    <script src="<?= $baseURL ?>assets/js/jquery.js"></script>
    <script src="<?= $baseURL ?>assets/js/sweetalert.js"></script>
    <script src="<?= $baseURL ?>assets/js/toastr.js"></script>
    <!-- <script src="<?= $baseURL ?>assets/js/fingerprint.js"></script> -->
    <script src="<?= $baseURL ?>assets/js/bootstrap.js"></script>
    <script src="<?= $baseURL ?>assets/js/app.js?v=1.0.41"></script>
    <?php if(empty($surveyHasEnded)) { ?>
        <script>
            const userIpAddress = "<?= $ip_address ?>";
            var userFingerprint = null;
            <?php if( empty($sessObj->userFingerprint) ) { ?>
                const fpPromise = import('https://fpjscdn.net/v3/hXGuNdSTmPCM5hWHXWUj').then(FingerprintJS => FingerprintJS.load())
                fpPromise.then(fp => fp.get()).then(result => {
                    const visitorId = result.visitorId
                    userFingerprint = visitorId;
                    $.post(`${baseURL}surveys/savefingerprint/${visitorId}_${userIpAddress}`);
                }).catch((error) => {
                    userFingerprint = `${generateDeviceFingerprint()}_${userIpAddress}`;
                    $.post(`${baseURL}surveys/savefingerprint/${userFingerprint}`);
                });
            <?php } else { ?>
                userFingerprint = "<?= $sessObj->userFingerprint ?>";
            <?php } ?>
        </script>
    <?php } ?>
    <script src="<?= $baseURL ?>assets/js/trix.js"></script>
    <script src="<?= $baseURL ?>assets/js/dashboard.js?v=1.1.1"></script>
</body>
</html>