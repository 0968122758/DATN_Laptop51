@extends('layouts.app')

@section('content')
    <contact-list
        :init-data="{{ json_encode([
            'urlDeleteAllData' => route('admin.contact.deleteAll'),
            'urlGetData' => route('admin.contact.getData'),
        ]) }}">
    </contact-list>
@endsection
