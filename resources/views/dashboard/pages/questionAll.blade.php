<div class="w3-container">
    <h2>Questions</h2>

    <!-- Add Question Button -->
    <div class="w3-row w3-margin-bottom">
        <a href="{{ route('dashboard.question.create') }}" class="w3-button w3-round w3-right w3-feature"><i class="fa fa-plus"></i> Add New Question</a>
    </div>


        <!-- Search Form -->
        <form action="" method="GET" class="w3-row w3-margin-bottom">
        <div class="w3-col s8 m10 l10">
            <input class="w3-input w3-border" type="text" placeholder="Search for Questions..." name="q">
        </div>
        <div class="w3-col s4 m2 l2">
            <button  class="w3-button w3-block w3-feature" type="submit" >Search</button>
        </div>
    </form>

    <!-- List of Questions -->
    <div class="w3-row-padding w3-margin-top">
        @foreach($questions as $question)
            <div class="w3-col s12 m6 l4 w3-margin-bottom">
                <div class="w3-card w3-hover-shadow w3-round-large">

                    <header class="w3-container w3-light-grey">
                        <h3 class="w3-margin w3-padding-16">{!! $question->question_text !!}</h3>
                    </header>

                    <div class="w3-container">
                        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                            @foreach($question->translations as $translation)
                                <tr class="{{ $languages->where('id',$translation->language_id)->first()->font }}" >
                                    <td class="" ><b>{{ $languages->where('id',$translation->language_id)->first()->name }}</b></td>
                                    <td>{{ $translation->translated_text }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <footer class="w3-container">
                        <button onclick = "location.href='{{ route('dashboard.question.create') }}?question_id={{ $question->id }}'" class="w3-button w3-right w3-feature w3-margin w3-round">Edit</button>
                        <button onclick = "deleteQuestion({{ $question->id }})" class="w3-button w3-left w3-red w3-margin w3-round">Delete</button>
                    </footer>

                    <div id="deleteQuestion_{{ $question->id }}" class="w3-modal w3-hide">
                        <div class="w3-modal-content w3-card-4 w3-animate-top">
                            <header class="w3-container w3-red">
                                <span onclick="deleteQuestion({{ $question->id }})" class="w3-button w3-display-topright">&times;</span>
                                <h2>Delete Question</h2>
                            </header>
                            <div class="w3-container">
                                <p>Are you sure you want to delete this question?</p>
                            </div>
                            <footer class="w3-container w3-border-top w3-padding-16">
                                <button onclick="location.href='{{ route('dashboard.question.delete', $question->id) }}'" class="w3-button w3-red">Delete</button>
                            </footer>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>




<script>
    // A function to create a dynamic overlay to prompt the user if he really wants to make the delete
    function deleteQuestion(id) {
        var element = document.getElementById('deleteQuestion_' + id);
        element.classList.toggle('w3-show');
        element.classList.toggle('w3-hide');
    }

</script>
