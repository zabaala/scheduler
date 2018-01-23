@extends('backend::layouts.app')

<?php
    $method = 'POST';
    $formAction = route('backend.schedules.store');
    $date = null;
    $hour = null;

    if ($action=='edit') {
        $method = 'PUT';
        $formAction = route('backend.schedules.update', $schedule->id);
        $date = $schedule->date->format('d/m/Y');
        $hour = $schedule->date->format('H:i');
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
                {!! Form::model($schedule, $formOptions) !!}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1>Patient</h1>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        {!! Form::select('status', 'Status', $availableStatus, null, ['required']) !!}
                                    </div>
                                    <div class="col-md-offset-3 col-md-3">
                                        {!! Form::text('date', 'Date', $date, ['required', 'placeholder' => 'dd/mm/yyyy']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::text('hour', 'Hour', $hour, ['required', 'placeholder' => 'hh:mm']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::select('patient_id', 'Patient', $patients, null, ['required']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::select('doctor_id', 'Doctor', $doctors, null, ['required']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::textarea('message', 'Message') !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <button class="btn btn-success">{{ $action=='edit' ? 'Update' : 'Create' }}</button>
                            <a href="{{ route('backend.schedules.index') }}" class="btn">cancel</a>
                        </div>

                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection