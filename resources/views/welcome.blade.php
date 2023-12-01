<!DOCTYPE html>
<html>
<head>
    <title>Welcome to TIQ Quiz</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .w3-feature{
            background-color:#005c27 !important;
            color: white;
        }
        .slide-container {
            position: relative;
            height: 100vh;
            background: white;
            overflow: hidden;
        }
        .slide {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            
            box-sizing: border-box;
            transform: scale(1.1);
            opacity: 0;
            transition: transform 0.5s, opacity 0.5s;
        }
        .slide.active {
            opacity: 1;
            transform: scale(1);
        }
        .slide img {
            max-height: 50%;
            max-width: 100%;
            vertical-align: middle;
        }
        .slide p {
            margin-top: 24px;
            font-size: 36px;
            line-height: 1.6;
        }
        .button {
            padding: 10px 30px;
            margin-top: 30px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        @media screen and (max-width: 600px) {
            .slide p {
                font-size: 16px;
            }
            .button {
                width: 100%;
                padding: 15px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="slide-container" onclick="changeSlide(1)">
    <div class="slide active">
        <img src="{{asset('imgs/growth from quiz.png')}}" alt="Savings">
        <p>Welcome to TIQ Quiz! Begin your learning journey.</p>
        
    </div>

    <div class="slide">
        <img src="{{asset('imgs/interact quiz.png')}}" alt="Statistics">
        <p>Engage with interactive quizzes and track your progress.</p>
        
    </div>

    <div class="slide">
        <img src="{{asset('imgs/Connect with a community.png')}}" alt="Management">
        <p>Connect with a community of learners.</p>
        <button class="button w3-feature" >Get Started</button>
    </div>

    <div class="slide">
        <img src="{{asset('imgs/Login now.png')}}" alt="Management">
        
        <button class="button w3-feature" >Login Now</button>
    </div>

</div>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll(".slide");

function changeSlide(n) {
  if(currentSlide == slides.length - 1) {
    alert("Login Now.");
    clearInterval(slideshowInterval);
    return;
  }
  slides[currentSlide].classList.remove("active");
  currentSlide = currentSlide + n ;
  slides[currentSlide].classList.add("active");
}

// Optional: Automatic slide change every 2 seconds
var slideshowInterval = setInterval(() => changeSlide(1), 2000);
</script>

</body>
</html>
