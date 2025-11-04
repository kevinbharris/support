<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title')</title>
    <!-- Add CSS/JS (Bootstrap, custom styles, etc) below -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/admin/support/tickets">Support Desk</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/admin/support/tickets">Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/support/categories">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/support/statuses">Statuses</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/support/priorities">Priorities</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
