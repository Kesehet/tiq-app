<!DOCTYPE html>
<html>
<head>
    <title>TIQ App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('scripts/charts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/elements-basic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors.css') }}">



    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .content {
            flex: 1;
            margin: 40px 0px;
            text-align: center;
            overflow: scroll-y;
        }

        .bottom-nav {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            color: white;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .bottom-nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            flex: 1; /* Makes each link flexibly occupy equal space */
            text-align: center; /* Centers the text in each link */
        }

        .top-nav {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            color: white;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            top: 0;
        }

        .top-nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            flex: 1; /* Makes each link flexibly occupy equal space */
            text-align: center; /* Centers the text in each link */
        }

        .scroll-wrapper {
            overflow-x: auto;
            white-space: nowrap;
        }

        .scroll-card {
            display: inline-block;
            margin-right: 10px; /* Spacing between cards */
            width: 150px; /* Fixed width for each card */
            padding: 0px;
            overflow: hidden;
            position: relative;
            animation: animateright 0.4s;
        }

        .scroll-image {
            width: 100%;
            height: auto;
        }

        .scroll-content {
            padding: 0px;
        }


        
    </style>
</head>
<body>
    <div class="top-nav w3-feature">
        TIQ App
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
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#"><i class="fa-solid fa-user"></i></a>
        <a href="#"><i class="fa-solid fa-cog"></i></a>
    </div>
</body>
</html>
