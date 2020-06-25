@extends('layouts.master')
@section('section-title')
    QUESTIONS LIST
@endsection
@section('main-content')
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" class="btn btn-primary" href="#show_answer">Show Answer</a></li>
        <li><a data-toggle="tab" class="btn btn-primary" href="#hide_answer">Hide Answer</a></li>
    </ul>
    <div class="tab-content">
        <div id="show_answer" class="tab-pane fade active">
        @foreach($questions as $question)
            <p>{{$loop->iteration}}
                {{$question->question->title}}.
            </p>
            <ol>
                @foreach($question->question->option as $option)
                    <li style="list-style-type: lower-alpha;">
                        {{$option->title}}
                        @if($option->is_answer == 1)
                            <b>(Answer)</b>
                        @endif
                        <br/>
                    </li>
                @endforeach
            </ol>
        @endforeach
        </div>

        <div id="hide_answer" class="tab-pane fade">
            @foreach($questions as $question)
                <p>{{$loop->iteration}}
                    {{$question->question->title}}.
                </p>
                <ol>
                    @foreach($question->question->option as $option)
                        <li style="list-style-type: lower-alpha;">
                            {{$option->title}}

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
            $('#questions_table').DataTable();


            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }

        } );
    </script>
@endsection
