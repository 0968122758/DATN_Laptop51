@extends('layouts.app')

@section('content')
    <admins-list
        :init-data="{{ json_encode([
            'urlDeleteAllData' => route('admin.admins.deleteAll'),
            'urlGetData' => route('admin.admins.getData'),
            'urlCreate' => route('admin.admins.create'),
        ]) }}">
    </admins-list>
@endsection
