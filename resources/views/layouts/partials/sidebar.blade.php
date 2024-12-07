{{-- <x-maz-sidebar :href="route('login')">

    <!-- Add Sidebar Menu Items Here -->
    buat dashboard untuk visualisasi data data pasien david biar lebih kompleks dikit
    <x-maz-sidebar-item name="Rekam" :link="route('rekam')" icon="bi bi-grid-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Rekam" :link="route('rekam')" icon="bi bi-grid-fill"></x-maz-sidebar-item>
    @if (Auth::guard('petugas')->user()->role == 'Administrasi')
        <x-maz-sidebar-item name="Rekam" :link="route('rekam')" icon="bi bi-grid-fill" :active="request()->routeIs('rekam') || request()->routeIs('cari')" />
        <x-maz-sidebar-item name="Pendaftaran" :link="route('pendaftaran')" icon="bi bi-archive-fill"></x-maz-sidebar-item>
        <x-maz-sidebar-item name="Pengguna" :link="route('pengguna')" icon="bi bi-person-fill"></x-maz-sidebar-item>
    @endif
    <x-maz-sidebar-item name="Component" icon="bi bi-stack">
        <x-maz-sidebar-sub-item name="Accordion" :link="route('components.accordion')"></x-maz-sidebar-sub-item>
        <x-maz-sidebar-sub-item name="Alert" :link="route('components.alert')"></x-maz-sidebar-sub-item>
    </x-maz-sidebar-item>
</x-maz-sidebar> --}}

{{-- versi 2 browwwwww --}}
<style>
    .sidebar-wrapper {
        background-color: #ffffff;
        padding: 15px;
        border: 1px solid #435EBE;
        border-radius: 10px;
    }

    .menu .nav-item .nav-link {
        color: #6c757d;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 8px;
        text-align: left;
        display: block;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }

    .menu .nav-item .nav-link.active {
        background-color: #465C9E;
        color: #fff;
    }

    .menu .nav-item .nav-link i {
        margin-right: 10px;
    }

    .menu .nav-item .nav-link:hover {
        background-color: #465C9E;
        color: #fff;
    }

    /* Menghilangkan titik di sebelah kiri */
    .menu .nav-item {
        list-style: none;
    }

    .sidebar-icon {
        width: 20px;
        /* Sesuaikan dengan ukuran ikon lainnya */
        height: 20px;
        /* Sesuaikan dengan ukuran ikon lainnya */
        object-fit: contain;
        /* Memastikan gambar tidak terdistorsi */
        margin-right: 10px;
        /* Beri jarak antara ikon dan teks */
        vertical-align: middle;
        /* Rata tengah dengan teks */
    }
</style>
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo section can be added here if needed -->
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu text-center">
                {{-- <li class="sidebar-title">
                    <h6>MENU</h6>
                </li>
                <hr> --}}

                @if (Auth::guard('petugas')->user()->role == 'Administrasi')
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ request()->routeIs('pendaftaran*') ? 'active' : '' }}" --}}
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ request()->routeIs('pendaftaran*') ? 'active' : '' }}" --}}
                        <a class="nav-link {{ request()->routeIs('pendaftaran') ? 'active' : '' }}"
                            href="{{ route('pendaftaran') }}">
                            <i class="bi bi-archive-fill"></i>Pendaftaran
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pendaftaran*') ? 'active' : '' }}" <a
                            class="nav-link {{ request()->routeIs('jadwal') ? 'active' : '' }}"
                            href="{{ route('jadwal') }}">
                            <i class="bi bi-calendar2-week-fill"></i>Jadwal Dokter
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('data*') ? 'active' : '' }}"
                            href="{{ route('data') }}">
                            <i class="bi bi-clipboard-data-fill"></i>Data
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('data*') ? 'active' : '' }}"
                            href="#dataSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
                            aria-controls="dataSubmenu">
                            <i class="bi bi-clipboard-data-fill"></i>Data
                        </a>
                        <ul class="collapse list-unstyled {{ request()->routeIs('data*') ? 'show' : '' }}"
                            id="dataSubmenu">
                            <li>
                                <a class="nav-link {{ request()->routeIs('data.icd') ? 'active' : '' }}"
                                    href="{{ route('data.icd') }}"><i class="bi bi-bandaid-fill"></i>
                                    ICD
                                </a>
                            </li>
                        </ul>
                        <ul class="collapse list-unstyled {{ request()->routeIs('data*') ? 'show' : '' }}"
                            id="dataSubmenu">
                            <li>
                                <a class="nav-link {{ request()->routeIs('data.poli') ? 'active' : '' }}"
                                    href="{{ route('data.poli') }}"><i class="bi bi-hospital-fill"></i>
                                    Poli
                                </a>
                            </li>
                        </ul>
                        <ul class="collapse list-unstyled {{ request()->routeIs('data*') ? 'show' : '' }}"
                            id="dataSubmenu">
                            <li>
                                <a class="nav-link {{ request()->routeIs('data.jadwal') ? 'active' : '' }}"
                                    href="{{ route('data.jadwal') }}"><i class="bi bi-calendar-week-fill"></i>
                                    Jadwal
                                </a>
                            </li>
                        </ul>
                        <ul class="collapse list-unstyled {{ request()->routeIs('data*') ? 'show' : '' }}"
                            id="dataSubmenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('data.pengguna') ? 'active' : '' }}"
                                    href="{{ route('data.pengguna') }}">
                                    <i class="bi bi-person-fill"></i>Pengguna
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::guard('petugas')->user()->role == 'Poliklinik' || Auth::guard('petugas')->user()->role == 'Dokter')
                    <li class="nav-item">
                        <!-- Aktif pada route rekam atau cari -->
                        <a class="nav-link {{ request()->routeIs('rekam') || request()->routeIs('cari') || request()->routeIs('detailByTanggal') ? 'active' : '' }}"
                            href="{{ route('rekam') }}">
                            <i class="bi bi-grid-fill"></i>Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemeriksaan', 'pemeriksaan.show') ? 'active' : '' }}"
                            href="{{ route('pemeriksaan') }}">
                            <i class="bi bi-calendar2-week-fill"></i>Pemeriksaan
                        </a>
                    </li>
                @elseif(Auth::guard('petugas')->user()->role == 'Lab')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lab', 'lab.show') ? 'active' : '' }}"
                            href="{{ route('lab') }}">
                            <i class="bi bi-flask"></i>Pemeriksaan Lab
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
