<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Dosen PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
        }

        th {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2 class="text-center">Jurusan Komputer dan Bisnis</h2>
    <h2 class="text-center">D3 Teknik Informatika</h2>
    <p class="text-center">Alamat: Jl.  Dr. Soetomo No.1, Karangcengis,</p>
    <p class="text-center">Sidakaya, Kec. Cilacap Sel., Kabupaten Cilacap, Jawa Tengah 53212</p>
    <hr>
    <h3>{{ $title }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Kontak</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
        @forelse ($dosen as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nik }}</td>
                <td class="text-left">{{ $d->nama }}</td>
                <td>{{ $d->kontak }}</td>
                <td class="text-left">{{ $d->email }}</td>
                <td class="text-left">
                    @if ($d->kelamin == 'P')
                    Perempuan
                    @else
                    Laki-laki
                    @endif
                </td>
            </tr>          
        @empty
            <tr>
                <td colspan="6" class="text-center">Data dosen tidak ditemukan</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>