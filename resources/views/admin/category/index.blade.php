@extends('layouts.app')

@section('content')
    <category-list
        :init-data="{{ json_encode([
            'urlDeleteAllData' => route('admin.category.deleteAll'),
            'urlGetData' => route('admin.category.getData'),
        ]) }}">
    </category-list>
@endsection
