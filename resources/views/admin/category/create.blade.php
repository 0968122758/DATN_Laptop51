@extends('layouts.app')

@section('content')
    <category-create :create-url="{{ json_encode(route('admin.category.store')) }}"></category-create>
@endsection
