<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Page Spinner</title>
    <style>
        /* Full page overlay */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Optional: dark background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Make sure spinner is on top */
        }

        /* Spinner style */
        .spinner {
            border: 8px solid #f3f3f3; /* Light color */
            border-top: 8px solid #3498db; /* Blue color for the spinner */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        /* Animation for the spinner */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="spinner-overlay">
        <div class="spinner"></div>
    </div>
</body>
</html>
