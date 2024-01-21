


<div class="w3-container ">


    <div class="w3-row-padding w3-margin-bottom">
        <h1>Languages</h1>
    </div>

    <!-- Display Available Languages in a table -->


    <table class=" w3-container w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <tr>
            
            <th>Name</th>
            <th>Code</th>
            <th>Font</th>
            <th>Actions</th>
        </tr>
        @foreach($languages as $language)
        <tr>
            <td>
                {{ $language->name }}
            </td>
            <td>
                {{ $language->code }}
            </td>
            <td>
                {{ $language->font }}
            </td>
            <td>
                <!-- Use JS To fill the form below to edit -->
                <button class="w3-button w3-feature" onclick="gebi('name').value = '{{$language->name}}';gebi('code').value = '{{$language->code}}';gebi('font').value = '{{$language->font}}'; gebi('heading').innerHTML = 'Edit Language'; gebi('submit').innerHTML = 'Update';" >Edit</button>
                <button class="w3-button w3-feature" onclick="window.location.href = '{{ route('dashboard.languages.destroy', $language->id) }}'">Delete</button>
            </td>

        </tr>
        @endforeach
    </table>

    <hr>
    <!-- Add new language -->

    <div class="w3-row-padding w3-margin-bottom">
        <h3 id="heading">Add New Language</h3>
    </div>

    <div class="w3-row-padding w3-margin-bottom">
        <form action="{{route('dashboard.languages.store')}}" method="post">
            @csrf
            <div class="w3-row-padding w3-margin-bottom">
                <div class="w3-half">
                    <label>Name</label>
                    <input id="name" class="w3-input w3-border" type="text" name="name">
                </div>
                <div class="w3-half">
                    <label>Code</label>
                    <input id="code" class="w3-input w3-border" type="text" name="code">
                </div>
            </div>
            <div class="w3-row-padding w3-margin-bottom">
                <div class="w3-half">
                    <label>Font</label>
                    <input id="font" class="w3-input w3-border" type="text" name="font">
                </div>
            </div>
            <div class="w3-row-padding w3-margin-bottom">
                <div class="w3-half  ">
                    <button id="submit" class="w3-button w3-right w3-green w3-round" type="submit">Add</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    function gebi(id){
        return document.getElementById(id);
    }
</script>

