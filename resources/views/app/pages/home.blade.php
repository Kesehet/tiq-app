@include('app.component.latestQuiz')
<hr/>
<p class="header6"> Welcome {{Auth::user()->name}}, </p>
<p class="para1 w3-container w3-padding w3-feature w3-center w3-animate-opacity">Masha Allah, You have completed 100 quizzes.</p>
@include('app.component.analytics')
<hr/>
@include('app.component.allQuizzes')
<hr/>