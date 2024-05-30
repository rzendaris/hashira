<table>
    <thead>
        <tr></tr>
        <tr>
            <th></th>
            <th rowspan="5" style="color:white; border: 1px solid black; border-collapse: collapse; text-align: center; vertical-align: middle; word-wrap: break-word" bgcolor="#2f5496">Skala Penilaian Pemahaman dan Keaktifan siswa</th>
            <th style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">10. Sempurna</th>
            <th colspan="5" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">5. Lumayan Parah</th>
        </tr>
        <tr>
            <th></th>
            <th style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">9. Luar Biasa Bagus</th>
            <th colspan="5" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">4. Parah</th>
        </tr>
        <tr>
            <th></th>
            <th style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">8. Sangat Bagus</th>
            <th colspan="5" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">3. Sangat Parah</th>
        </tr>
        <tr>
            <th></th>
            <th style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">7. Bagus</th>
            <th colspan="5" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">2. Luar Biasa Parah</th>
        </tr>
        <tr>
            <th></th>
            <th style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">6. Lumayan Bagus</th>
            <th colspan="5" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#2f5496">1. Mengerikan</th>
        </tr>
        <tr></tr>
        <tr>
            <th rowspan="2" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#be286c">No</th>
            <th rowspan="2" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#be286c">Nama Siswa</th>
            <th rowspan="2" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#be286c">No Induk</th>
            @foreach($date_range as $key => $value)
                <th colspan="{{ count($value) }}" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#be286c">{{ $key }}</th>
            @endforeach
            <th rowspan="2" style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#be286c">Catatan</th>
        </tr>
        <tr>
            @foreach($date_range as $key => $value)
                @foreach($value as $date)
                    <th style="color:white; border: 1px solid black; border-collapse: collapse;" bgcolor="#be286c">{{ Carbon\Carbon::parse($date)->format('d') }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
    @endphp
    @foreach($students['students'] as $student_name => $value)
        <tr>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ $no }}</td>
            <td style="border: 1px solid black; border-collapse: collapse;">{{ $student_name }}</td>
            <td style="border: 1px solid black; border-collapse: collapse;"></td>
            @foreach($value as $student_value)
                @if($student_value['score'] === 'W')
                    <th style="border: 1px solid black; border-collapse: collapse;" bgcolor="#ff0000"></th>
                @else
                    <th style="border: 1px solid black; border-collapse: collapse;">{{ $student_value['score'] }}</th>
                @endif
            @endforeach
            <td style="border: 1px solid black; border-collapse: collapse;"></td>
        </tr>
        @php
            $no++;
        @endphp
    @endforeach
    </tbody>
</table>