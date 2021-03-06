@extends('layouts.master')
@section('section-title')
    EXAMS MANAGEMENT
    <a href="{{route('exams.new')}}" class="btn btn-primary float-right"><span><i class="fas fa-plus-square"></i></span> ADD EXAM</a>
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <table id="questions_table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Exam Name</th>
            <th>Category</th>
            <th>Start</th>
            <th>End</th>
            <th>Take Exam</th>
        </tr>
        </thead>
        <tbody>
        @foreach($exams as $exam)
            <tr>
                <td>{{$loop->iteration}} </td>
                <td>{{$exam->exam->exam_name}}</td>
                <td>{{$exam->exam->exam_category->category_name}}</td>
                <td>{{$exam->exam->starts}}</td>
                <td>{{$exam->exam->ends}}</td>
                <td><a href="{{route('student-exams.questions',$exam->exam->id)}}" class="btn btn-primary {{$exam->student_id == $student->id?'disabled':''}}"><span class="fas fa-file-alt"></span>Take Exam</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>S/N</th>
            <th>Exam Name</th>
            <th>Category</th>
            <th>Start</th>
            <th>End</th>
            <th>Take Exam</th>
        </tr>
        </tfoot>
    </table>

    <!-- Modal -->
    <div id="delete_exam_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"> Delete Question</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'delete','route' => ['exams.remove']]) !!}
                    <input type="text" name="exam_id" id="exam_id" value="" hidden="hidden" />
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
                var exam_id = $(this).data('id');
                $(".modal-body #exam_id").val(exam_id);

            });
        } );
    </script>
@endsection
