<!DOCTYPE html>
<html>
<head>
    <title>TIQ App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('scripts/charts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/elements-basic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri+Quran&display=swap" rel="stylesheet">



    <script>
        var BASE_URL = "{{ url('/') }}";
    </script>
</head>
<body>
    <div class="top-nav quran-text w3-feature" style="width:100vw;padding: 0px">
         <img src="{{ asset('imgs/tiq-grand-logo.png') }}" style="width: 100%">
    </div>
    <div class="content w3-animate-opacity">
        <div class="w3-container w3-padding">
            <!-- Your main content goes here -->

            @include('app.pages.'.$showPage)

            <!-- Add more content here -->
        </div>
    </div>
    <div class="bottom-nav w3-feature">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i></a>
        <a href="{{ route('search') }}"><i class="fa-solid fa-magnifying-glass"></i></a>
        <!--a href=""><i class="fa-solid fa-user"></i></a-->
        <a href="{{route('settings')}}"><i class="fa-solid fa-cog"></i></a>
        @if (Auth::user()->isTeamMember())
            <a href="{{route('dashboard')}}"><i class="fa-solid fa-chart-line"></i></a>
        @endif
    </div>

    <script>
        function goToPage(page){
            window.location.href = page
        }
    </script>
</body>
</html>


