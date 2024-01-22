@extends(( auth()->user()->role == 'client' ? 'layouts.client-layout.app' : 'layouts.admin-layout.app' ))

@section('content')
    
@endsection