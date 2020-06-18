@extends('layouts.master')
@section('section-title')Questions Management @endsection
@section('main-content')

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::open(['route'=>'questions.manage', 'method'=>'get']) !!}
            <label>Select Class</label>
            <select name="class" id="class" class="form-control">
                @foreach($classes as $class)
                    <option value="{{$class->id}}">{{$class->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>Select Subject</label>
            <select name="subject" id="subject" class="form-control">

                @foreach($subjects as $subject)
                    <option value="{{$subject->id}}">{{$subject->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Manage</label><br>
            <button type="submit" class="btn btn-primary"><span><i class="fas fa-cogs"></i></span> MANAGE</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection

@section('extra-scripts')
<script>
   /* $("#class").change(function(){
        let class_id = $('#class').val();
        $.ajax({
            url:'/questions/get_subject/'+class_id,
            type: 'GET',
            dataType: 'json',

            success: function (data) {
                  alert(data[0].title);


                if(data.length == 0){
                    $("#subject").append('<option>--No Chapter Available--</option>');
                }else{
                    $("#subject").empty();
                    $("#subject").append('<option>--- Select Chapter ---</option>');
                    for(let count=0; count < data.length; count++){
                        $("#subject").append('<option value="'+data[count].id+'">'+ data[count].title+'</option>');
                    }
                }
            },
            error:function(){
                $("#chapter").append('<option>--Please Select Chapter</option>');
            }

        });
    })*/
</script>
@endsection
