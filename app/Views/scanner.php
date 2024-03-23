<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<style>
    .mycontainer {
        display: flex;
        justify-content: center;
    }

    #reader {
        width: 550px;
        height: 550px;
    }
</style>

<div class="container py-4 flex justify-content-center items-center">
    <div class="mycontainer py-3">
        <div id="reader"></div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script type="text/javascript">
    function onScanSuccess(decodedText, decodedResult) {

        // /product/65fe600cce6a9
        window.location = `/product/${decodedText}`;

        html5QrcodeScanner.clear();
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        }, false);

    html5QrcodeScanner.render(onScanSuccess);
</script>
<script>
    let buttonRequest = document.getElementById("html5-qrcode-button-camera-permission");
    let fromFile = document.getElementById("html5-qrcode-anchor-scan-type-change");
    let stopScanning = document.getElementById('html5-qrcode-button-camera-stop');
    let reader = document.getElementById("reader");

    setTimeout(() => {
        buttonRequest.classList.add("btn");
        buttonRequest.classList.add("btn-primary");

        fromFile.classList.add("btn");
        fromFile.classList.add("btn-secondary");
        fromFile.classList.add("mt-3");

        reader.style.border = "none";
    }, 500)
</script>
<?= $this->endSection('content') ?>