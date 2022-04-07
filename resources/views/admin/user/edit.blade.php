@extends('layouts.app')

@section('content')
    <user-edit
        :init-data="{{ json_encode([
            'urlDeleteAllData' => route('admin.user.deleteAll'),
            'urlGetData' => route('admin.user.getData'),
            'user' => $user
        ]) }}">
    </user-edit>
@endsection
