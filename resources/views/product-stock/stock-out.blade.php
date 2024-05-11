@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-stock-outs lazy="true">
    @livewire('create-stock-out')
@endsection