@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-services lazy="true">
    @livewire('create-service')
@endsection
