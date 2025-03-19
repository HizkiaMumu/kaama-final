<script>
        // Ambil Base URL otomatis dari domain sistem
        const BASE_URL = window.location.origin; // Contoh: "https://yourdomain.com"

        // ID transaksi bisa didapatkan dari server atau parameter URL
        const transactionId = "{{ $transactionId }}"; // Ganti dengan ID transaksi yang sesuai

        // Buat URL lengkap
        const qrLink = `${BASE_URL}/cloud/${transactionId}`;

        console.log(qrLink);
        
        // Generate QR Code
        new QRCode(document.getElementById("qrcode"), {
            text: qrLink,
            width: 178,
            height: 178
        });

        console.log("QR Code dibuat untuk:", qrLink);

        // Open the print modal when clicking the print icon
        document.getElementById('printIcon').addEventListener('click', function () {
            document.getElementById('printModal').style.display = 'flex';
        });

        // Submit the print request
        function submitPrint() {
            // Get the number of copies (for now, we are just simulating the action)
            const numCopies = document.getElementById('numCopies').value;

            // Close the modal after submission
            document.getElementById('printModal').style.display = 'none';

            // Show the error message
            alert("Error: printer not detected");
        }

        document.addEventListener("DOMContentLoaded", function () {
            let images = [
                "{{ $capturedImages[0] }}",
                "{{ $capturedImages[1] }}",
                "{{ $capturedImages[2] }}"
            ];
            
            let index = 0;
            let gifElement = document.getElementById("gif-image");

            setInterval(() => {
                gifElement.style.backgroundImage = `url('${images[index]}')`;
                index = (index + 1) % images.length; // Loop kembali ke awal setelah mencapai gambar terakhir
            }, 500);
        });

        document.addEventListener("DOMContentLoaded", function () {
            let images = [
                "{{ $capturedImages[0] }}",
                "{{ $capturedImages[1] }}",
                "{{ $capturedImages[2] }}"
            ];
            
            let index = 0;
            let gifElement = document.getElementById("gif-image");
            let gifElement2 = document.getElementById("gif-images");

            setInterval(() => {
                gifElement.style.backgroundImage = `url('${images[index]}')`;
                gifElement2.src = images[index];
                index = (index + 1) % images.length; // Loop kembali ke awal setelah mencapai gambar terakhir
            }, 500);

            // Handle click events to toggle visibility
            const gifCard = document.querySelector(".gif-card");
            const photosCard = document.querySelector(".photos-card");
            const liveCard = document.querySelector(".live-card");
            const frameArea = document.querySelector(".frame-area");
            const frameContainer = document.querySelector(".frame-container");
            const gifArea = document.getElementById("gif-area");
            const liveArea = document.getElementById("live-area");

            gifCard.addEventListener("click", function () {
                frameArea.style.display = "none";
                liveArea.style.display = "none";
                // frameContainer.style.display = "none";
                gifArea.style.display = "block";
            });

            photosCard.addEventListener("click", function () {
                gifArea.style.display = "none";
                liveArea.style.display = "none";
                frameArea.style.display = "block";
                // frameContainer.style.display = "flex";
            });

            liveCard.addEventListener("click", function () {
                gifArea.style.display = "none";
                frameArea.style.display = "none";
                liveArea.style.display = "block";
                // frameContainer.style.display = "flex";
            });
        });
    
</script>