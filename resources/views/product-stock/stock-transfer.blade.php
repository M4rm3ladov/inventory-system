@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-stock-transfers lazy="true">
    @livewire('create-stock-transfer')
@endsection