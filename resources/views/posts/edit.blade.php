@extends('layouts.app')



@section('content')

<h2>Edit Post</h2>

<!-- <form action="/edwin_laravel/myProject/public/posts/{{$post->id}}" method="POST"> -->

{!! Form::model($post, ['action' => ['PostController@update', $post->id], 'method'=>'Patch'] ) !!}
@csrf 

<div class="form-group">

{!! Form::label('title', 'Title') !!}
{!! Form::text('title' ,null, ['class'=>'form-control']) !!}

{!! Form::label('title', 'content') !!}
{!! Form::textarea('content' ,null, ['class'=>'form-control']) !!}

</div>


<div class="form-group">

{!! Form::submit('Update' , ['class'=>'btn btn-success']) !!}

</div>

{!! Form::close() !!}


{!! Form::model($post, ['action' => ['PostController@destroy', $post->id], 'method'=>'DELETE'] ) !!}
@csrf <!-- {{ csrf_field() }} -->

{!! Form::submit('Delete' , ['class'=>'btn btn-danger']) !!}

{!! Form::close() !!}



@endsection