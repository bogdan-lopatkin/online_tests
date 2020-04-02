@extends('layouts.app')
@section('content')
<div class="main-container">


 <question-paginator

                     json_data="{{ json_encode($testData[0]) }} "
                     was="{{ json_encode($savedData) ?? null }} "
                     route="{{ route('showResult') }}"

 >
 </question-paginator>
    @endsection
