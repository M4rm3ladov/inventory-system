@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-units lazy="true">
    @livewire('create-unit')
@endsection
