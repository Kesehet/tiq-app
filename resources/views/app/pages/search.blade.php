


<div class="w3-container w3-small w3-left w3-stretch">Search Quizzes</div>

<!-- Search Form -->
<form id="searchForm" action="{{ route('search') }}/" class="w3-container w3-stretch">
    <input type="text" id="searchInput" class="w3-input w3-round w3-col s10 m10 l10" placeholder="Search for quizzes..." name="query" value ="{{ $query }}">
    <button type="submit" class="w3-button w3-round w3-col s2 m2 l2"><i class="fa fa-search"></i></button>
</form>

<!-- Search Results -->
<div id="searchResults" class="w3-margin-top">
    @foreach ($quizzes as $quiz)
    <div class="w3-container w3-card-4 w3-round-large scroll-card" onclick="window.location.href='{{ route('quiz', $quiz->id) }}'" style="width: 75vw;" >
            <img src="https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIzLTA4L3Jhd3BpeGVsb2ZmaWNlNV9lbXB0eV9zcGFjZV8zZF9yZW5kZXJfY2FydG9vbl9zdHlsZV9vZl9hX2lzbGFtaV8yMDA5NGVkZS04N2I2LTQ2NGItOTlmMi02Y2U0N2JhMzA3NzRfMS5qcGc.jpg" alt="Avatar" class="scroll-image">
            <div class="w3-container scroll-content">
                <div class="header6 w3-padding-small">
                    {{ $quiz->title }}
                </div>
                <div class="">
                    <p>{{ $quiz->description }}</p>
                </div>
            </div>
        </div>
    @endforeach
    @if(count($quizzes) == 0)
        <div class="w3-container w3-round-large scroll-card" style="width: 75vw;" >
            <div class="w3-container scroll-content">
                <div class="header6 w3-padding-small">
                    No Quizzes Found for "{{ $query }}"
                </div>
            </div>
        </div>
    @endif
</div>

