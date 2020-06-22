@extends('layouts.master')
@section('section-title')
    ADD QUESTION
@endsection
@section('main-content')
    @include('layouts.partials.errors')
    {!! Form::open(['route'=>'questions.save_upload','method'=>'post','enctype' => 'multipart/form-data']); !!}
    <div id="question-form">
        <div class="form-group">
            <label>Select Chapter:</label>
            <select name="chapter" id="chapter" class="form-control">
                <option>-- Select Chapter--</option>
                @foreach($chapters as $chapter)
                    <option value="{{$chapter->id}}">{{$chapter->serial_no}}:{{$chapter->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Select Topic:</label>
            <select name="topic" id="topic" class="form-control">
                {{--@foreach($topics as $topic)
                    <option value="{{$topic->id}}">{{$topic->title}}</option>
                @endforeach--}}
            </select>
        </div>
        <div class="form-group">
            <label>Excel File:</label>
            {!! Form::file('question_file',['required'=>'required']) !!}
            {{--<input type="file" name="question_file" required="required">--}}
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <button type="submit" class="btn btn-primary"><span><i class="fas fa-save"></i></span>SAVE</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('extra-scripts')
<script>
    $(document).ready( function () {
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
    })

</script>
@endsection
