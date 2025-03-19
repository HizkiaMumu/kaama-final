<script>
    setTimeout(() => {
        const canvas = document.getElementById("liveCanvas");
    const ctx = canvas.getContext("2d");

    const frameImg = new Image();
    frameImg.src = "{{ $frame->path }}"; // Ganti dengan URL gambar frame yang sesuai

    const videoSources = [
        "{{ $capturedVideos[0] }}",
        "{{ $capturedVideos[0] }}",
        "{{ $capturedVideos[1] }}",
        "{{ $capturedVideos[1] }}",
        "{{ $capturedVideos[2] }}",
        "{{ $capturedVideos[2] }}",
        "{{ $capturedVideos[0] }}",
        "{{ $capturedVideos[0] }}",
    ];

    const positions = [];

    @foreach($frame_positions as $position)
        position = {
            x: {{ $position->x }},
            y: {{ $position->y }},
            width: {{ $position->width }},
        }

        positions.push(position);
    @endforeach

    const videos = videoSources.map(src => {
        const video = document.createElement("video");
        video.src = src;
        video.autoplay = true;
        video.loop = true;
        video.muted = true;
        video.playsInline = true;
        video.play().catch(error => console.error("Video play failed", error));
        return video;
    });

    function drawFrame() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        canvas.width = 1205;
        canvas.height = 1795;
        
        videos.forEach((video, index) => {
            const { x, y, width } = positions[index];
            const aspectRatio = video.videoHeight / video.videoWidth;
            const height = width * aspectRatio;
            
            if (!isNaN(aspectRatio) && aspectRatio > 0) {
                ctx.drawImage(video, x, y, width, height);
            }
        });

        ctx.drawImage(frameImg, 0, 0, canvas.width, canvas.height);
        requestAnimationFrame(drawFrame);
    }

    // **Tambahkan fungsi untuk merekam**
    let recordedChunks = [];
    const stream = canvas.captureStream(30); // 30 FPS
    const mediaRecorder = new MediaRecorder(stream, {
        mimeType: "video/webm; codecs=vp9"
    });

    mediaRecorder.ondataavailable = (event) => {
        if (event.data.size > 0) {
            recordedChunks.push(event.data);
        }
    };

    mediaRecorder.onstop = () => {
        const blob = new Blob(recordedChunks, { type: "video/webm" });
        const formData = new FormData();
        const transactionId = {{ $transactionId }};
        console.log(transactionId);

        formData.append("video", blob, "recorded-video.webm");
        formData.append("transaction_id", transactionId);
        
        console.log(formData, blob);

        fetch("/upload/live", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Pastikan ada token CSRF
            }
        })
        .then(response => response.json())
        .then(data => console.log("Upload sukses:", data))
        .catch(error => console.error("Upload gagal:", error));
    };

    // **Mulai rekaman setelah semua video dimuat**
    function startRecording(duration = 10000) { // 5 detik default
        recordedChunks = [];
        mediaRecorder.start();
        setTimeout(() => mediaRecorder.stop(), duration);
    }

    videos.forEach(video => {
        video.addEventListener("loadeddata", () => {
            video.play();
            if (videos.every(v => v.readyState >= 2)) {
                drawFrame();
                startRecording(); // Mulai rekaman otomatis
            }
        });
    });

    frameImg.onload = function () {
        if (videos.every(v => v.readyState >= 2)) {
            drawFrame();
        }
    };
    }, 3000)

</script>