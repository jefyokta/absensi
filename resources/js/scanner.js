import { Html5Qrcode } from "html5-qrcode";

document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        const audio = document.createElement("audio");
        audio.src = "/beep.mp3";
        function onScanSuccess(decodedText, decodedResult) {
            audio.play();
            setTimeout(() => {
                document.getElementById("qrcode").value = decodedText;
                document.getElementById("form").submit();
            }, 200);
        }

        function onScanError(errorMessage) {
            // console.error(`Scan error: ${errorMessage}`);
        }

        const html5QrCode = new Html5Qrcode("reader");

        html5QrCode
            .start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 200, height: 200 }, 
                },
                onScanSuccess,
                onScanError
            )
            .catch((err) => {
                console.error(`Unable to start QR code scanner: ${err}`);
            });
    }, 500);
});
