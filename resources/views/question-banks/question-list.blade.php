@extends('layouts.master')
@section('section-title')
    QUESTIONS List
@endsection
@section('main-content')
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

@endsection

@section('extra-scripts')
    <script>
        $(document).ready( function () {
            $('#questions_table').DataTable();

            /* $(document).on("click", ".delete-question", function () {
                 var question_id = $(this).data('id');
                 $(".modal-body #question_id").val(question_id);

             });*/
        } );
    </script>
@endsection
