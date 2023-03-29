@extends('layouts.admin.admin')

@section('content-title', 'Perhitungan')

@section('content-body')
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Perhitungan - SAW</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Karyawan</th>
                            <th class="col-2">Email</th>
                            <th class="col-2">No Telp</th>
                            <th class="col-2">Nilai</th>
                            <th class="col-2">Ranking</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employeesSAW as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->simple_additive_weighting['result'] }}</td>
                                <td>
                                    <span class="badge badge-primary">Rank {{ $loop->iteration }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Perhitungan - Moora</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Karyawan</th>
                            <th class="col-2">Email</th>
                            <th class="col-2">No Telp</th>
                            <th class="col-2">Nilai</th>
                            <th class="col-2">Ranking</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employeesMoora as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->moora['result'] }}</td>
                                <td>
                                    <span class="badge badge-primary">Rank {{ $loop->iteration }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
