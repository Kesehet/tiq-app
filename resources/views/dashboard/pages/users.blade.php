<div class="w3-row-padding w3-margin-bottom">
        <h1>Users</h1>
    </div>

<table class=" w3-container w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
<tr>

            <th>Name</th>
            <th>Id</th>
            <th>Role</th>

        </tr>
@foreach($Users as $user)
        <tr>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->id }}
            </td>
            <td>
                {{ $user->role }}
            </td>
         </tr>


@endforeach
 </table>
