@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
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
                                <!-- Agregar un campo oculto para enviar los datos base64 de la imagen -->
                                <input type="hidden" id="photo" name="photo">
                                <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                            </div>
                        </div>

                         <!-- Elemento img para mostrar la imagen capturada -->
                         <img id="capturedImage" src="" alt="Captured Image" >

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('javascript')

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const captureButton = document.getElementById('captureButton');
            const photoCapturada = document.getElementById('capturedImage');
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
                    console.log(data);
                    photoCapturada.setAttribute("src", data);

                    // Envía los datos base64 al campo oculto en el formulario,
                    // Your login form now needs a `photo` field (the name can be configured) - this field should contain a base64 representation of the image, the user uses to log in.
                    // laravel-face-auth/README.md at master · mpociot/laravel-face-auth https://github.com/mpociot/laravel-face-auth/blob/master/README.md?plain=1
                    photo.value =data;

                    capturedImage.style.display = 'block';
                    // Muestra el botón para enviar el formulario
                    submitButton.style.display = 'block';

                } else {
                    console.error('Ancho o alto no definido.');
                }
            }
        });
    </script>


@stop
