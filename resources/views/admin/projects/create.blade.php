@extends('admin.tamplate')

@section('title', 'Tambah Project')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="mb-4">Tambah Data Project</h5>

        <form action="{{ route('admin.project.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Project</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       placeholder="Masukkan judul project"
                       value="{{ old('title') }}"
                       required>
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Masukkan deskripsi project">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teknologi</label>
                <input type="text"
                       name="teknologi"
                       class="form-control"
                       placeholder="Contoh: Laravel & Bootstrap"
                       value="{{ old('teknologi') }}">
                @error('teknologi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Project</label>
                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="">Pilih Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="In Progress">In Progress</option>
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Data
            </button>

            <a href="{{ route('admin.project.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
