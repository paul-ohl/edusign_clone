@include('header')
<h1>Panneau d'administration</h1>
<p>Don't be evil hahaha.</p>
<form method="POST" action="/admin">
    @csrf
    <div class="row">
        <div class="input-field col s12">
            <label for="name">Nom de l'utilisateur</label>
            <input type="text" id="name" name="name" required />
        </div>
        <div class="input-field col s12">
            <select name="status">
                <option selected value="etudiant">Étudiant</option>
                <option value="admin">Administrateur</option>
                <option value="professeur">Professeur</option>
            </select>
            <label>Type d'utilisateur</label>
        </div>
        <div class="input-field col s12">
            <button class="btn waves-effect waves-light" type="submit" name="action">Ajouter</button>
        </div>
    </div>
</form>
<div>
    <h2>Liste de tout le monde</h2>

    <div>
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Status</th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <form method="POST" action="/users/{{$user->id}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@if (session('success'))
<div >
    {{ session('success') }}
</div>
@endif

@include('footer')
