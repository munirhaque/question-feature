@extends('layouts.master')
@section('section-title')
    ADD QUESTION
    <button id="btn-add-option" class="btn btn-info float-right"><span><i class="fas fa-plus-square"></i></span> ADD OPTION</button>
@endsection
@section('main-content')
    {!! Form::open(['route'=>['questions.save',[$class, $subject]], 'method'=>'post']); !!}
        <div id="question-form">
            <div class="form-group">
                <label>Question:</label>
                    <input type="text" class="col-md-10 form-control" name="question">
            </div>
            <div class="form-group">
                <label>Chapter:</label>
                <select name="chapter" id="chapter" class="col-md-10 form-control">
                    @foreach($chapters as $chapter)
                        <option value="{{$chapter->id}}">{{$chapter->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Topic:</label>
                <select name="topic" id="topic" class="col-md-10 form-control">
                    <option>--- Select Topic ---</option>
                    {{--@foreach($topics as $topic)
                        <option value="{{$topic->id}}">{{$topic->title}}</option>
                    @endforeach--}}
                </select>
            </div>
            <div class="form-group">
                <label>Option:</label>
                <div class="form-group">
                    <input type="text" class="col-md-10 form-control" name="option[]">
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <input type="text" class="col-md-10 form-control" name="option[]">
                </div>
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
    $(document).ready(function() {
        $('#example').DataTable();

        $("#btn-add-option").click(function(){
            $("#question-form").append("<div class='form-group'><input type='text' class='col-md-10 form-control' name='option[]'> </div>");
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
    });
</script>
@endsection
