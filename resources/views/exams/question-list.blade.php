@extends('layouts.master')

@section('section-title')
    QUESTIONS LIST
@endsection
@section('main-content')
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#set_1" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">SET A</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#set_2" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">SET B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#set_3" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">SET C</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#set_4" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">SET D</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="set_1" class="tab-pane fade show active">
            <br/>
            <button id="hide_answer" class="btn btn-primary float-right"><span><i class="fas fa-eye-slash"></i></span>Show/Hide Answer</button>

            @foreach($questions_set_1 as $question)
                <p>{{$loop->iteration}}
                    {{$question->question->title}}.
                </p>
                <ol>
                    @foreach($question->question->option as $option)
                        <li style="list-style-type: lower-alpha;">
                            {{$option->title}}
                            @if($option->is_answer == 1)
                                <span class="answer"> <b>(Answer)</b></span>
                            @endif
                            <br/>
                        </li>
                    @endforeach
                </ol>
            @endforeach
        </div>

        <div id="set_2" class="tab-pane fade">
            <br/>
            <button id="hide_answer" class="btn btn-primary float-right"><span><i class="fas fa-eye-slash"></i></span>Show/Hide Answer</button>
            @foreach($questions_set_2 as $question)
                <p>{{$loop->iteration}}
                    {{$question->question->title}}.
                </p>
                <ol>
                    @foreach($question->question->option as $option)
                        <li style="list-style-type: lower-alpha;">
                            {{$option->title}}
                            @if($option->is_answer == 1)
                                <span class="answer"> <b>(Answer)</b></span>
                            @endif
                            <br/>
                        </li>
                    @endforeach
                </ol>
            @endforeach
        </div>

        <div id="set_3" class="tab-pane fade">
            <br/>
            <button id="hide_answer" class="btn btn-primary float-right"><span><i class="fas fa-eye-slash"></i></span>Show/Hide Answer</button>
            @foreach($questions_set_3 as $question)
                <p>{{$loop->iteration}}
                    {{$question->question->title}}.
                </p>
                <ol>
                    @foreach($question->question->option as $option)
                        <li style="list-style-type: lower-alpha;">
                            {{$option->title}}
                            @if($option->is_answer == 1)
                                <span class="answer"> <b>(Answer)</b></span>
                            @endif
                            <br/>
                        </li>
                    @endforeach
                </ol>
            @endforeach
        </div>

        <div id="set_4" class="tab-pane fade">
            <br/>
            <button id="hide_answer" class="btn btn-primary float-right"><span><i class="fas fa-eye-slash"></i></span>Show/Hide Answer</button>
            @foreach($questions_set_4 as $question)
                <p>{{$loop->iteration}}
                    {{$question->question->title}}.
                </p>
                <ol>
                    @foreach($question->question->option as $option)
                        <li style="list-style-type: lower-alpha;">
                            {{$option->title}}
                            @if($option->is_answer == 1)
                                <span class="answer"> <b>(Answer)</b></span>
                            @endif
                            <br/>
                        </li>
                    @endforeach
                </ol>
            @endforeach
        </div>



    </div>
@endsection

@section('extra-scripts')
    <script>
        $(document).ready( function () {
            $('#hide_answer').click(function () {
                $('.answer').toggle();
            });
        } );
    </script>
@endsection
