@extends('layouts.app')

@section('script')

    <script>
        window.team ={{$id}}
    </script>

@endsection


@section('content')
    <div class="container">
        <div class="row">
            @if(isset($id))
                <team-details></team-details>
            @else
                <Teams></Teams>
            @endif
        </div>
    </div>
@endsection
