@extends('backend::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Schedules <small>({{ $total }})</small></h1>
                        <span class="pull-right actions">
                            <a href="{{ route('backend.schedules.create') }}" class="btn btn-lg btn-success">new</a>
                        </span>
                    </div>

                    <div class="panel-body">
                        <form method="POST" id="list">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">#</th>
                                        <th>Doctor</th>
                                        <th>Patient</th>
                                        <th>When</th>
                                        <th style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->id }}</td>
                                            <td><a href="{{ route('backend.schedules.edit', $schedule->id) }}">{{ $schedule->doctor_name }}</a></td>
                                            <td><a href="{{ route('backend.schedules.edit', $schedule->id) }}">{{ $schedule->patient_name }}</a></td>
                                            <td><a href="{{ route('backend.schedules.edit', $schedule->id) }}">{{ $schedule->date->format('d/m/Y') }} at {{ $schedule->date->format('H:i') }}</a></td>
                                            <td>
                                                <a href="{{ route('backend.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-default">edit</a>
                                                <a href="{{ route('backend.schedules.destroy', $schedule->id) }}"
                                                   title="Schedule of patient {{ $schedule->patient_name }} with doctor {{ $schedule->doctor_name }}"
                                                   class="delete btn btn-sm btn-danger">delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>

                        <div class="text-center">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection