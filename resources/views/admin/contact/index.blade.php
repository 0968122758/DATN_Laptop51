@extends('layouts.app')

@section('content')
    <contact-list
        :init-data="{{ json_encode([
            'urlDeleteItemData' => route('admin.contact.deleteItem',''),
            'urlDeleteAllData' => route('admin.contact.deleteAll'),
            'urlGetData' => route('admin.contact.getData'),
        ]) }}">
    </contact-list>
@endsection
