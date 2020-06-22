@extends('layouts.master')
@section('section-title')
    ADD QUESTION :
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <b>Question Bank Title: {{$question_bank->title}}</b>
    <div class="float-right"><a href="{{route('questions-banks.questions',$question_bank->id)}}" class="btn btn-primary"><span><i class="fas fa-file-alt"></i></span>Question List</a></div>
    <br/>
    <b>Question Limit:</b> {{$question_bank->number_of_question}}
    <br/>
    <b>Question Contain:</b>{{$question_bank->question->count()}}
    {!! Form::open(['route'=>['questions-banks.set-question',$question_bank->id], 'method'=>'post']); !!}
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
            <select name="topic" id="topic" class="form-control border border-warning">
                <option>--- Select Topic ---</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="col-2">
            <label>Total Question:</label>
            <br/>
            <label id="number_of_question">00</label>
        </div>
        <div class="col-2">
            <label>Question Has No Answer:</label>
            <br/>
            <label id="number_of_question">00</label>
        </div>
        <div class="col-2">
            <label>Question Has Single Answer:</label>
            <br/>
            <label id="number_of_question">00</label>
        </div>
        <div class="col-2">
            <label>Question Has Multiple Answer:</label>
            <br/>
            <label id="number_of_question">00</label>
        </div>
        <div class="col-2">
            <label>Add to Bank:</label>
            <br/>
            <input type="number" name="question" id="question" min="0" class="form-control" required="required">
        </div>
        <div class="col-2">
            <label>Add Question:</label>
            <br>
            <button type="submit" class="btn btn-primary"><span><i class="fas fa-save"></i></span>ADD QUESTION</button>
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
            })


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

/*                $.ajax({
                    url:'/questions-banks/number_of_question/subject/'+subject_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // alert(data);
                        $("#number_of_question").empty();
                        $("#number_of_question").text(data);
                        $("#question").prop("max",data);
                    },
                    error:function(){
                        $("#number_of_question").text(0);
                    }
                });*/


            })

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
                        $("#number_of_question").text(data);
                        $("#question").prop("max",data);
                    },
                    error:function(){
                        $("#number_of_question").text(0);
                    }
                });
            });
        });
    </script>
@endsection
