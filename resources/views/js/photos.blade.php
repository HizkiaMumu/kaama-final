<script>
    setTimeout(() => {
        const photoCanvas = document.getElementById("photoCanvas");
    const photoCtx = photoCanvas.getContext("2d");

    const frameImgPhoto = new Image();
    frameImgPhoto.src = "{{ $frame->path }}"; // Ganti dengan URL gambar frame yang sesuai

    const bgImages = [
        "{{ $capturedImages[0] }}",
        "{{ $capturedImages[0] }}",
        "{{ $capturedImages[1] }}",
        "{{ $capturedImages[1] }}",
        "{{ $capturedImages[2] }}",
        "{{ $capturedImages[2] }}",
        "{{ $capturedImages[0] }}",
        "{{ $capturedImages[0] }}",
    ];
    
    const positionsPhoto = [];
    let position;

    @foreach($frame_positions as $position)
        position = {
            x: {{ $position->x }},
            y: {{ $position->y }},
            width: {{ $position->width }},
        }

        positionsPhoto.push(position);
    @endforeach

    const loadedBgImages = [];
    let imagesLoaded = 0;

    bgImages.forEach((src, index) => {
        const img = new Image();
        img.src = src;
        img.onload = function () {
            loadedBgImages[index] = img;
            imagesLoaded++;
            if (imagesLoaded === bgImages.length && frameImgPhoto.complete) {
                drawImages();
            }
        };
    });

    frameImgPhoto.onload = function () {
        if (imagesLoaded === bgImages.length) {
            drawImages();
        }
    };

    function drawImages() {
        photoCanvas.width = 1205;
        photoCanvas.height = 1795;
        photoCtx.clearRect(0, 0, photoCanvas.width, photoCanvas.height);

        // photoCtx.drawImage(frameImgPhoto, 0, 0, photoCanvas.width, photoCanvas.height);
        
        loadedBgImages.forEach((bgImg, index) => {
            const { x, y, width } = positionsPhoto[index];
            const aspectRatio = bgImg.height / bgImg.width;
            const height = width * aspectRatio;

            photoCtx.drawImage(bgImg, x, y, width, height);
        });

        photoCtx.drawImage(frameImgPhoto, 0, 0, photoCanvas.width, photoCanvas.height);
    }

    setTimeout(() => {
        photoCanvas.toBlob((blob) => {
            const formData = new FormData();
            const transactionId = "{{ $transactionId }}"; // Ambil ID transaksi dari Blade

            formData.append("photo", blob, "captured-photo.png");
            formData.append("transaction_id", transactionId);

            fetch("/upload/photo", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Token CSRF
                }
            })
            .then((response) => {
                return response.json();  // Make sure to return the JSON to use it in the next line
            })
            .then((data) => {
                // Set the src attribute of the image element
                const photoImg = document.getElementById("photoImg");
                photoImg.src = data.path;

                // Wait for the image to load
                photoImg.onload = () => {
                    // Hide spinner and show image once loaded
                    photoImg.style.display = "block";
                };
            })
            .catch(error => console.error("Upload gagal:", error));
        }, "image/png"); // Konversi canvas ke Blob dengan format PNG

        printCanvas();

        function printCanvas() {
            const imgData = photoCanvas.toDataURL("image/png");

            // Create a hidden iframe to load the image for printing
            const printFrame = document.createElement("iframe");
            printFrame.style.position = "absolute";
            printFrame.style.width = "0";
            printFrame.style.height = "0";
            printFrame.style.border = "none";

            document.body.appendChild(printFrame);

            const frameDoc = printFrame.contentWindow.document;
            frameDoc.open();
            frameDoc.write(`
                <html>
                    <head>
                        <title>Print Photo</title>
                        <style>
                            @page {
                                margin: 0;
                                size: auto;
                            }
                            body {
                                margin: 0;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                height: 100vh;
                            }
                            img {
                                width: 100%;
                                height: 100%;
                                object-fit: contain;
                            }
                        </style>
                    </head>
                    <body>
                        <img src="${imgData}" onload="setTimeout(() => { window.print(); window.onafterprint(); }, 500);">
                    </body>
                </html>
            `);
            frameDoc.close();

            // Clean up iframe after print is done
            printFrame.contentWindow.onafterprint = function () {
                document.body.removeChild(printFrame);
            };
        }
    }, 1000);
    }, 3000)
</script>
