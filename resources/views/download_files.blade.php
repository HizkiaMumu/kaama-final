<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Files</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            font-size: 18px;
            opacity: 0.8;
        }
        .file-list {
            margin-top: 20px;
            text-align: left;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .file-name {
            font-size: 16px;
            color: #333;
            flex: 1;
        }
        .download-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .download-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="/assets/img/logo.png" height="200px" width="auto" alt="Logo">
        <h2>Terima kasih telah berkunjung</h2>
        <p>Download akan dimulai otomatis, mohon ditunggu...</p>

        <div class="file-list" id="fileList"></div>
    </div>

    <script>
        var files = @json($downloadLinks);

        function getFileType(fileName) {
            var extension = fileName.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'].includes(extension)) {
                return "Gambar";
            } else if (['mp4', 'mkv', 'avi', 'mov', 'flv', 'wmv'].includes(extension)) {
                return "Video";
            } else if (['mp3', 'wav', 'aac', 'ogg', 'flac'].includes(extension)) {
                return "Audio";
            } else if (['pdf'].includes(extension)) {
                return "Dokumen PDF";
            } else if (['doc', 'docx'].includes(extension)) {
                return "Dokumen Word";
            } else if (['xls', 'xlsx'].includes(extension)) {
                return "Dokumen Excel";
            } else if (['ppt', 'pptx'].includes(extension)) {
                return "Presentasi";
            } else {
                return "File";
            }
        }

        function autoDownload() {
            // files.forEach(file => {
            //     var a = document.createElement("a");
            //     a.href = file;
            //     a.download = "";
            //     document.body.appendChild(a);
            //     a.click();
            //     document.body.removeChild(a);
            // });
        }

        function showFileList() {
            var fileListContainer = document.getElementById("fileList");
            files.forEach(file => {
                var fileItem = document.createElement("div");
                fileItem.classList.add("file-item");

                var fileName = document.createElement("span");
                fileName.classList.add("file-name");
                fileName.textContent = getFileType(file); // Menampilkan jenis file

                var downloadBtn = document.createElement("a");
                downloadBtn.classList.add("download-btn");
                downloadBtn.href = file;
                downloadBtn.download = "";
                downloadBtn.textContent = "Download";

                fileItem.appendChild(fileName);
                fileItem.appendChild(downloadBtn);
                fileListContainer.appendChild(fileItem);
            });
        }

        autoDownload();
        showFileList();
    </script>
</body>
</html>
