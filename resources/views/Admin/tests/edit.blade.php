<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DashBoard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" rel="stylesheet">

</head>
<body>
@include('Admin.layouts.navbar.navbar')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Breadcrumbs::render('tests.edit',$test) }}
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.test.update',$test->id]]) }}
        <h2>Название теста</h2>
        {!! Form::text('name', $test->name, ['class' => 'form-control']) !!}
        <h2>Категория теста</h2>
        {!! Form::select('category_id',$categories,
               $test->difficulty, ['class' => 'form-control','min' => '5']) !!}
        <input id="emailTemplate" type="hidden" name="description" value='' />
{{--        {{ Form::hidden('description', $test->description, ['class' => 'form-control', 'id' => 'emailTemplate']) }}--}}
        <h2>Описание теста</h2>
        <trix-toolbar id="my_toolbar"></trix-toolbar>
        <trix-editor toolbar="my_toolbar" input="emailTemplate"></trix-editor>
        <h2>Время на выполнение</h2>
        {!! Form::number('max_time',$test->max_time, ['class' => '','min' => '5']) !!} минут
        <h2>Сложность</h2>
        {!! Form::select('difficulty',
                ['1' => 'Начинающий','2' => 'Ученик', '3' => 'Знаток','4' => 'Профессионал','5' => 'Эксперт'],
                $test->difficulty, ['class' => 'form-control','min' => '5']) !!}
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success btn-lg mt-4']) }}
        {{ Form::close() }}
        @if ($errors->any())
        <div class="">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', ()=> {
            let contentEl = document.querySelector('[name="content"]');
            let editorEl = document.querySelector('trix-editor');
            editorEl.editor.insertHTML('{!! $test->description !!}');
        });

            addEventListener("trix-attachment-add", function(event) {
            if (event.attachment.file) {
                uploadFileAttachment(event.attachment)
            }
        })

        function uploadFileAttachment(attachment) {
            handleAttachmentChanges(attachment);
        }

        function remove(event) {
            console.log(event.attachment);
            let file = event.attachment.attachment.attributes.values.href;
            axios.post('http://onlinetests/api/file/delete',JSON.stringify([file]))
        }

        function handleAttachmentChanges(event) {
            let file = event.attachment.file;
            let key = this.createStorageKey(file);
            let formData = this.createFormData(key, file);

            $.ajax({
                type: "POST",
                beforeSend: function(request) {
                    request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
                },
                url: '{{ route('img.upload') }}',
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                if (response != false) {
                    let imgPath = response;
                    let attributes = {
                        url: "https://onlinetests1.s3.us-east-2.amazonaws.com/" + imgPath,
                        href:  imgPath,
                    };
                    event.attachment.setAttributes(attributes);
                }
            },
            });
        }
        function createStorageKey(file) {
            var date = new Date();
            var day = date.toISOString().slice(0, 10);
            var name = date.getTime() + "-" + file.name;
            return ["tmp", day, name].join("/");
        }

        function createFormData(key, file) {
            var data = new FormData();
            data.append("key", key);
            data.append("Content-Type", file.type);
            data.append("file", file);
            return data;
        }





    </script>
</body>

@include('Admin.layouts.sidebar.sidebar')

</html>
