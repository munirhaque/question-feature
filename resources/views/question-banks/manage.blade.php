@extends('layouts.master')
@section('section-title')
    ADD QUESTION :
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <b>{{$question_bank->title}}</b>
    <br/>
    <b>Question Limit:</b> {{$question_bank->number_of_question}}
    <br/>
    <b>Question:</b>{{$question_bank->question->count()}}
    {!! Form::open(['route'=>['questions-banks.set-question',$question_bank->id], 'method'=>'post']); !!}
    <div class="form-row">
        <div class="col">
            <label>Subject:</label>
            <select name="subject" id="subject" class="form-control">
                <option>--- Select Subject ---</option>
                @foreach($class_subjects as $class_subject)
                    <option value="{{$class_subject->subject->id}}">{{$class_subject->subject->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label>Chapter:</label>
            <select name="chapter" id="chapter" class="form-control">
                <option>--- Select Chapter ---</option>
            </select>
        </div>
        <div class="col">
            <label>Topic:</label>
            <select name="topic" id="topic" class="form-control">
                <option>--- Select Topic ---</option>
            </select>
        </div>
        <div class="col">
            <label>Total Question:</label>
            <br/>
            <label id="number_of_question">00</label>
        </div>
        <div class="col">
            <label>Add to Bank:</label>
            <br/>
            <input type="number" name="question" id="question" min="0" class="form-control" required="required">
        </div>
        <div class="col">
            <label>Add Question:</label>
            <br>
            <button type="submit" class="btn btn-primary"><span><i class="fas fa-save"></i></span>ADD QUESTION</button>
        </div>
    </div>


    {!! Form::close() !!}

    {{--<table id="questions_table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Subject</th>
            <th>Chapter</th>
            <th>Topic</th>
            <th>Question</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($question_bank_questions as $question_bank_question)
            <tr>
                <td>{{$loop->iteration}} </td>
                <td>{{$question_bank_question->question->subject->title}}</td>
                <td>{{$question_bank_question->question->chapter->title}}</td>
                <td>{{$question_bank_question->question->topic->title}}</td>
                <td><a href="#" class="btn btn-primary">
                        <span><i class="fas fa-cogs"></i></span> MANAGE
                    </a>
                </td>
                <td><a href="#" class="btn btn-danger delete-question" data-toggle="modal" data-target="#delete_question_modal" data-id="#"><span><i class="fas fa-trash-alt"></i></span> DELETE</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>S/N</th>
            <th>Subject</th>
            <th>Chapter</th>
            <th>Topic</th>
            <th>Question</th>
            <th>Delete</th>
        </tr>
        </tfoot>
    </table>--}}
@endsection

@section('extra-scripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

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
