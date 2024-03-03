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
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-cart mr-1"></i>
                                Input Customer
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pegawai.transaction.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama Customer</label>
                                    <input type="text" class="form-control" value="{{ old('name') }}" id="name"
                                        name="name">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Nomor Telp</label>
                                    <input type="text" class="form-control" value="{{ old('phone') }}" id="phone"
                                        name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="paket">Paket</label>
                                    <select name="paket" id="paket" class="form-control">
                                        <option selected hidden>Pilih Paket</option>
                                        @foreach ($paket as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name . ' | Rp' . number_format($item->price) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="photo_ktp">KTP</label>
                                    <input type="file" class="form-control" value="{{ old('photo_ktp') }}" id="photo_ktp"
                                        name="photo_ktp">
                                </div>
                                <div class="form-group">
                                    <label for="photo_house">Foto Rumah (multiple)</label>
                                    <input type="file" class="form-control" value="{{ old('photo_house') }}"
                                        id="photo_house" name="photo_house[]" multiple>
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <textarea name="address" class="form-control" id="address" rows="5">{{ old('address') }}</textarea>
                                </div>
                                <button class="btn btn-primary" style="float: right;">Simpan</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
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
                                            <th>Customer</th>
                                            <th>Paket</th>
                                            <th>KTP</th>
                                            <th>House</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->customer[0]->name }}</td>
                                                <td>{{ $item->paket[0]->name . ' | Rp' . $item->paket[0]->price }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#modal-ktp-{{ $item->id }}">
                                                        View
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#modal-house-{{ $item->id }}">
                                                        View
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-warning btn-sm"
                                                        data-toggle="modal" data-target="#modal-edit-{{ $item->id }}">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal-delete-{{ $item->id }}">
                                                        Delete
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

    @foreach ($transaction as $item)
        <div class="modal fade" id="modal-ktp-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Foto KTP {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Foto</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/uploads/images/ktp') . '/' . $item->customer[0]->photo_ktp }}"
                                            alt="{{ $item->customer[0]->photo_ktp }}" width="100">
                                    </td>
                                    <td>

                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modal-edit-ktp-{{ $item->id }}">
                                            Ubah
                                        </button>
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

    @foreach ($transaction as $item)
        <div class="modal fade" id="modal-house-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Foto Rumah {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Foto</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($house_customer->where('customer_id', $item->customer_id) as $row)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/uploads/images/house') . '/' . $row->photo_house }}"
                                                alt="{{ $row->photo_house }}" width="100">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modal-edit-house-{{ $row->id }}">
                                                Ubah
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-delete-house-{{ $row->id }}">
                                                Ubah
                                            </button>
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

    @foreach ($transaction as $item)
        <div class="modal fade" id="modal-edit-ktp-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Pegawai {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pegawai.transaction.update_ktp_customer') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label for="ktp">KTP</label>
                            <input type="number" value="{{ $item->customer_id }}" name="id" hidden>
                            <input type="file" name="photo_ktp" class="form-control">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($house_customer as $item)
        <div class="modal fade" id="modal-edit-house-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Foto Rumah</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pegawai.transaction.update_house_customer') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label for="ktp">Foto Rumah</label>
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <input type="file" name="photo_house" class="form-control">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($house_customer as $item)
        <div class="modal fade" id="modal-delete-house-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Foto Rumah {{ $item->customer[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pegawai.transaction.delete_house_customer') }}" method="post"
                            class="d-flex justify-content-center">
                            @csrf
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <input type="number" value="{{ $item->customer_id }}" name="customer_id" hidden>
                            <button type="button" class="btn btn-default mr-2" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($transaction as $item)
        <div class="modal fade" id="modal-edit-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Customer {{ $item->customer[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pegawai.transaction.update') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Customer</label>
                                <input type="number" name="id" value="{{ $item->id }}" hidden>
                                <input type="number" name="customer_id" value="{{ $item->customer_id }}" hidden>
                                <input type="text" class="form-control" value="{{ $item->customer[0]->name }}"
                                    id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Nomor Telp</label>
                                <input type="text" class="form-control"
                                    value="{{ $item->customer[0]->phone_number }}" id="phone_number"
                                    name="phone_number">
                            </div>
                            <div class="form-group">
                                <label for="paket">Paket</label>
                                <select name="paket" id="paket" class="form-control">
                                    <option selected hidden>Pilih Paket</option>
                                    @foreach ($paket as $row)
                                        <option {{ $item->paket_id == $row->id ? 'selected' : '' }}
                                            value="{{ $row->id }}">
                                            {{ $row->name . ' | Rp' . number_format($row->price) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea name="address" class="form-control" id="address" rows="5">{{ $item->customer[0]->address }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($transaction as $item)
        <div class="modal fade" id="modal-delete-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Pegawai {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pegawai.transaction.delete') }}" method="post"
                            class="d-flex justify-content-center">
                            @csrf
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="button" class="btn btn-default mr-2" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
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
