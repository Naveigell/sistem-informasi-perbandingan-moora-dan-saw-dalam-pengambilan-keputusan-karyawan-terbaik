@extends('layouts.admin.admin')

@section('content-title', 'Pegawai')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <form action="{{ @$employee ? route('admin.employees.update', $employee) : route('admin.employees.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method(@$employee ? 'PUT' : 'POST')
            <div class="card">
                <div class="card-header">
                    <h4>Form Pegawai</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$employee ? $employee->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', @$employee ? $employee->email : '') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', @$employee ? $employee->phone : '') }}">
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" id="" cols="30" rows="10" style="min-height: 200px; resize: none;" class="form-control @error('address') is-invalid @enderror">{{ old('address', @$employee ? $employee->address : '') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Form Kriteria</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            /**
                             * @var \Illuminate\Support\Collection $employeeSubCriterias
                             */
                             $employeeSubCriterias = @$employee ? $employee->subCriterias->pluck('sub_criteria_id') : collect();
                        @endphp
                        @foreach($criterias as $criteria)
                            <div class="form-group col-4">
                                <label>{{ $criteria->code }} - {{ $criteria->name }}</label>
                                <select name="criteria_{{ $criteria->id }}" id="criteria_{{ $criteria->id }}" class="form-control">
                                    <x-nothing-selected></x-nothing-selected>
                                    @foreach($criteria->subCriterias as $subCriteria)
                                        <option @if (@$employee && $employeeSubCriterias->contains($subCriteria->id)) selected @endif value="{{ $subCriteria->id }}">{{ $subCriteria->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
