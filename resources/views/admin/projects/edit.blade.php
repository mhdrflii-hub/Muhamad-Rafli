@extends('admin.tamplate')

@section('title', 'Edit Project')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="mb-4">Edit Data Project</h5>

        <form action="{{ route('admin.project.update', $project->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Project</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $project->title) }}"
                       required>
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          rows="4">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teknologi</label>
                <input type="text"
                       name="teknologi"
                       class="form-control"
                       value="{{ old('teknologi', $project->teknologi) }}">
                @error('teknologi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Project</label>

                @if ($project->image)
                    <div class="mb-2">
                        <img src="{{ asset('images/' . $project->image) }}"
                             alt="Gambar Project"
                             style="max-width: 150px;">
                    </div>
                @endif

                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti gambar.
                </small>

                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="selesai"
                        {{ old('status', $project->status) == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                    <option value="In Progress"
                        {{ old('status', $project->status) == 'In Progress' ? 'selected' : '' }}>
                        In Progress
                    </option>
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">
                Update Data
            </button>

            <a href="{{ route('admin.project.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
