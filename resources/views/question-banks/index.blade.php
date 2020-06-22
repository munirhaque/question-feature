@extends('layouts.master')
@section('section-title')
    QUESTIONS BANK MANAGEMENT
    <a href="{{route('questions-banks.new')}}" class="btn btn-primary float-right"><span><i class="fas fa-plus-square"></i></span> ADD QUESTION BANK</a>
@endsection
@section('main-content')
    @include('layouts.partials.alerts')
    <table id="questions_table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Question</th>
            <th>Number of Question</th>
            <th>Duration</th>
            <th>Manage</th>
            <th>Question List</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($question_banks as $question_bank)
            <tr>
                <td>{{$loop->iteration}} </td>
                <td>{{$question_bank->title}}</td>
                <td>{{$question_bank->number_of_question}}</td>
                <td>{{$question_bank->duration}}</td>
                <td><a href="{{route('questions-banks.manage',$question_bank->id)}}" class="btn btn-primary">
                        <span><i class="fas fa-cogs"></i></span> MANAGE
                    </a>
                </td>
                <td><a href="{{route('questions-banks.questions',$question_bank->id)}}" class="btn btn-primary">
                        <span><i class="fas fa-file-alt"></i></span> Question List
                    </a>
                </td>
                <td><a href="#" class="btn btn-danger delete-question" data-toggle="modal" data-target="#delete_question_modal" data-id="#"><span><i class="fas fa-trash-alt"></i></span> DELETE</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>S/N</th>
            <th>Question</th>
            <th>Number of Question</th>
            <th>Duration</th>
            <th>Manage</th>
            <th>Question List</th>
            <th>Delete</th>
        </tr>
        </tfoot>
    </table>

@endsection

@section('extra-scripts')
    <script>
        $(document).ready( function () {
            $('#questions_table').DataTable();

           /* $(document).on("click", ".delete-question", function () {
                var question_id = $(this).data('id');
                $(".modal-body #question_id").val(question_id);

            });*/
        } );
    </script>
@endsection
