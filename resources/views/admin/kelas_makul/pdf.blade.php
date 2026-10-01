<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kelas Mata Kuliah PDF</title>
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
          <tr class="text-center">
            <th>No</th>
            <th>Kelas</th>
            <th>Periode</th>
            <th>Mata Kuliah</th>
            <th>Jurusan</th>
            <th>Dosen Pengampu</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($kelas_mk as $km)
            <tr class="text-center">
              <td>{{ $no++ }}</td>
              <td>{{ $km->nama_kelas }}</td>
              <td>{{ $km->akademik->tahun }} - {{ ($km->akademik->semester == 'GL') ? 'Ganjil' : 'Genap' }}</td>
              <td class="text-left">{{ $km->makul->nama_makul }}</td>
              <td class="text-left">{{ $km->jurusan->nama_jurusan }}</td>
              <td class="text-left">{{ $km->dosen->nama }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
</body>
</html>