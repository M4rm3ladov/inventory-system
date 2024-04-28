@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-service-categories lazy="true">
    @livewire('create-service-category')
@endsection
