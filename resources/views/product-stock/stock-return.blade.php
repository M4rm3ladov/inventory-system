@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-stock-returns lazy="true">
    @livewire('create-stock-return')
@endsection