@extends('backend::layouts.app')

<?php
    $method = 'POST';
    $formAction = route('backend.patients.store');

    if ($action=='edit') {
        $method = 'PUT';
        $formAction = route('backend.patients.update', $patient->id);
    }

    $formOptions = [
        'id' => 'edit-form',
        'url' => $formAction,
        'method' => $method
    ];
?>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($patient, $formOptions) !!}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1>Patient</h1>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::text('name', 'Name', null, ['required']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::email('email', 'E-mail', null, ['required']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::number('cpf', 'CPF', null, ['required', 'placeholder' => 'numbers only']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <button class="btn btn-success">{{ $action=='edit' ? 'Update' : 'Create' }}</button>
                            <a href="{{ route('backend.patients.index') }}" class="btn">cancel</a>
                        </div>

                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection