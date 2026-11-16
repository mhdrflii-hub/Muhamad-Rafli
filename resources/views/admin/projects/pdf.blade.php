<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2,
        .subtitle {
            text-align: center;
        }

        .subtitle {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 90px;
            max-height: 70px;
        }
    </style>
</head>
<body>
    <h2>LAPORAN DATA PROJECT</h2>
    <div class="subtitle">Tanggal Cetak: {{ now()->format('d-m-Y') }}</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Project</th>
                <th>Deskripsi</th>
                <th>Teknologi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $index => $project)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($project->image && file_exists(public_path('images/' . $project->image)))
                            <img src="{{ public_path('images/' . $project->image) }}" alt="{{ $project->title }}">
                        @else
                            <span>No Image Available</span>
                        @endif
                    </td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->teknologi }}</td>
                    <td>{{ $project->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
