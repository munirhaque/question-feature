@extends('layouts.master')
@section('section-title')
QUESTIONS MANAGEMENT - Subject: {{$subject_info->title}}
<a href="{{--{{route('questions.new')}}--}}" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_question_modal"><span><i class="fas fa-plus-square"></i></span> ADD QUESTION</a>
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <table id="questions_table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Question</th>
            <th>Chapter</th>
            <th>Topic</th>
            <th>Details</th>
            <th>Manage</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{$loop->iteration}} </td>
                <td>{{$question->question->title}}</td>
                <td>{{$question->chapter->title}}</td>
                <td>{{$question->topic->title}}</td>
                <td><a href="{{route('questions.details', $question->question_id)}}" class="btn btn-primary">
                        <span><i class="fas fa-file-alt"></i></span> DETAILS
                    </a>
                </td>
                <td><a href="{{route('questions.question-manage', $question->question_id)}}" class="btn btn-primary">
                        <span><i class="fas fa-cogs"></i></span> Manage
                    </a>
                </td>
                <td><a href="#" class="btn btn-danger delete-question" data-toggle="modal" data-target="#delete_question_modal" data-id="{{$question->id}}"><span><i class="fas fa-trash-alt"></i></span> DELETE</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>S/N</th>
            <th>Question</th>
            <th>Chapter</th>
            <th>Topic</th>
            <th>Details</th>
            <th>Manage</th>
            <th>Delete</th>
        </tr>
        </tfoot>
    </table>

    <!-- Modal -->
    <div id="add_question_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Question Add Options</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <a href="{{route('questions.upload',[$class,$subject])}}" class="btn btn-primary float-left">Upload Question File</a>
                    <a href="{{route('questions.new',[$class,$subject])}}" class="btn btn-primary float-right">Add New Question</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="delete_question_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"> Delete Question</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'delete','route' => ['questions.delete']]) !!}
                    <input type="text" name="question_id" id="question_id" value="" hidden="hidden" />
                    <h5 class="text-danger">Do You Really Want to Delete</h5>
                    {!! Form::submit("Delete", ['class'=>'btn btn-outline-danger']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
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
