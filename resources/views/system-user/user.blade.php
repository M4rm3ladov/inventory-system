@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-users lazy="true">
    @livewire('create-user')
@endsection
