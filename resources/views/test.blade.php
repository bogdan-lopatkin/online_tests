@extends('layouts.app')
@section('content')
<div class="main-container">


 <question-paginator :questions="{{ $questions }}"
                     :test="{{ $test }}"
                     was="{{ json_encode($testInfo) }} ">
 </question-paginator>

    @endsection
