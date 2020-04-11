@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Последние созданные темы <a id="add_new-thread" class="btn-secondary btn-lg ">Добавить новую</a></h2>
    @foreach($threads as $thread)
    <div class="justify-content-start mt-5 d-flex align-items-center">
        <span><a class="" href="{{ route('user.show',$thread->owner->id) }}"><img style="max-width: 70px" class="mr-5" src="{{ Storage::url($thread->owner->avatar_url) }}"></a></span>
        <div class="d-flex flex-column">
            <h3><a class="" style="color:black" href="{{ route('forum.thread.show',$thread->id) }}">{{ $thread->name }}</h3>
            <div>
                <a class="text-uppercase font-weight-bold" style="font-size: 16px" href="#">{{ $thread->owner->name }}</a>
                <span style="color: gray">Создано {{ $thread->humanDate($thread->created_at) }}</span>
            </div>
        </div>
    </div>

    @endforeach
    <div id="myModal" class="modal">

        <div id="myModal2" class="modal">

            <div class="modal-content" >
                <div class="answer_container">
                    {{ Form::open(['method' => 'POST', 'route' => ['forum.thread.store'],'id' => "new_thread-form"]) }}
                        <div class="modal-header">
                            <input name="title" id="thread_title-input" class="w-100" type="text" placeholder="Введите название темы">
                        </div>
                    {!! Form::hidden('owner_id',auth()->id(),['id' => 'owner_id']) !!}
                    {!! Form::hidden('description',null,['id' => 'description']) !!}
                    <trix-editor placeholder="Введите подробное описание вопроса" input="description"></trix-editor>

                    <div class="modal-footer">
                        <span class="btn-lg btn-secondary close">Закрыть</span>
                        {!! Form::submit('Ответить',['class' => 'btn-lg btn-secondary']) !!}
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

@section('page-js-script')


    <script>
        let answer;
        $(document).ready(function() {

            var modal = document.getElementById("myModal");
            var modal2 = document.getElementById("myModal2");
            var btn = document.getElementById("myBtn");
            var span = document.getElementsByClassName("close")[0];

            span.onclick = function () {
                modal.style.display = "none";
                modal2.style.display = "none";
            };

            $("#add_new-thread").click(function () {

                let x = $(this).parents('#answer_container');
                //  let answerId = $(this).attr('commentId');
                answer = x.find('#answer_description');
                $('#myModal #edit_form trix-editor').val(answer.html());
                modal.style.display = "flex";
                modal2.style.display = "flex";
            });
        });
 </script>
@endsection
