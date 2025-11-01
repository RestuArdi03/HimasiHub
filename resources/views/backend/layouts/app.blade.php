<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/backend-assets/css/bootstrap.css">

    <link rel="stylesheet" href="/backend-assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="/backend-assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/backend-assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/backend-assets/css/app.css">
    <link rel="shortcut icon" href="/backend-assets/images/favicon.svg" type="image/x-icon">
    
    @stack('styles')
</head>

<body>
    <div id="app">
        @include('backend.partials.sidebar')

        <div id="main">
            @include('backend.partials.header')

            <div class="page-heading">
                <h3>@yield('page-heading', 'Dashboard')</h3>
            </div>
            
            <div class="page-content">
                @yield('content')
            </div>

            @include('backend.partials.footer')
        </div>
    </div>

    <script src="/backend-assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/backend-assets/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script src="/backend-assets/js/main.js"></script>
</body>

</html>


