@foreach($contracts as $contract)
    {!! htmlspecialchars_decode($contract->json) !!}
@endforeach
