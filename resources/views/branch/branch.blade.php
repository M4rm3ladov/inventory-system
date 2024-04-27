@extends('shared-layout.layout')

@section('content')
    {{-- content table --}}
    <livewire:all-branches lazy="true">
    {{-- modal create --}}
    @livewire('create-branch')
@endsection
