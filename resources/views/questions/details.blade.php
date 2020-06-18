@extends('layouts.master')
@section('section-title')
    QUESTION DETAILS
@endsection
@section('main-content')
    <p><b> Question</b>: {{$question->title}}</p>
    <p>Options:
        @foreach($options as $option)
            <br/>
            {{$loop->iteration}}.{{$option->title}}
            @if($option->is_answer == 1)
                <b>(Answer)</b>
            @endif
        @endforeach
    </p>

@endsection


