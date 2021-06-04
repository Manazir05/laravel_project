@extends('layouts.app')



@section('content')

<h2>Create Post</h2>

<!-- <form action="/edwin_laravel/myProject/public/posts" method="POST"> -->

<!-- {!! Form::open(['url' => '/posts']) !!} -->

{!! Form::open(['action' => 'PostController@store', 'files'=>true ]) !!}

@csrf
    
    <div class="form-group">

        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title' ,null, ['class'=>'form-control']) !!}

        {!! Form::label('title', 'content') !!}
        {!! Form::textarea('content' ,null, ['class'=>'form-control']) !!}

    </div>

    <div class="form-group">
        {!! Form::file('dfile' , ['class'=>'form-control']) !!}
    </div>


    <div class="form-group">
    
        {!! Form::hidden('user_id', '1') !!}
        {!! Form::submit('Create' , ['class'=>'btn btn-primary']) !!}

    </div>

{!! Form::close() !!}

@if(count($errors) > 0)


<div class="alert alert-danger">
<ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
</ul>
</div>
    

@endif







@endsection