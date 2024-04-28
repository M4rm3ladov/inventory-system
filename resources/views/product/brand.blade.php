@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <livewire:all-brands lazy="true">
    @livewire('create-brand')
@endsection
