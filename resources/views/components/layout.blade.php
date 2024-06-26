<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        @include('components.navigation')
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error_message') }}
            </div>
        @endif

        @if(session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif
        
        <div class="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>