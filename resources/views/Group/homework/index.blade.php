<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

@include('layouts.navbar.navbar')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

        <h2>Домашнее задание для группы "{{ $group->name }}" </h2>
        {{ Form::open(['method' => 'PATCH', 'route' => ['group.homework.update',auth()->user()->group->id]]) }}
        {!! Form::hidden('daily_task', null,['id' => 'daily_task']) !!}
        <trix-editor input="daily_task"></trix-editor>
        {!! Form::submit('Задать дз',['class' => 'btn btn-lg btn-primary w-25 mt-5 mb-5']) !!}
        {!! Form::close() !!}
    </main>

</div>
@include('layouts.footer.footer')

</body>

    <script>
        document.addEventListener('DOMContentLoaded', ()=> {
            let contentEl = document.querySelector('[name="content"]');
            let editorEl = document.querySelector('trix-editor');
            editorEl.editor.insertHTML('{!! $group->daily_task !!}');
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


    </html>












