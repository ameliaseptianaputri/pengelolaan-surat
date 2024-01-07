@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            font-size: small;
        }

        #back-wrap {
            margin: 30px auto 0 auto;
            width: 870px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back{
            width: fit-content;
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
        }

        #letter {
            box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.5);
            padding: 20px;
            margin: 30px auto 0 auto;
            width: 850px;
            background: #fff;
        }

        .btn-print {
            float: right;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
        }

        .right-align {
            text-align: right;
        }

        .content {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .content-section {
            margin-bottom: 20px;
        }

        .content-section p {
            margin: 0;
        }

        table.no-border td,
        table.no-border th {
            border: none;
        }
    </style>
</head>

<body>

<div id="letter">
    <div class="container">
        <div class="header">
            <h2>SMK WIKRAMA BOGOR</h2>
            <p>Bisnis dan Manajemen <br>
                Teknik Informasi dan Komunikasi Pariwisata</p>
            <p>jln. Raya Wangun Kel. Sindangsari Bogor<br>
                Telp/Faks: (0251) 8242411 <br>
                e-mail prohumasi@smkwikrama.sch.id <br>
                website: www.smkwikrama.sch.id</p>

        </div>
        <hr />

        <div class="content">
            <div class="right-align">
                <p>{{ $letter->created_at->format('j F Y') }}</p>
            </div>

            <div class="content-section">
                <table class="no-border">
                    <tr>
                        <td>No: {{ $letter->letterType->letter_code }}/000{{$letter->id}}/SMK-WIKRAMA-BOGOR/XII/{{ date('Y') }}</td>
                    </tr>
                    <tr>
                        <td>Hal: <strong>{{ $letter->letter_perihal }}</strong> </td>
                    </tr>
                </table>
            </div>

            <div class="content-section">
                <table class="no-border">
                    <tr>
                        <td>Kepada Yth: Bapak/Ibu Terlampir</td>
                    </tr>
                    <tr>
                        <td>Di: Tempat</td>
                    </tr>
                </table>
            </div>

            <p align="justify">
            {{ strip_tags(str_replace('$nsbp;', ' ', $letter->content)) }}
            </p>

            <p align="justify">
                Demikian undangan ini kami sampaikan, atas perhatian dan kerja samanya kami ucapkan terimakasih.
                <br>Wassalamualaikum Wr. Wb. <br><br>
            <table class="no-border">
                Peserta:
                <tr>
                    <td>
                        @foreach($result->presence_recipients as $index => $recipient)
                            <ol>{{ $index + 1 }}. {{ $recipient['name'] }}</ol>
                        @endforeach
                    </td>
                </tr>         
            </table>
            </p>
        </div>

        <div class="right-align">
            <p>Hormat kami,<br>
                Kepala SMK Wikrama Bogor</p>
        </div>

        <div class="right-align" style="margin-top: 70px;">
            <p>(......................)</p>
        </div>
    </div>

    <div class="section">
        <div class="card">
            <div class="card-body">

           
                @csrf
                <div class="h5 mb-3">Hasil Rapat Perihal: {{ $letter->letter_perihal }}</div>
                    <div class="h6">Peserta Yang Hadir</div><br><br>
                    <table class="table table-bordered">
                        <thead class="table-light">
                          <tr>
                              <th scope="col">Nama</th>
                              <th scope="col">Kehadiran</th>
                        </tr>
                        </thead>
                        <tbody>
                            {{-- ini ngambil dari result  --}}
                            @foreach ($letter->recipients as $index => $recipient)
                            <tr>
                                <td>
                                    {{ $recipient['name'] }}
                                </td>
                                <td><input type="checkbox" name="recipients[]" value=""></td>
                            </tr>
                            <tr>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
    
                    <div class="h6">Ringkasan Rapat:</div>
                    <div class="mb-3">
                        @if (App\Models\Result::where('letter_id', $letter->id)->exists())
                            <textarea class="form-control" disabled name="notes">{{ $result->notes }}</textarea>
                        @else
                            <p class="text-danger">Belum Dibuat</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>

</html>

@endsection