@extends('layouts.app')

@section('content')
    <user-list
        :init-data="{{ json_encode([
            'urlDeleteAllData' => route('admin.user.deleteAll'),
            'urlGetData' => route('admin.user.getData'),
            'userCreate' => route('admin.users.create'),
        ]) }}">
    </user-list>
@endsection
