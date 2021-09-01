@foreach($privacies as $privacy)
    {!! htmlspecialchars_decode($privacy->json) !!}
@endforeach
