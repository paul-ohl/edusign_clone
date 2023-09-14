@include('header')
<h1>Connexion</h1>
<form method="POST" class="row" action="/user/login">
    @csrf
    <div class="input-field col s12">
        <select name="user">
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->status }})</option>
            @endforeach
        </select>
        <label>Selectionnez votre utilisateur:</label>
    </div>
    <div class="input-field col s12">
        <button class="btn waves-effect waves-light" type="submit" name="action">Se connecter</button>
    </div>
</form>
@include('footer')
