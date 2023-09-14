@include('header')
<form method="POST" action="/sign/{{$id}}">
    @csrf
    <h1>Signature de présence</h1>
    <input type="hidden" name="session_id" value="{{$id}}">
    <button class="btn waves-effect waves-light" type="submit" name="action">Signer</button>
</form>
@include('footer')
