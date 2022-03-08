@extends('layouts.app')

@section('content')
    <admins-create :create-url="{{ json_encode(route('admin.admins.store')) }}"></admins-create>
@endsection
