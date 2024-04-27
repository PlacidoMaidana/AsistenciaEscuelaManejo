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
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <!-- Agregar el componente Vue Webcam -->
                            <div class="row mb-3">
                                <div class="col-md-4"></div>
                                <div class="col-md-6">
                                    <h2>Foto</h2>
                                    <video id="video" width="100%" height="auto" autoplay></video>
                                    <!-- Botón para guardar la imagen original -->
                                    <button type="button" id="captureButton" class="btn btn-primary">
                                        {{ __('Capture Image') }}
                                    </button>

                                    <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                                </div>
                            </div>



                        </form>


                        <!-- Elemento img para mostrar la imagen capturada -->
                        <img id="capturedImage" src="" alt="Captured Image">
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
        const captureButton = document.getElementById('captureButton');
        const photo = document.getElementById('capturedImage');
        let width = 640; // Update with your desired width
        let height = 480; // Update with your desired height

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

        captureButton.addEventListener('click', () => {
            takepicture();
        });

        function takepicture() {
            const context = canvas.getContext("2d");
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                const data = canvas.toDataURL("image/png");
                photo.setAttribute("src", data);
            } else {
                console.error('Ancho o alto no definido.');
            }
        }
    });
</script>


@stop
