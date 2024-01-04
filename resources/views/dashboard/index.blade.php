<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - TIQ App</title>
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
        // Script to toggle the sidebar on and off
        function toggleSidebar() {
            var mySidebar = document.getElementById("mySidebar");
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
            } else {
                mySidebar.style.display = 'block';
            }
        }
    </script>
</head>
<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-feature w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="toggleSidebar();">&#9776;</button>
        <span class="w3-bar-item w3-right">TIQ App</span>
    </div>

    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row w3-margin-top">
            <div class="w3-col s4 w3-margin-top">
                <img src="https://cdn4.iconfinder.com/data/icons/logos-brands-5/24/gravatar-512.png" class="w3-circle w3-margin-right" style="width:46px">
            </div>
            <div class="w3-col s8 w3-bar w3-margin-top">
                <span>Welcome, <strong>{{ Auth::user()->name }}</strong></span><br>
                <!-- Add additional user info or actions here -->
            </div>
        </div>
        <hr>
        <div class="w3-container">
            <h5>Dashboard</h5>
        </div>
        <div class="w3-bar-block">
            <a href="{{route('dashboard')}}" class="w3-bar-item {{ $showPage === 'home' ? 'w3-feature': ''}} w3-button w3-padding"><i class="fa fa-home fa-fw"></i>  Home</a>
            
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-graduation-cap fa-fw"></i>  Quizzes</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Traffic</a>

            <a href="{{route('home')}}" class="w3-bar-item w3-button w3-padding"><i class="fa fa-mobile fa-fw"></i>  Visit The App</a>
            <!-- Add more sidebar items here -->
        </div>
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="toggleSidebar()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Main content: shift it to the right by 300 pixels when the sidebar is visible -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">

        <!-- Dynamic Page Content -->
        <div class="w3-row-padding w3-margin-bottom">
            @include('dashboard.pages.'.$showPage)
        </div>

        

    </div>

</body>
</html>
