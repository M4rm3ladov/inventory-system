@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-item-categories lazy="true">
    @livewire('create-item-category') 
@endsection
