<html>

<head>
    <title>WebSDK CDN Example</title>
</head>

<body>
    <script src="https://static.sumsub.com/idensic/static/sns-websdk-builder.js"></script>
    <div id="sumsub-websdk-container"></div>
</body>

</html>

<script>
    function launchWebSdk(accessToken, applicantEmail, applicantPhone) {
        let snsWebSdkInstance = snsWebSdk
            .init(accessToken, () => this.getNewAccessToken())
            .withConf({
                lang: "en",
                email: applicantEmail,
                phone: applicantPhone,
            })
            .withOptions({
                addViewportTag: false,
                adaptIframeHeight: true
            })
            .on("idCheck.onStepCompleted", (payload) => {
                console.log("onStepCompleted", payload);
            })
            .on("idCheck.onError", (error) => {
                console.log("onError", error);
            })
            .onMessage((type, payload) => {
                console.log("onMessage", type, payload);
            })
            .build();
        snsWebSdkInstance.launch("#sumsub-websdk-container");
    }

    // Requests a new access token from the backend side.
    function getNewAccessToken() {
        return Promise.resolve('sbx:t5yAgwbkuYTFeqhFLNmfK7Bp.pStzTLXNZPlboj6KNCoVOiMTfiMV2usC');
    }

    launchWebSdk('sbx:t5yAgwbkuYTFeqhFLNmfK7Bp.pStzTLXNZPlboj6KNCoVOiMTfiMV2usC');
</script>