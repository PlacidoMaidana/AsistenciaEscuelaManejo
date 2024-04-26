@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Agregar el componente Vue Webcam -->
                        <div class="row mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                                <h2>Biometric Verification</h2>
                                <video id="video" width="100%" height="auto" autoplay></video>
                                <!-- Botón con Bootstrap y texto "Marcar Asistencia" y un icono -->
                                <button id="capture" class="btn btn-primary mt-3">
                                    <i class="bi bi-person-check"></i> Marcar Asistencia
                                </button>
                                <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" id="captureButton">
                                    {{ __('Capture Image') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
    @parent
    <!-- Agregar la etiqueta meta viewport solo en esta página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection


@section('javascript')

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const captureButton = document.getElementById('capture');

            async function initCamera() {
                console.log("Inicializando la cámara...");
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                    console.log("La cámara se ha inicializado correctamente.");
                } catch (err) {
                    console.error('Error al acceder a la cámara:', err);
                }
            }
            await initCamera();

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
                        body: JSON.stringify({
                            photo: photoData
                        })
                    });

                    const result = await response.json();
                    console.log('Resultado de la verificación biométrica:', result);
                } catch (err) {
                    console.error('Error al enviar la foto:', err);
                }
            }
        });
    </script>
   
@stop
