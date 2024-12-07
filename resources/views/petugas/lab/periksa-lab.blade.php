<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <section class="section">
        <div id="card-utama" class="card fixed-card mb-4">
            <div class="card-body text-center">
                <!-- Form Verifikasi Kode Lab -->
                <h4>Daftar Periksa Lab</h4>
                <form action="{{ route('lab.cari') }}" method="GET" class="d-inline">
                    <div class="input-group justify-content-center mt-3">
                        <input type="text" class="form-control" name="kode_lab" id="kode_lab"
                            placeholder="Masukkan Kode Lab" required style="max-width: 400px;">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>

<script>
    $(document).ready(function() {
        let notyf = new Notyf({
            duration: 1000, // Durasi notifikasi
            position: {
                x: 'right', // posisi X (left/right)
                y: 'top', // posisi Y (top/bottom)
            }
        });

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
