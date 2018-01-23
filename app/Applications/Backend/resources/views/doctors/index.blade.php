@extends('backend::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Doctors <small>({{ $total }})</small></h1>
                        <span class="pull-right actions">
                            <a href="{{ route('backend.doctors.create') }}" class="btn btn-lg btn-success">new</a>
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
                                        <th style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->id }}</td>
                                            <td><a href="{{ route('backend.doctors.edit', $doctor->id) }}">{{ $doctor->name }}</a></td>
                                            <td>
                                                <a href="{{ route('backend.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-default">edit</a>
                                                <a href="{{ route('backend.doctors.destroy', $doctor->id) }}" title="{{ $doctor->name }}" class="delete btn btn-sm btn-danger">delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>

                        <div class="text-center">
                            {{ $doctors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection