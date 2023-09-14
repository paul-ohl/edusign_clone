@include('header')
<h1>Tu es {{ $user->name }}</h1>
<h3>Bravo</h3>
@if($user->status == 'professeur')
<form method="POST" action="{{route('sessions.store')}}">
    @csrf
    <div class="input-field col s12">
        <button class="btn waves-effect waves-light" type="submit" name="action">Créer une nouvelle session!</button>
    </div>
</form>
@endif

@if($user->status == 'professeur')
<div>
    @if(sizeof($sessions) > 0)
    <ul class="collection with-header">
        <li class="collection-header"><h4>Liste des sessions</h4></li>
        @foreach ($sessions as $session)
        <li class="collection-item">
            <div>
                Session {{ $session->id }}
                <a href="/sessions/{{ $session->id }}" class="secondary-content">
                    <i class="material-icons">send</i>
                </a>
            </div>
        </li>
        @endforeach
    </table>
    @endif
</div>
@endif

<a href="/user/logout" class="waves-effect waves-light btn red">Se déconnecter</a>
@include('footer')
