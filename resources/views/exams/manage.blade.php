@extends('layouts.master')
@section('section-title')
    ADD QUESTION :
@endsection
@section('main-content')
    @include('layouts.partials.alerts')

    {!! Form::open(['route'=>['exams.save-manage',$exam->id], 'method'=>'post']); !!}
    <div class="form-group">
        <label>Section:</label>
        <select name="section" id="section" class="form-control col-2 border border-primary">
            <option>--- Select Section ---</option>
            @foreach($sections as $section)
                <option value="{{$section->id}}">{{$section->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Group:</label>
        <select name="group" id="group" class="form-control col-2 border border-primary">
            <option>--- Select Subject ---</option>
            @foreach($groups as $group)
                <option value="{{$group->id}}">{{$group->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-row add-to-question-bank">
        <div class="col-2">
            <button type="submit" id="btn-submit" class="btn btn-primary btn-block"><span><i class="fas fa-save"></i></span> SAVE</button>
        </div>
    </div>
    {!! Form::close() !!}


@endsection


