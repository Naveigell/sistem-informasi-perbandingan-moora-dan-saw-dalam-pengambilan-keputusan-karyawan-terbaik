@extends('layouts.admin.admin')

@section('content-title', 'Normalisasi')

@section('content-body')
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Normalisasi - SAW</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Karyawan</th>
                            <th class="col-2">Email</th>
                            @foreach($criterias as $criteria)
                                <th class="col-4">{{ $criteria->code }} - {{ $criteria->name }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employeeIndex => $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                @foreach($criterias as $criteriaIndex => $criteria)
                                    <td>{{ $normalizationSAW[$criteriaIndex][$employeeIndex] }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + $criterias->count() }}" style="text-align: center;">Data Empty</td>
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
                <h4>Normalisasi - Moora</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Karyawan</th>
                            <th class="col-2">Email</th>
                            @foreach($criterias as $criteria)
                                <th class="col-4">{{ $criteria->code }} - {{ $criteria->name }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employeeIndex => $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                @foreach($criterias as $criteriaIndex => $criteria)
                                    <td>{{ $normalizationMoora[$criteriaIndex][$employeeIndex] }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + $criterias->count() }}" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
