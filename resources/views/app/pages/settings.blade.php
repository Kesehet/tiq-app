

<div class="w3-display-container w3-stretch w3-feature w3-margin-bottom w3-animate-left" style="height: 25vh;margin-top: -8px;border-radius:1%; border-bottom-right-radius: 15%;">
        <div class="w3-display-bottomleft w3-padding " style="text-align: left;width: 100%;">
            <div class="w3-col m11 l11 s11">
                <div class="w3-xlarge">{{ $user->name }}</div>
                <div class="w3-small">{{ $user->email }}</div>
            </div>
            <div class="w3-col m1 l1 s1">
                <a class="w3-button w3-round w3-small w3-feature" style = "width: 100%"><i class="fa fa-pencil"></i></a>
            </div>
        </div>
    </div>



<div class=" w3-col m6 l6 s12 w3-margin-bottom w3-border-bottom w3-padding">
    <div class="w3-col m8 l8 s8 w3-animate-left" style="font-weight: bold;text-align: left;" >Language</div>
    <div class="w3-col m4 l4 s4 w3-animate-right">
            <select id="language" class="w3-select w3-border" onchange="saveSettings()" name="language">
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}" {{ $user->language_id == $language->id ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>
    </div>
</div>



<script>
    function saveSettings() {
        var languageId = document.getElementById('language').value;
        // AJAX call to save preferences
        // Example using fetch:
        fetch("{{ route('settings.save') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({language: languageId})
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            // Handle success
        })
        .catch((error) => {
            console.error('Error:', error);
            // Handle errors
        });
    }

</script>
