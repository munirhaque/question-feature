@extends('layouts.master')
@section('section-title')
    ADD QUESTION BANK

@endsection
@section('main-content')
    {!! Form::open(['route'=>'questions-banks.save', 'method'=>'post']); !!}
    <div id="question-form">
        <div class="form-group">
            <label>Question Bank Title:</label>
            <input type="text" value="{{$question_bank_id}}" class="form-control" name="title" readonly>
        </div>
        <div class="form-group">
            <label>Class:</label>
            <select name="class" class="form-control">
                @foreach($classes as $class)
                    <option value="{{$class->id}}">{{$class->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Number of Question:</label>
            {!! Form::number('number_of_question', null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Duration:</label>
            {!! Form::number('duration', null,['class'=>'form-control']) !!}
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

            /*$("#btn-add-option").click(function(){
                $("#question-form").append("<div class='form-group row'>  <input type='checkbox' class='col-md-1 form-control' name='answer[]' > <input type='text' class='col-md-10 form-control' name='option[]'> </div>");
            });*/
        });
    </script>
@endsection
