@extends('layouts.app')

@section('content')
    <review-list
        :init-data="{{ json_encode([
            'urlDeleteAllData' => route('admin.review.deleteAll'),
            'urlGetData' => route('admin.review.getData'),
            'urlDeleteItemData' => route('admin.review.deleteItem',''),
        ]) }}">
    </review-list>
@endsection
