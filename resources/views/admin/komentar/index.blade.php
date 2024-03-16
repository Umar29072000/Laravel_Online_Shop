@extends('admin.layout.main') <!-- If you have a common layout, extend it here -->

@section('title', 'Komentar')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Produk</th>
                                <th>Nama Konsumen</th>
                                <th>Komentar</th>
                                <th class="hidden-480">Tanggal Komentar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($komentar as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        @if ($data->produk)
                                            <a
                                                href="{{ route('products.show', $data->produk->id) }}">{{ $data->produk->nama_barang }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->user)
                                            {{ $data->user->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $data->komentar }}</td>
                                    <td>{{ date('H:i d-m-Y', strtotime($data->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });
    </script>
@endsection
