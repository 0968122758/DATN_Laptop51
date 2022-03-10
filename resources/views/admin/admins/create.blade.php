@extends('layouts.app')

@section('content')
    <admins-create 
        :create-url="{{ json_encode(route('admin.admins.store')) }}"
        :check-unique-url="{{ json_encode(route('admin.admins.checkUniqueEmail')) }}"
    ></admins-create>
@endsection
