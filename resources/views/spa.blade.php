@extends('layouts.app')

@section('content')

    <div>
        <spa-app></spa-app>
    </div>

@endsection

@section('page-js-script')
    <script>
        window.routes = {
            'tests' : '{{ route('tests')}}',
            'category_tests' : '{{ route('tests.category',[0])}}',
            'test' : '{{ route('test',[0])}}',
            'result' : "{{ route('showResult') }}",
            'restore_password' : "{{ route('password.request') }}",
            'login' : "{{ route('login') }}"
        }
    </script>
@endsection
