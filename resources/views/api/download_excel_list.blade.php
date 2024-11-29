@php 
$filename = 'Absen Radir '.$data['date'].'.xls';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
@endphp
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Absen Radir</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        </style>
    </head>
    <body style="overflow-x:scroll">
    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable2">
            <thead>
                <tr>
                    <!-- 0 --> <th>#</th>
                    <!-- 2 --> <th>NIK TG</th>
                    <!-- 3 --> <th>Nama</th>
                    <!-- 4 --> <th>Unit</th>
                    <!-- 5 --> <th>Jabatan</th>
                    <!-- 5 --> <th>Direktorat</th>
                    <!-- 5 --> <th>Status</th>
                    <!-- 5 --> <th>Alasan</th>
                    <!-- 6 --> <th>Datetime Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['absen'] as $absen)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$absen->nik_tg}}</td>
                    <td>{{$absen->name}}</td>
                    <td>{{$absen->unit}}</td>
                    <td>{{$absen->jabatan}}</td>
                    <td>{{$absen->direktorat}}</td>
                    <td>{{$absen->status}}</td>
                    <td>{{$absen->alasan}}</td>
                    <td>{{$absen->datetime}}</td>  
                </tr>
                @endforeach
            </tbody>   
        </table>
    </body>
</html>