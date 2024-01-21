@include('app.component.latestQuiz')
<hr/>
<p class="header6"> Welcome {{Auth::user()->name}}, </p>






@include('app.component.analytics')
<hr/>
@include('app.component.allQuizzes')
<hr/>