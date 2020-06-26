@extends('layouts.master')

@section('section-title')
    QUESTIONS LIST
@endsection
@section('main-content')

        <label id="time_count" class="time-count float-right"></label>
        <div id="questions">
            {!! Form::open(['route'=>['student-exams.submit',$exam->id], 'method'=>'post','id'=>'exam_form']) !!}
            @foreach($questions as $question)
                <p>{{$loop->iteration}}
                    {{$question->question->title}}.
                </p>
                <ol>
                    @foreach($question->question->option as $option)

                        <li style="list-style-type: lower-alpha;">
                            <input type="checkbox" name="{{'question_'.$question->question_id.'[]'}}" value="{{$option->id}}"/>
                            {{$option->title}}
                            <br/>
                        </li>
                    @endforeach
                </ol>
            @endforeach
            {!! Form::submit('SUBMIT',['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
@endsection

@section('extra-scripts')
    <script>
        $(document).ready( function () {
            $('#hide_answer').click(function () {
                $('.answer').toggle();
            });

            let exam = {!! json_encode($exam) !!};
            let exam_duration = exam.duration * (60*1000);
            var countDownDate = new Date().getTime() + exam_duration;
            var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            //alert(typeof distance);
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("time_count").innerHTML ='Time Remaining: '+ minutes + "m :" + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("exam_form").submit();
            }

        }, 1000);

            function HandleBackFunctionality()
            {
                if(window.event) //Internet Explorer
                {
                    alert("Browser back button is clicked on Internet Explorer...");
                }
                else //Other browsers for example Chrome
                {
                    alert("Browser back button is clicked on other browser...");
                }
            }

        } );
    </script>
@endsection
