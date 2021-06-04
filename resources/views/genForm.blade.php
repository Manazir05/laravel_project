@extends('layouts.app')

	@section('content')

	<div class="content">
        <div class="title m-b-md">
            Auto[]Form
        </div>

        <div class="row">
            <form action="" method="post">
                <select name="select_element" id="select_element">
                    <option value="1">Input Text</option>
                    <option value="2">Select</option>
                    <option value="3">Textarea</option>
                </select>
            </form>
        </div>

        <div class="row">
            <form action="" method='post'>
                <select name="" id="">
                </select>
            </form>
        </div>
        
    </div>
        


@stop
