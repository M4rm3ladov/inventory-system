@extends('shared-layout.layout')

@section('content')
    <livewire:all-suppliers lazy="true">
    @livewire('create-supplier')
@endsection
