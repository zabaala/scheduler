@extends('backend::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Patients <small>({{ $total }})</small></h1>
                        <span class="pull-right actions">
                            <a href="{{ route('backend.patients.create') }}" class="btn btn-lg btn-success">new</a>
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
                                        <th>Patient</th>
                                        <th style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $patient)
                                        <tr>
                                            <td>{{ $patient->id }}</td>
                                            <td><a href="{{ route('backend.patients.edit', $patient->id) }}">{{ $patient->name }}</a></td>
                                            <td>
                                                <a href="{{ route('backend.patients.edit', $patient->id) }}" class="btn btn-sm btn-default">edit</a>
                                                <a href="{{ route('backend.patients.destroy', $patient->id) }}" title="{{ $patient->name }}" class="delete btn btn-sm btn-danger">delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>

                        <div class="text-center">
                            {{ $patients->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection