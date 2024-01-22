<style>
    .floating-submit-button {
        position: fixed;   /* Fixed position relative to the viewport */
        bottom: 5%;      /* 20px from the bottom */
        right: 35%;       /* 20px from the right */
        z-index: 1000;     /* Ensure it's above other elements */
    }
</style>

<div class="w3-container">
    <!-- Quiz Description Section -->
    <div class="w3-card w3-round-large w3-margin-bottom" id="title-screen" >
        <div class="w3-container w3-padding">
            <img src="{{ $quiz->featured_image }}" class="w3-round-xlarge" style="width:100%;">
            <h2>{{ $quiz->title }}</h2>
            <p>{!!$quiz->description !!}</p>
            <button class="w3-button w3-green w3-margin-top w3-round-xxlarge" onclick="startQuiz()">Start Quiz</button>
        </div>
    </div>











    
    <div id="quizSection" class="w3-animate-opacity w3-margin-bottom w3-padding-bottom" style="display:none;">
        @foreach($questions->where('quiz_id', $quiz->id) as $question)
            <div class="w3-card questionCard w3-round-xxlarge w3-margin-bottom">
                <div id="base_question" class="w3-panel w3-padding">{!! $question->question_text !!}</div>
                <div id="question" class="w3-panel w3-border w3-padding"> {!! $translations->where('question_id', $question->id)->where('language_id',$userPrefferedLanguage)->first()->translated_text ?? ' <b style="color:red;">Not available in your language.</b> <br>'.$translations->where('question_id', $question->id)->first()->translated_text !!} </div>
                
                <div class="w3-ul w3-border w3-padding-large" id="option_holder">
                    @foreach($options->where('question_id', $question->id) as $option)
                        <div class="w3-card w3-animate-left option_set_{{ $question->id }} w3-padding" onclick="handleRadioClick(this.children[0].children[0],'option_set_{{ $question->id }}');">
                            <label>
                                <input type="radio" name="question_{{ $question->id }}" qid="{{ $question->id }}" value="{{ $option->id }}" style="display:none;">
                                <i class="fa fa-circle w3-left"></i>
                                {!! $option_transaltions->where('option_id', $option->id)->where('language_id', $userPrefferedLanguage)->first()->translated_text ?? ' <b style="color:red;">Not available in your language.</b> <br>'.$option_transaltions->where('option_id', $option->id)->first()->translated_text !!}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <!-- Floating button at bottom right to submit the quiz -->
        <button class="w3-button w3-green w3-round-xxlarge floating-submit-button" onclick="submitQuiz()">Submit</button>

    </div>
    <div id="resultSection" class="w3-animate-opacity" style="display:none;">
        Submitting Answers ...
    </div>


</div> 

<script>
    function startQuiz(){
        document.getElementById("title-screen").style.display = "none";
        document.getElementById("quizSection").style.display = "block";
    }
</script>

<script>
    function handleRadioClick(radio,classes) {
        // Reset all options' styles
        document.querySelectorAll('.'+classes).forEach(function(card) {
            card.classList.remove('w3-blue');
        });

        // Apply the style to the selected option
        radio.closest('.'+classes).classList.add('w3-blue');
        radio.checked = true;
        ANSWERS[radio.getAttribute('qid')] = radio.value;
    }
    function submitQuiz(){
        document.getElementById("quizSection").style.display = "none";
        document.getElementById("resultSection").style.display = "block";

        fetch("{{ route('submit-quiz', $quiz->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
            },
            body: JSON.stringify({ answers: ANSWERS })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            // Handle success
            window.location.href = "{{ route('quiz-results', $quiz->id) }}";
        })
        .catch((error) => {
            console.error('Error:', error);
            // Handle errors
        });
    }
</script>
<script>
    var ANSWERS = {
        @foreach($questions->where('quiz_id', $quiz->id) as $question)
            "{{ $question->id }}": "",
        @endforeach
    };
    
</script>