@extends('Admin.app') @section('content')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>



            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

                <h2>Категории <a class="btn btn-dark" href="{{ route('admin.category.create') }}">Добавить</a></h2>
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Количество тестов</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->countTests[0]->total ?? 0 }}</td>
                            <td><a class="btn btn-outline-primary" href="{{ route('admin.category.show',$category->id) }}">Подробнее</a> </td>
                            <td><a class="btn btn-outline-info" href="{{ route('admin.category.edit',$category->id) }}">Редактировать</a></td>
                            <td>
                                {{ Form::open(['method' => 'DELETE', 'route' => ['admin.category.destroy', $category->id]]) }}
                                    <button class="btn btn-outline-danger" onclick="return confirm('Удалить {{ $category->name }} ?')">Удалить</button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
<script>
    $(document).ready(function() {
        $.noConflict();
        $('#example').DataTable();
    } );
</script>
@endsection
