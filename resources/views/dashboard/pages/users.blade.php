<style>
        .search-container {
            margin-bottom: 20px;
        }
        .search-input {
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
</style>

<div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom">
        <h1>Users</h1>
        <div class="search-container w3-row">
            <input class="search-input w3-col s12 m6 l4" type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for names..">
        </div>
    </div>

    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white" id="usersTable">
        <tr class="w3-light-grey">
            <th>Name</th>
            <th>email</th>
            <th>Role</th>
        </tr>
        @foreach($Users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
            </tr>
        @endforeach
    </table>
</div>

<script>
function filterTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("usersTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}
</script>