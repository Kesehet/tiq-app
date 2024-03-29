@if (count($latestQuizzes) > 0)
<div>
    <div class="w3-container header5">
            New Quizzes
    </div>
    <div class="scroll-wrapper w3-padding">
    
    @foreach($latestQuizzes as $quiz)
        <div class="w3-container w3-card-4 w3-round-large scroll-card w3-hover-opacity" onclick="goToPage('{{route('quiz', $quiz->id)}}')" >
            <img src="{{ $quiz->featured_image }}" alt="Avatar" class="scroll-image">
            <div class="w3-container scroll-content" style="white-space: normal;">
                <div class="header6 w3-padding-small w3-small">
                    {{ $quiz->title }}
                </div>
                <div class="w3-tiny">
                    <p>{!! $quiz->description !!}</p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endif