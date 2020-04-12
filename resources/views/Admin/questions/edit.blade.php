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
        {{ Breadcrumbs::render('question.edit',$question) }}
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.question.update',$question->id]]) }}
        <h2>Вопрос</h2>
        {!! Form::hidden('question',null, ['class' => 'form-control', 'id' => 'description']) !!}
        <trix-editor input="description"></trix-editor>
        <h2>Баллов за ответ</h2>
        {!! Form::number('points',$question->points, ['class' => '','min' => '5']) !!} баллов
        <div class="w-100"></div>
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success  btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>


    <script>
        document.addEventListener('DOMContentLoaded', ()=> {
            let contentEl = document.querySelector('[name="content"]');
            let editorEl = document.querySelector('trix-editor');
            editorEl.editor.insertHTML('{!! $question->question_body !!}');
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


    @include('Admin.layouts.sidebar.sidebar')

    </html>
