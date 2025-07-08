@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ isset($data) ? 'Edit' : 'Tambah' }} {{ $title ?? 'Data' }}</h3>

    <form method="POST"
          action="{{ isset($data) ? route($route.'.update', $data->id) : route($route.'.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($data)) @method('PUT') @endif

        @foreach($fields as $name => $field)
            <div class="mb-3">
                <label class="form-label">{{ $field['label'] }}</label>

                @if($field['type'] === 'textarea')
                    <textarea name="{{ $name }}" class="form-control" required>{{ old($name, $data->$name ?? '') }}</textarea>
                @elseif($field['type'] === 'select')
                    <select name="{{ $name }}" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($field['options'] as $key => $val)
                            <option value="{{ $key }}"
                                {{ (old($name, $data->$name ?? '') == $key) ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                @elseif($field['type'] === 'file')
                    <input type="file" name="{{ $name }}" class="form-control">
                    @if(isset($data) && $data->$name)
                        <br>
                        <img src="{{ asset('storage/'.$data->$name) }}" width="120">
                    @endif
                @else
                    <input type="{{ $field['type'] }}" name="{{ $name }}" class="form-control"
                           value="{{ old($name, $data->$name ?? '') }}" required>
                @endif

                @error($name)
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-{{ isset($data) ? 'warning' : 'primary' }}">
            {{ isset($data) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route($route.'.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection