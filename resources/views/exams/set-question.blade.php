@extends('layouts.master')
@section('section-title')
    ADD QUESTION :
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <b>Exam Title: {{$exam->exam_name}}</b>
    <div class="float-right"><a href="{{route('exams.questions',$exam->id)}}" class="btn btn-primary"><span><i class="fas fa-file-alt"></i></span>Question List</a></div>
    <br/>
    <b>Exam Question Limit:</b> {{$exam->number_of_question}}
    <br/>
    <b>Exam Duration:</b> {{$exam->duration}} min
    <br/>
    <b>Question Exists:</b>{{$exam->question->count()}}

    {!! Form::open(['route'=>['exams.set-question',$exam->id], 'method'=>'post']); !!}
    <div class="form-row">
        <div class="col-3">
            <label>Class:</label>
            <select name="class" id="class" class="form-control border border-success">
                <option>--Select Class</option>
                @foreach($classes as $class)
                    <option value="{{$class->id}}">{{$class->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label>Subject:</label>
            <select name="subject" id="subject" class="form-control border border-primary">
                <option>--- Select Subject ---</option>
            </select>
        </div>
        <div class="col">
            <label>Chapter:</label>
            <select name="chapter" id="chapter" class="form-control border border-danger">
                <option>--- Select Chapter ---</option>
            </select>
        </div>
        <div class="col">
            <label>Topic:</label>
            <select name="topic" id="topic" class="form-control border border-success">
                <option>--- Select Topic ---</option>
            </select>
        </div>
    </div>
    <div class="form-row question_amount">
        <div class="col-3">
            <label class="text-primary">Total Question:</label>
            <label id="number_of_question">00</label>
        </div>
        <div class="col-3">
            <label class="text-success">Question Has No Answer:</label>
            <label id="number_of_no_answer">00</label>
        </div>
        <div class="col-3">
            <label class="text-danger">Question Has Single Answer:</label>
            <label id="number_of_single_answer">00</label>
        </div>
        <div class="col-3">
            <label class="text-success">Question Has Multiple Answer:</label>
            <label id="number_of_multiple_answer">00</label>
        </div>
    </div>
    <div class="form-row answer-type">
        <div class="col-3">
            <input type="radio" class="form-check-input" id="any_question" name="answer_type" value="any" disabled="disabled" required>Any Questions
            <br/>
            <input type="radio" class="form-check-input" id="has_no_answer" name="answer_type" value="has_no_answer" disabled="disabled">Add Questions Has No Answer
            <br/>
            <input type="radio" class="form-check-input" id="has_one_answer" name="answer_type" value="has_one_answer" disabled="disabled">Add Questions Has One Answer
            <br/>
            <input type="radio" class="form-check-input" id="has_multiple_answer" name="answer_type" value="has_multiple_answer" disabled="disabled"> Add Questions Has Multiple Answer
        </div>
    </div>
    <div class="form-row add-to-question-bank">
        <div class="col-2">
            <input type="number" name="question" id="question" min="0" class="form-control" required="required" placeholder="Enter Number of Question" disabled="disabled">
            <br/>
            <button type="submit" id="btn-submit" class="btn btn-primary btn-block" disabled="disabled"><span><i class="fas fa-save"></i></span>ADD QUESTION</button>
        </div>
    </div>
    {!! Form::close() !!}


@endsection

@section('extra-scripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            $("#class").change(function(){
                let class_id = $('#class').val();
                $.ajax({
                    url:'/questions/get_subject/'+class_id,
                    type: 'GET',
                    dataType: 'json',

                    success: function (data) {
                        if(data.length == 0){
                            $("#subject").empty();
                            $("#subject").append('<option>--No Chapter Available--</option>');
                        }else{
                            $("#subject").empty();
                            $("#subject").append('<option>--- Select Subject ---</option>');
                            for(let count=0; count < data.length; count++){
                                $("#subject").append('<option value="'+data[count].subject_id+'">'+ data[count].subject.title+'</option>');
                            }
                        }
                    },
                    error:function(){
                        $("#chapter").append('<option>--Select Subject</option>');
                    }

                });
            });


            $("#subject").change(function(){
                let subject_id = $('#subject').val();
                $.ajax({
                    url:'/questions-banks/chapter/'+subject_id,
                    type: 'GET',
                    dataType: 'json',

                    success: function (data) {
                        if(data.length == 0){
                            $("#chapter").append('<option>--No Chapter Available--</option>');
                        }else{
                            $("#chapter").empty();
                            $("#chapter").append('<option>--- Select Chapter ---</option>');
                            for(let count=0; count < data.length; count++){
                                $("#chapter").append('<option value="'+data[count].id+'">'+ data[count].title+'</option>');
                            }
                        }
                    },
                    error:function(){
                        $("#chapter").append('<option>--Please Select Chapter</option>');
                    }
                });
            });

            $("#chapter").change(function(){
                let chapter_id = $('#chapter').val();
                $.ajax({
                    url:'/questions-banks/topic/'+chapter_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {


                        if(data.length == 0){
                            $("#topic").append('<option>--No Topic Available--</option>');
                        }else{
                            $("#topic").empty();
                            $("#topic").append('<option>--- Select Topic ---</option>');
                            for(let count=0; count < data.length; count++){
                                $("#topic").append('<option value="'+data[count].id+'">'+ data[count].title+'</option>');
                            }
                        }
                    },
                    error:function(){
                        $("#topic").append('<option>--Please Select Topic</option>');
                    }
                });
            });

            $("#topic").change(function(){
                let topic_id = $('#topic').val();
                // alert(topic_id);
                $.ajax({
                    url:'/questions-banks/number_of_question/'+topic_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // alert(data);
                        $("#number_of_question").empty();
                        $("#number_of_question").text(data[0]);
                        $('#number_of_no_answer').text(data[1]);
                        $('#number_of_single_answer').text(data[2]);
                        $('#number_of_multiple_answer').text(data[3]);

                        $("#question").prop("max",data[0]);

                        if (data[0] > 0){
                            $("#any_question").attr('disabled', false);
                            $("#question").attr('disabled',false);
                            $("#btn-submit").attr('disabled',false);
                        }else{
                            $("#any_question").attr('disabled', true);
                            $("#question").attr('disabled',true);
                            $("#btn-submit").attr('disabled',true);
                        }

                        if (data[1] > 0) {
                            $("#has_no_answer").attr('disabled', false);
                        }else{
                            $("#has_no_answer").attr('disabled', true);
                        }
                        if (data[2] > 0){
                            $("#has_one_answer").attr('disabled', false);
                        }else{
                            $("#has_one_answer").attr('disabled', true);
                        }
                        if(data[3] > 0){
                            $("#has_multiple_answer").attr('disabled', false);
                        }else{
                            $("#has_multiple_answer").attr('disabled', true);
                        }



                    },
                    error:function(){
                        $("#number_of_question").text(0);
                    }
                });
            });

            $("#any_question").change(function () {
                var number_of_question = $("#number_of_question").text();
                $("#question").val("");
                $("#question").prop("max",number_of_question);
            });

            $("#has_no_answer").change(function () {
                var number_of_no_answer = $("#number_of_no_answer").text();
                $("#question").val("");
                $("#question").prop("max",number_of_no_answer);
            });

            $("#has_one_answer").change(function () {
                var number_of_single_answer = $("#number_of_single_answer").text();
                $("#question").val("");
                $("#question").prop("max",number_of_single_answer);
            });

            $("#has_multiple_answer").change(function () {
                var number_of_multiple_answer = $("#number_of_multiple_answer").text();
                $("#question").val("");
                $("#question").prop("max",number_of_multiple_answer);
            });


        });
    </script>
@endsection
