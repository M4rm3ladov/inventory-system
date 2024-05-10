@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-items lazy="true">
    @livewire('create-item')
    @livewire('all-items-list')
@endsection
