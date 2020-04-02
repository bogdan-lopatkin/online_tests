@extends('Admin.app')
@section('content')

    <main  role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div id="app">
            <question-constructor
                :categories="{{ \App\Models\Category::select()->get() }}"
                save_route="{{ route('admin.test.store') }}"
                upload_route="{{ route('img.upload') }}">
            </question-constructor>
        </div>
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

@endsection
