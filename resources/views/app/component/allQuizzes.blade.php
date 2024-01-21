<!-- A list of all quizes -->
@if(count($allQuizzes) > 0)
<div class="">
    <div class="w3-container header5">
        All Quizzes
    </div>
    
    
    <div class="scroll-wrapper w3-padding">
        @foreach($allQuizzes as $quiz)
            <div class="w3-container w3-card-4 w3-round-large scroll-card" style="width: 75vw;" >
                <img src="{{ $quiz->featured_image }}" alt="Avatar" class="scroll-image">
                <div class="w3-container scroll-content">
                    <div class="header6 w3-padding-small">
                        {{ $quiz->title }}
                    </div>
                    <div class="">
                        <p>{!! $quiz->description !!}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="scroll-wrapper w3-padding">
        @foreach($randomQuiz as $quiz)
            <div class="w3-container w3-card-4 w3-round-large scroll-card" style="width: 75vw;" >
                <img src="{{ $quiz->featured_image }}" alt="Avatar" class="scroll-image">
                <div class="w3-container scroll-content">
                    <div class="header6 w3-padding-small">
                        {{ $quiz->title }}
                    </div>
                    <div class="">
                        <p>{!! $quiz->description !!}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>



</div>
@endif
