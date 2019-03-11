@extends('layouts.master')

@section('title', 'Page Title')
    <title>{{json_encode($user)}}</title>
@endsection

@section('content')
<div class="container">
    {{ $user->name }}
</div>
@endsection
