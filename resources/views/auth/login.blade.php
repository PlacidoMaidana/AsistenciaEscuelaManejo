<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biometric Verification</title>
</head>
<body>
    <h1>Biometric Verification</h1>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="capture">Capture Photo</button>
    <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('capture');

        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (err) {
                console.error('Error accessing camera:', err);
            }
        }

        initCamera();

        captureButton.addEventListener('click', async () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convertir la imagen del canvas a Base64
            const dataURL = canvas.toDataURL('image/jpeg');

            // Enviar la foto a un controlador para la verificación biométrica
            sendPhoto(dataURL);
        });

        async function sendPhoto(photoData) {
            try {
                // Enviar la foto a tu controlador en el servidor
                const response = await fetch('/verificar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ photo: photoData })
                });

                const result = await response.json();
                console.log('Resultado de la verificación biométrica:', result);
            } catch (err) {
                console.error('Error al enviar la foto:', err);
            }
        }
    </script>
</body>
</html>
