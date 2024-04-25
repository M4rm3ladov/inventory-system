@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    @include('shared-layout.success-message')
    <h4 class="card-title">List of Branches</h4>
    {{-- content table --}}
    <livewire:all-branches lazy="true">
    {{-- modal create --}}
    @livewire('create-branch')
@endsection
