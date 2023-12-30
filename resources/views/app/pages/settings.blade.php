

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



<div class=" w3-col m6 l6 s12 w3-margin-bottom w3-round w3-border-bottom w3-padding w3-hover-light-grey">
    <div class="w3-col m8 l8 s8 w3-animate-left" style="font-weight: bold;text-align: left;" >Language</div>
    <div class="w3-col m4 l4 s4 w3-animate-right">
            <select id="language" class="w3-select w3-border-bottom w3-round" onchange="saveSettings()" name="language">
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}" {{ $prefferedLanguage->value == $language->id ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>
    </div>
</div>

<!-- Reminder Toggle Setting -->
<div class="w3-col m6 l6 s12 w3-margin-bottom w3-round w3-border-bottom w3-padding w3-hover-light-grey">
    <div class="w3-col m8 l8 s8 w3-animate-left" style="font-weight: bold;text-align: left;">Enable Reminder</div>
    <div class="w3-col m4 l4 s4 w3-animate-right">
        <input class="w3-check" type="checkbox" id="reminder_toggle" name="reminder_toggle" {{ $reminderEnabled ? 'checked' : '' }} onchange="toggleReminderSetting();saveSettings()">
    </div>
</div>

<!-- Reminder Time Setting -->
<div class="w3-col m6 l6 s12 w3-margin-bottom w3-round w3-border-bottom w3-padding w3-hover-light-grey" id="reminder_time_setting" style="{{ $reminderEnabled ? '' : 'display: none;' }}">
    <div class="w3-col m8 l8 s8 w3-animate-left" style="font-weight: bold;text-align: left;">Reminder Time</div>
    <div class="w3-col m4 l4 s4 w3-animate-right">
        <input type="time" id="reminder_time" class="w3-input w3-border-bottom w3-round" name="reminder_time" value="{{ $reminderTime }}" onchange="saveSettings()">
    </div>
</div>





<script>
function saveSettings() {
    var languageId = document.getElementById('language').value;
    var reminderToggle = document.getElementById('reminder_toggle').checked;
    var reminderTime = reminderToggle ? document.getElementById('reminder_time').value : '';

    if(reminderTime=="" || reminderTime==null){
        reminderTime = "00:00";
    }
    // AJAX call to save preferences
    // Example using fetch:
    fetch("{{ route('settings.save') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            language: languageId,
            reminder_enabled: reminderToggle,
            reminder_time: reminderTime // Send this new setting to the server only if the toggle is enabled
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        // Handle success, such as updating UI or showing a message
    })
    .catch((error) => {
        console.error('Error:', error);
        // Handle errors, such as showing an error message
    });
}

function toggleReminderSetting() {
    var reminderToggle = document.getElementById('reminder_toggle').checked;
    document.getElementById('reminder_time_setting').style.display = reminderToggle ? '' : 'none';
}


</script>
