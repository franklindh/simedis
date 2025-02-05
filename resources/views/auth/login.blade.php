<x-guest-layout>

    <div id="auth-left">
        {{-- <div class="auth-logo">
            <a href="index.html"><img src="{{ asset('/images/logo/logo.png') }}" alt="Logo"></a>
        </div> --}}
        <h3 class="" style="text-transform: uppercase">Rekam Medis<br>Puskesmas Biak Kota</h3>
        {{-- <h5 class="">Login</h5> --}}
        {{-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> --}}

        {{-- @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif --}}
        <form action="{{ route('logins.authenticate') }}" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input class="form-control form-control-xl" type="text" name="username" placeholder="Username"
                    value="{{ old('username') }}">
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-xl" name="password" placeholder="Password"
                    placeholder="Password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Masuk</button>
        </form>
        {{-- <div class="text-center mt-5 text-lg fs-4">
            @if (Route::has('register'))
                <p class="text-gray-600">Belum mendaftar? <a href="{{ route('register') }}"
                        class="font-bold">Daftar</a>.</p>
            @endif


            @if (Route::has('password.request'))
                <p><a class="font-bold" href="{{ route('password.request') }}">Lupa password?</a>.</p>
            @endif
        </div> --}}
    </div>
</x-guest-layout>

<script>
    $(document).ready(function() {
        // Inisialisasi Notyf
        let notyf = new Notyf({
            duration: 2500, // Durasi notifikasi
            position: {
                x: 'right', // posisi X (left/right)
                y: 'top', // posisi Y (top/bottom)
            }
        });

        // Menampilkan notifikasi berdasarkan session Laravel
        @if (session('success'))
            notyf.success('{{ session('success') }}');
        @elseif (session('error'))
            notyf.error('{{ session('error') }}');
        @elseif (session('info'))
            notyf.open({
                type: 'info',
                message: '{{ session('info') }}'
            });
        @elseif (session('warning'))
            notyf.open({
                type: 'warning',
                message: '{{ session('warning') }}'
            });
        @endif
    });
</script>
