@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <Teacher :teachers="{{json_encode($teachers)}}" > </Teacher>
    </div>
</div>
@endsection
