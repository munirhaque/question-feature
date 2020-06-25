@extends('layouts.master')
@section('section-title')
    CREATE EXAM
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <div id="exam-create-form">
        {!! Form::model($exam,['method'=>$exam->exists?'put':'post',
                        'route'=>$exam->exists?['exams.update',$exam->id]:['exams.save']]) !!}
            <div class="form-group">
                {!! Form::label('Exam Title') !!}
                {!! Form::text('exam_name',null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Exam Category') !!}
                <select class="form-control col-3" name="category">
                    <option>-- Select Exam Category --</option>
                    @foreach($categories as $category){
                        @if($exam->exists)
                        <option value="{{$category->id}}" {{$exam->exam_category_id ==$category->id ? 'selected':''}}>{{$category->category_name}}</option>
                    @else
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                    @endif
                        }
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('Exam Start Date') !!}
                {!! Form::date('start_date',$exam->exists? explode(" ",$exam->starts)[0] :null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Exam Start Time') !!}
                {!! Form::time('start_time',$exam->exists? explode(" ",$exam->starts)[1] :null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Exam End Date') !!}
                {!! Form::date('end_date',$exam->exists? explode(" ",$exam->ends)[0] :null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Exam End Time') !!}
                {!! Form::time('end_time',$exam->exists? explode(" ",$exam->ends)[1] :null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Exam Duration(miin)') !!}
                {!! Form::number('duration',null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Number of Question') !!}
                {!! Form::number('number_of_question',null,['class'=>'form-control col-3']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit($exam->exists?'EDIT':'CREATE EXAM',['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection

@section('extra-scripts')
    <script>
        $(document).ready( function () {
            $('#questions_table').DataTable();

            $(document).on("click", ".delete-question", function () {
                var question_id = $(this).data('id');
                $(".modal-body #question_id").val(question_id);

            });
        } );
    </script>
@endsection
