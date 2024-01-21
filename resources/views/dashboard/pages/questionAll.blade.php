<div class="w3-container">
    <h2>Questions</h2>

    <!-- Add Question Button -->
    <div class="w3-row w3-margin-bottom">
        <a href="{{ route('dashboard.question.create') }}" class="w3-button w3-round w3-right w3-feature"><i class="fa fa-plus"></i> Add New Question</a>
    </div>


        <!-- Search Form -->
        <form action="" method="GET" class="w3-row w3-margin-bottom">
        <div class="w3-col s8 m10 l10">
            <input class="w3-input w3-border" type="text" placeholder="Search for quizzes..." name="q">
        </div>
        <div class="w3-col s4 m2 l2">
            <button  class="w3-button w3-block w3-feature" type="submit" >Search</button>
        </div>
    </form>

    <!-- List of Questions -->
    <div class="w3-row-padding w3-margin-top">
        @foreach($questions as $question)
            <div class="w3-col s12 m6 l4 w3-margin-bottom">
                <div class="w3-card">
                    <header class="w3-container w3-light-grey">
                        <h3>{!! $question->question_text !!}</h3>
                       
                       <table class="w3-table-all">
                            @foreach($question->translations as $translation)
                                <tr>
                                    <td>{{ App\Models\Language::find($translation->language_id)->name }}</td>
                                    <td>{{ $translation->translated_text }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </header>
                    
                </div>
            </div>
        @endforeach
    </div>
</div>
