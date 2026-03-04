@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonColor: '#111111',
                background: '#ffffff',
                color: '#111111',
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: @json(session('error')),
                confirmButtonColor: '#111111',
            });
        });
    </script>
@endif

@if (session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: @json(session('warning')),
                confirmButtonColor: '#111111',
            });
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: @json(session('info')),
                confirmButtonColor: '#111111',
            });
        });
    </script>
@endif
