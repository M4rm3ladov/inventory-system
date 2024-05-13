@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-stock-counts lazy="true">
    @livewire('create-stock-count')
@endsection