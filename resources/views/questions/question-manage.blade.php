@extends('layouts.master')
@section('section-title')Questions Management @endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::open(['route'=>['questions.add-question-to-class',$id], 'method'=>'post']) !!}
                <label>Select Class</label>
                <select name="class" id="class" class="form-control">
                    <option>-- Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{$class->id}}">{{$class->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Select Subject</label>
                <select name="subject" id="subject" class="form-control">
                    <option>-- Select Subject--</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Select Chapter</label>
                <select name="chapter" id="chapter" class="form-control">
                    <option>-- Select Chapter--</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Select Topic</label>
                <select name="topic" id="topic" class="form-control">
                    <option>-- Select Topic--</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Manage</label><br>
                <button type="submit" class="btn btn-primary"><span><i class="fas fa-cogs"></i></span> SET QUESTION</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <table id="questions_table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Topic</th>
            <th>Chapter</th>
            <th>Subject</th>
            <th>Class</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{$loop->iteration}} </td>
                <td>{{$question->topic->title}}</td>
                <td>{{$question->chapter->title}}</td>
                <td>{{$question->subject->title}}</td>
                <td>{{$question->class->name}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>S/N</th>
            <th>Topic</th>
            <th>Chapter</th>
            <th>Subject</th>
            <th>Class</th>
        </tr>
        </tfoot>
    </table>
@endsection

@section('extra-scripts')
    <script>
        $(document).ready( function () {
            $('#questions_table').DataTable();

            $("#class").change(function(){
                let class_id = $('#class').val();
                //alert(class_id);
                $.ajax({
                    url:'/questions/get_subject/'+class_id,
                    type: 'GET',
                    dataType: 'json',

                    success: function (data) {
                        // alert(data[0].subject_id);

                        if(data.length == 0){
                            $("#subject").empty();
                            $("#subject").append('<option>--No Chapter Available--</option>');
                        }else{
                            $("#subject").empty();
                            $("#subject").append('<option>--- Select Chapter ---</option>');
                            for(let count=0; count < data.length; count++){
                                $("#subject").append('<option value="'+data[count].subject_id+'">'+ data[count].subject.title+'</option>');
                            }
                        }
                    },
                    error:function(){
                        $("#chapter").append('<option>--Please Select Chapter</option>');
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
            })


            $("#chapter").change(function(){
                let chapter_id = $('#chapter').val();
                $.ajax({
                    url:'/questions-banks/topic/'+chapter_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {


                        if(data.length == 0){
                            $("#topic").empty();
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

        } );


    </script>
@endsection
