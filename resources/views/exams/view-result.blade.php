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
            <th>Student Name</th>
            <th>Mark</th>
            <th>Exam Taken Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($exameens as $exameen)
            <tr>
                <td>{{$loop->iteration}} </td>
                <td>{{$exameen->exam->exam_name}}</td>
                <td>{{$exameen->student->name}}</td>
                <td>{{$exameen->mark}}</td>
                <td>{{$exameen->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>S/N</th>
            <th>Exam Name</th>
            <th>Student Name</th>
            <th>Mark</th>
            <th>Exam Taken Date</th>
        </tr>
        </tfoot>
    </table>
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
