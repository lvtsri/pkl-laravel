<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Mata Kuliah PDF</title>
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
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>Jumlah SKS</th>
                <th>Jumlah CPMK</th>
            </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        @forelse ($makul as $m)
            <tr class="text-center">
                <td>{{ $no++ }}</td>
                <td class="text-left">{{ $m->kode_makul }}</td>
                <td class="text-left">{{ $m->nama_makul }}</td>
                <td>{{ $m->jml_sks }}</td>
                <td>{{ $m->jml_cpmk }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Data jurusan tidak ditemukan</td>
            </tr>
        @endforelse
    </table>
    
</body>
</html>