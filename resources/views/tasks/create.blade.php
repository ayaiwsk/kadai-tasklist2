@extends('layouts.app')
 <!--app.blade.php内の@yield('content')に当てはまる詳細部分を記載-->
@section('content')
<h1>タスク新規作成ページ</h1>

    <div class="row">
        <div class="col-6">
            
            <!--のstoreの内容を使う-->
            {!! Form::model($task, ['route' => 'tasks.store']) !!}
        
                 <div class="form-group">
                    {!! Form::label('status', 'ステータス:') !!}
                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                </div>
        
                <div class="form-group">
                    {!! Form::label('content', 'タスク:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit('追加', ['class' => 'btn btn-primary']) !!}
        
        <!--Form::model/Form::close()で<form></form>のような意味-->
            {!! Form::close() !!}
        </div>
    </div>
@endsection
