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
                <p>{{ $let->created_at->format('j F Y') }}</p>
            </div>

            <div class="content-section">
                <table class="no-border">
                    <tr>
                        <td>No: {{ $let->letter_code }}/000{{$let->id}}/SMK-WIKRAMA-BOGOR/XII/{{ date('Y') }}</td>
                    </tr>
                    <tr>
                        <td>Hal: <strong>{{ $let->name_type }}</strong> </td>
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
                Dengan hormat,
                <br>
                Bersama ini kami mengundang Bapak/Ibu untuk mengikuti rapat yang akan dilaksanakan pada:
            </p>

            <div class="content-section">
                <table class="no-border">
                    <tr>
                        <td>Hari, tanggal: Rabu, 13 Desember 2023</td>
                    </tr>
                    <tr>
                        <td>Pukul  : 14.00 WIB s.d. Selesai</td>
                    </tr>
                    <tr>
                        <td>Tempat  : Ruang Kepala Sekolah</td>
                    </tr>
                    <tr>
                        <td>Agenda  : Pengelolaan Laboratorium</td>
                    </tr>
                    <tr>
                        <td>Notulis : amel</td>
                    </tr>
                </table>
            </div>

            <p align="justify">
                Demikian undangan ini kami sampaikan, atas perhatian dan kerja sama Bapak/Ibu kami ucapkan terimakasih.
            <br><br>

                1. fania <br> 2. amel
            <table class="no-border">
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
</body>

</html>
