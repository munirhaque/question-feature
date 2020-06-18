@extends('layouts.master')
@section('section-title')
    ADD QUESTION
    <button id="btn-add-option" class="btn btn-info float-right"><span><i class="fas fa-plus-square"></i></span> ADD OPTION</button>
@endsection
@section('main-content')
    @include('layouts.partials.errors')
    {!! Form::open(['route'=>'questions.save_upload','method'=>'post','enctype' => 'multipart/form-data']); !!}
    <div id="question-form">
        <div class="form-group">
            <label>Select Chapter:</label>
            <select name="chapter" class="form-control">
                @foreach($chapters as $chapter)
                    <option value="{{$chapter->id}}">{{$chapter->serial_no}}:{{$chapter->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Select Topic:</label>
            <select name="topic" class="form-control">
                @foreach($topics as $topic)
                    <option value="{{$topic->id}}">{{$topic->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Excel File:</label>
            {!! Form::file('question_file',['required'=>'required']) !!}
            {{--<input type="file" name="question_file" required="required">--}}
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <button type="submit" class="btn btn-primary"><span><i class="fas fa-save"></i></span>SAVE</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection


