@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-stock-ins lazy="true">
    @livewire('create-stock-in')
@endsection
