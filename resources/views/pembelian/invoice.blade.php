<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pengembangan Aplikasi CRM Web E-Commerce pada INDOVAPING">
    <meta name="author" content="INDOVAPING Store">

    <title>Invoice INDOVAPING Store</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('Logo.png') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }



        /* ... add any other custom styles ... */
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="row">
                    <h3>
                        <img src="{{ asset('Logo.png') }}" width="90px" alt="Logo">
                        INVOICE PEMBELIAN INDOVAPING STORE
                    </h3>
                    <hr style="border: solid 1px black">
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row px-4">
                        <!-- Alamat Tujuan -->
                        <h4>Alamat Tujuan</h4>
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <td>: {{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: {{ $konsumen->alamat }}</td>
                            </tr>
                            <tr>
                                <th>No Hp</th>
                                <td>: {{ $konsumen->telepon }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <td>: {{ $transactions->tanggal_transaksi }}</td>
                            </tr>
                        </table>

                        <!-- Detail Transaksi -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Beli</th>
                                        <th>Jumlah bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $totalJumlahBeli = 0;
                                    @endphp
                                    @foreach ($detailTransactions as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->barang->nama_barang }}</td>
                                            <td>{{ $data->jumlah_beli }}</td>
                                            <td>{{ 'Rp ' . number_format($data->jumlah_bayar, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                            $totalJumlahBeli += $data->jumlah_bayar;
                                        @endphp
                                    @endforeach

                                    <!-- Jasa Kirim -->
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Jasa Kirim</strong></td>
                                        <td>{{ 'Rp ' . number_format($transactions->total_bayar - $totalJumlahBeli, 0, ',', '.') }}
                                        </td>
                                    </tr>

                                    <!-- Total -->
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><b>Total</b></td>
                                        <td>{{ 'Rp ' . number_format($transactions->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
