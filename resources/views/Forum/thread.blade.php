@extends('layouts.app')

@section('content')
<div class="container">

<div class="d-flex row mb-5">
  <div class="col-1" style="color: black"><img style="max-width: 70px" src="https://img.pngio.com/png-avatar-108-images-in-collection-page-3-png-avatar-300_300.png"></div>
  <div class="col-11"  >
      <div class="mb-4 d-flex flex-column">
          <div>
              <h4 >
                  <a href="#">{{ $thread->owner->name }}</a>
                  <span class="text-black-50 small">{{ $thread->humanDate($thread->created_at) }}</span>
              </h4>
          </div>
          <div>
              <h2 class="pl-3 py-3 mb-4" style="background-color: #ecf3fc;">{{ $thread->name }}</h2>
              {!!  $thread->description  !!}
          </div>
      </div>
  </div>
</div>


@forelse($thread->answers as $answer)
    <div class="d-flex row mb-5">
        <div class="col-1" style="color: black"><img style="max-width: 70px" src="https://img.pngio.com/png-avatar-108-images-in-collection-page-3-png-avatar-300_300.png"></div>
        <div id="answer_container" class="col-11"  >
            <div class="d-flex flex-column">
                <div>
                    <h4>
                        <a class="owner_name" href="#">{{ $answer->owner->name }}</a>
                        <span class="text-black-50 small">{{ $answer->humanDate($answer->created_at) }}</span>
                    </h4>
                </div>
                <div id="answer_description">
                    {!! $answer->description !!}
                </div>
                <div>
                    @if(!is_null($answer->likes->where('user_id',auth()->id())->first()))
                        <span class="like liked" post_type="answer" post_id="{{ $answer->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 14 13" style="margin-right: 7px"><path fill-rule="nonzero" d="M13.59 1.778c-.453-.864-3.295-3.755-6.59.431C3.54-1.977.862.914.41 1.778c-.825 1.596-.33 4.014.823 5.18L7.001 13l5.767-6.043c1.152-1.165 1.647-3.582.823-5.18z"><title>Like this reply.</title></path></svg>
                           <span class="like_value"> {{ $answer->likes->count() }} </span>
                        </span>
                    @else
                        <span class="like" post_type="answer" post_id="{{ $answer->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 14 13" style="margin-right: 7px"><path fill-rule="nonzero" d="M13.59 1.778c-.453-.864-3.295-3.755-6.59.431C3.54-1.977.862.914.41 1.778c-.825 1.596-.33 4.014.823 5.18L7.001 13l5.767-6.043c1.152-1.165 1.647-3.582.823-5.18z"><title>Like this reply.</title></path></svg>
                             <span class="like_value"> {{ $answer->likes->count() }} </span>
                        </span>
                    @endif
                    @auth
                <button class="mask_link answer_to" type="button">Ответить</button>
                @if($answer->owner_id == auth()->id())
                    {{ Form::open(['method' => 'DELETE', 'route' => ['forum.thread.answer.destroy', $answer->id],'class' => 'd-inline float-right']) }}
                    <button class="mask_link" onclick="return confirm('Вы уверены ?')">Удалить</button>
                    {{ Form::close() }}
                        <button class="edit_button mask_link float-right pr-3" commentId="{{ $answer->id }}"  type="button">Редактировать</button>
                    @endif
                    @endauth
                </div>
            </div>


        </div>
    </div>
@empty
    Здесь пока нет ответов
@endforelse
@auth
<div class="write_answer">
    Напишите ответ.
</div>
@endauth
@guest
<div class=" ">
     Войдите или зарегистрируйтесь что бы ответить.
</div>
@endguest
<div id="myModal" class="modal">

    <div id="myModal2" class="modal">

        <div class="modal-content" >
            <div id="edit_answer_container" >
                <div class="modal-header">
                    <h2>Редактировать ответ</h2>
                </div>
               <form id="edit_form" onsubmit="edit();return false;">
                   @csrf
                {!! Form::hidden('edit_answer',null,['id' => 'edit_answer']) !!}
                <trix-editor input="edit_answer"></trix-editor>

                <div class="modal-footer">
                    <span class="btn-lg btn-secondary close">Закрыть</span>
                    {!! Form::submit('Ответить',['class' => 'btn-lg btn-secondary']) !!}
                </div>
               </form>
            </div>
            <div class="answer_container">
                <div class="modal-header">
                    <h2  id="reply_to">Ответить</h2>
                </div>
                {{ Form::open(['method' => 'POST', 'route' => ['forum.thread.answer.store']]) }}
                    {!! Form::hidden('owner_id',auth()->id(),['id' => 'owner_id']) !!}
                    {!! Form::hidden('thread_id',$thread->id,['id' => 'thread_id']) !!}
                    {!! Form::hidden('thread_answer',null,['id' => 'thread_answer']) !!}
                    <trix-editor input="thread_answer"></trix-editor>

                    <div class="modal-footer">
                        <span class="btn-lg btn-secondary close">Закрыть</span>
                        {!! Form::submit('Ответить',['class' => 'btn-lg btn-secondary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
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
        var span = document.getElementsByClassName("close")[0];
        var span2 = document.getElementsByClassName("close")[1];

        span.onclick = function() {
             modal.style.display = "none";
             modal2.style.display = "none";
         };
        span2.onclick = function() {
            modal.style.display = "none";
            modal2.style.display = "none";
        };

        $( ".like" ).click(function() {
            let data = {};
            data['postId'] = $(this).attr('post_id');
            data['type'] = $(this).attr('post_type');
            let span = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('forum.like') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": "{{ auth()->id() }}",
                    'postId' : data['postId'],
                    'type' : data['type']
                },
                success : function (data ) {
                    data = JSON.parse(data);
                    span.children('.like_value').html(data.likes);
                    if(data.action == 'like')
                        span.addClass('liked');
                    else
                        span.removeClass('liked');
                }
            });
        });
    $( ".edit_button" ).click(function() {
        let x = $(this).parents('#answer_container');
        answer =  x.find('#answer_description');
        $('#myModal #edit_form trix-editor').val(answer.html());
        modal.style.display = "flex";
        modal2.style.display = "flex";
        $('#edit_answer_container').show();
        $('.answer_container').hide();
    });

    $('.write_answer').click(function() {
        $('#reply_to').html("Ответить на вопрос <a href='#'>{{ '@'.$thread->owner->name }} </a>");
        modal.style.display = "flex";
        modal2.style.display = "flex";
        $('#edit_answer_container').hide();
        $('.answer_container').show();
    });

    $('.answer_to').click(function() {
        let replyTo = $(this).parents('#answer_container').find('.owner_name');
        $('#myModal  trix-editor').val('<a href="' + replyTo.attr('href') + '">@' + replyTo.html() + '</a>,');
        console.log(replyTo.attr('href'));
        $('#reply_to').html("Ответить пользователю " + '<a href="' + replyTo.attr('href') + '">@' + replyTo.html() + '</a>'   );
        modal.style.display = "flex";
        modal2.style.display = "flex";
        $('#edit_answer_container').hide();
        $('.answer_container').show();
    });});

    function edit() {
        $.ajax({
            type: "PATCH",
            url: "{{ route('forum.thread.answer.update', 4) }}",
            data: $("#edit_form").serialize(),
            success : function (data ) {
                answer.html(data);
            }
        });
    }
</script>
@endsection
