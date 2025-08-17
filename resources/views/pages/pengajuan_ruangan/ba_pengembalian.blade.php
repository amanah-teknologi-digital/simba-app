@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.7;
            margin: 40px;
        }
        .kop {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
            position: relative;
            min-height: 90px;
        }
        .kop img {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: auto;
        }
        .kop .text {
            margin-left: 95px;
            text-align: center;
        }
        .kop h2, .kop h3, .kop p {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* hilangkan double border */
            margin-top: 12px;
            font-size: 13px;
        }
        table th, table td {
            border: 0.2px solid #555; /* lebih tipis dan warna soft */
            padding: 6px;
        }
        table thead th,
        table tr th:first-child{
            background-color: rgb(200, 215, 235) !important; /* biru soft, aman diprint */
            color: #000; /* tetap terbaca */
            text-align: left;
        }
        table tbody td:nth-child(1),
        table tbody td:nth-child(3),
        table tbody td:nth-child(4) {
            text-align: center;
        }
        .signature {
            width: 100%;
            margin-top: 50px;
        }
        .signature td {
            text-align: center;
            vertical-align: top;
            border: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
{{-- KOP SURAT --}}
<div class="kop">
    <img src="{{ public_path('landing_page_rss/logo-manbis.png') }}" alt="Logo">
    <div class="text">
        <h2>INSTITUT TEKNOLOGI SEPULUH NOPEMBER</h2>
        <h3>{{ $fakultas }}</h3>
        <span>{{ $dataPengaturan->alamat }}</span>
        <p>Telp. (031) 5953476, Email: tgeofisika@its.ac.id</p>
    </div>
</div>

{{-- JUDUL --}}
<div style="text-align: center; margin-bottom: 20px;">
    <h3><u>BERITA ACARA PENGEMBALIAN RUANGAN</u></h3>
    <p>Nomor: {{ $dataPengajuan->id_pengajuan }}/BA-2/GEO/{{ now()->year }}</p>
</div>

{{-- ISI --}}
<p>Pada hari ini, telah dilakukan pengembalian ruangan dengan rincian berikut:</p>

<table>
    <tr>
        <th style="width:25%">Nama Kegiatan</th>
        <td>{{ $dataPengajuan->nama_kegiatan }}</td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td>{{ $dataPengajuan->deskripsi }}</td>
    </tr>
    <tr>
        <th>Tanggal</th>
        <td>{{ $dataPengajuan->tgl_mulai->format('d-m-Y') }} s/d {{ $dataPengajuan->tgl_selesai->format('d-m-Y') }} Jam {{ $dataPengajuan->jam_mulai->format('H:i') }} – {{ $dataPengajuan->jam_selesai->format('H:i') }}</td>
    </tr>
    <tr>
        <th>Pengaju</th>
        <td>{{ $dataPengajuan->nama_pengaju }}</td>
    </tr>
    <tr>
        <th>Ruangan Dipinjam</th>
        <td>
            <ul style="margin:0; padding-left:15px;">
                @foreach($dataPengajuan->pengajuanruangandetail as $ruang)
                    <li>{{ $ruang->ruangan->kode_ruangan.' - '.$ruang->ruangan->nama }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
    <tr>
        <th>Petugas Pemeriksa</th>
        <td>{{ $dataPengajuan->pemeriksaawal->name }}</td>
    </tr>
</table>

<h4 style="margin-top:20px;">Peralatan</h4>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Peralatan</th>
        <th>Jumlah</th>
        <th>Kondisi</th>
        <th>Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataPengajuan->pengajuanperalatandetail as $i => $alat)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $alat->nama_sarana }}</td>
            <td>{{ $alat->jumlah }}</td>
            <td>{{ $alat->is_valid_akhir == 1 ? 'Ada' : 'Tidak' }}</td>
            <td>{{ $alat->keterangan_akhir }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p style="margin-top:20px;">Demikian berita acara ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
<h4 style="margin-top:20px;">Dokumentasi Kondisi Ruangan Sesudah Acara</h4>

@if(!empty($imagesData))
    <table style="width: 100%; border-collapse: collapse;">
        @php $columnCounter = 0; @endphp

        @foreach($imagesData as $imageData)
            @if($columnCounter % 3 == 0)
                {{-- Mulai baris baru (<tr>) setiap 3 kolom --}}
                <tr>
                    @endif

                    <td style="width: 33.33%; padding: 5px; text-align: center; vertical-align: top;">
                        <div style="border:1px solid #ddd; padding:4px;">
                            <img src="{{ $imageData }}" alt="Foto Dokumentasi" style="width: 100%; height: 160px; object-fit: cover;">
                        </div>
                    </td>

                    @php $columnCounter++; @endphp

                    @if($columnCounter % 3 == 0 || $loop->last)
                        {{-- Tutup baris (</tr>) setelah 3 kolom atau jika ini item terakhir --}}
                </tr>
            @endif
        @endforeach
    </table>
@else
    <p style="font-style: italic; color: #555;">Tidak ada foto dokumentasi yang diunggah.</p>
@endif

{{-- TANDA TANGAN --}}
<table class="signature">
    <tr>
        <td>
            Mengetahui,<br>
            <br><br><br><br>
            <u>_________________</u><br>
            Pihak Penyetuju
        </td>
        <td>
            Surabaya, {{ now()->translatedFormat('d F Y') }}<br>
            <br><br><br><br>
            <u>{{ $dataPengajuan->nama_pengaju }}</u><br>
            Pengaju
        </td>
    </tr>
</table>

</body>
</html>
