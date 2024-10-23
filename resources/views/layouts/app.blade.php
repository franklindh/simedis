<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <!-- Flatpickr CSS -->
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Notyf CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <!-- Notyf JS -->
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        @include('layouts.partials.styles')
    </head>

    <body>
        <div id="app">

            @include('layouts.partials.sidebar')
            <div id="main" class='layout-navbar'>
                @include('layouts.partials.header')
                <div id="main-content">

                    <div class="page-heading">
                        <div class="page-title">
                            {{ $header }}
                        </div>
                        {{ $slot }}
                    </div>

                    @include('layouts.partials.footer')
                </div>
            </div>
        </div>

        <!-- Scripts -->
        @include('layouts.partials.scripts')
    </body>

</html>
