@extends('website.components.master')

@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaction</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Pegawai</h3>
                        </div>
                        <div class="card-body">
                            <div class="direct-chat-messages">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Paket</th>
                                            <th>Sales</th>
                                            <th>Customer</th>
                                            <th>Image</th>
                                            <th>Detail</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->paket[0]->name }}</td>
                                                <td>{{ $item->user[0]->name }}</td>
                                                <td>{{ $item->customer[0]->name }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal-view-ktp-{{ $item->id }}">
                                                        KTP
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal-view-house-{{ $item->id }}">
                                                        Rumah
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal-view-detail-{{ $item->id }}">
                                                        Detail User
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-{{ $item->is_verified ? 'danger' : 'success' }} btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal-verifikasi-{{ $item->id }}">
                                                        {{ $item->is_verified ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @foreach ($data as $item)
        <div class="modal fade" id="modal-view-house-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Foto Rumah Customer {{ $item->customer[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Foto</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($house_customer->where('customer_id', $item->customer_id) as $row)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/uploads/images/house') . '/' . $row->photo_house }}"
                                                alt="{{ $row->photo_house }}" width="100">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-view-ktp-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Foto KTP Customer {{ $item->customer[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Foto</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/uploads/images/ktp') . '/' . $row->customer[0]->photo_ktp }}"
                                            alt="{{ $row->photo_ktp }}" width="100">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-view-detail-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Customer {{ $item->customer[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body d-flex justify-between">
                        <div class="kanan">
                            <p>Nomor Telp: </p>
                            <p>Alamat: </p>
                        </div>
                        <div class="kiri ml-5">
                            <p>{{ $item->customer[0]->phone_number }}</p>
                            <p>{{ $item->customer[0]->address }}</p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-verifikasi-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Verifikasi {{ $item->customer[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.transaction.verification') }}" method="post"
                            class="d-flex justify-content-center">
                            @csrf
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="button" class="btn btn-default mr-2" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Verifkasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
