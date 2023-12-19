<table>
    <thead>
        <tr></tr>
        <tr>
            <th></th>
            <th><b>Nama Pengajar: </b></th>
            <th><b>{{ Auth::user()->name }}</b></th>
        </tr>
        <tr>
            <th></th>
            <th><b>Tanggal Mulai Kelas: </b></th>
            <th><b>{{ Carbon\Carbon::parse($materials[0]->created_at)->format('d F Y') }}</b></th>
        </tr>
        <tr></tr>
        <tr>
            <th style="border: 1px solid black; border-collapse: collapse;">Pertemuan</th>
            <th style="border: 1px solid black; border-collapse: collapse;">Tanggal (Hari, Tanggal Bulan Tahun)</th>
            <th style="border: 1px solid black; border-collapse: collapse;">Materi yang Disampaikan</th>
            <th style="border: 1px solid black; border-collapse: collapse;">Tugas / Latihan</th>
            <th style="border: 1px solid black; border-collapse: collapse;">Catatan Proses KBM</th>
        </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
    @endphp
    @foreach($materials as $material)
        <tr>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ $no }}</td>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ Carbon\Carbon::parse($material->created_at)->format('l, d F Y') }}</td>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ $material->name }}</td>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ $material->task }}</td>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ $material->note }}</td>
        </tr>
        <tr>
            <td colspan="5" bgcolor="#be286c"></td>
        </tr>
        @php
            $no++;
        @endphp
    @endforeach
    </tbody>
</table>