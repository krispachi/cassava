<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield("title")</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="@yield("title")" />
    <meta name="author" content="Krispachi" />
    <meta name="description" content="Website Sistem Informasi Kegiatan UKM dan TAK." />
    <meta name="keywords" content="cassava, poin tak, tak, ukm, aktivitas" />
    <link rel="shortcut icon" href="{{ asset("images/Logo Cassava Rounded.png") }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome 6 -->
    <script src="https://kit.fontawesome.com/df662858df.js" crossorigin="anonymous"></script>
    @stack('styles')
    @yield("headlinks-before-adminlte")
    <link rel="stylesheet" href="{{ asset("AdminLTE4/dist/css/adminlte.css") }}" />
    @yield("headlinks-after-adminlte")
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary" style="background-color: #F5F7FA !important">
    <div class="app-wrapper">
        @include("components.navbar")
        @include("components.sidebar")

        @if (session()->has("success") || session()->has("warning") || session()->has("error"))
            <script>
                let tipe;
                let pesan;
                @if (session()->has("success"))
                    tipe = "success";
                    pesan = '{{ session("success") }}';
                @elseif (session()->has("warning"))
                    tipe = "warning";
                    pesan = '{{ session("warning") }}';
                @else
                    tipe = "error";
                    pesan = '{{ session("error") }}';
                @endif;

                Swal.fire({
                    icon: tipe,
                    title: pesan,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    showCloseButton: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            </script>
        @endif

        @yield("content")
        @include("components.footer")
    </div>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="{{ asset("AdminLTE4/dist/js/adminlte.js") }}"></script>

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>

    @yield("bodyscripts")
    @stack('scripts')
</body>

</html>
