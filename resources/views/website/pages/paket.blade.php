@extends('website.components.master')

@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Paket</h1>
                </div><!-- /.col -->
            </div>
        </div>
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-cart mr-1"></i>
                                Tambah Paket
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.paket.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama Paket</label>
                                    <input type="text" class="form-control" value="{{ old('name') }}" id="name"
                                        name="name">
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga</label>
                                    <input type="text" class="form-control" value="{{ old('price') }}" id="price"
                                        name="password">
                                </div>
                                <button class="btn btn-primary" style="float: right;">Simpan</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>

            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Paket</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ number_format($item->price) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-warning btn-sm"
                                                    data-toggle="modal" data-target="#modal-edit-{{ $item->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    data-toggle="modal" data-target="#modal-delete-{{ $item->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    @foreach ($data as $item)
        <div class="modal fade" id="modal-edit-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Paket {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.paket.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nama Paket</label>
                                <input type="number" name="id" value="{{ $item->id }}" hidden>
                                <input type="text" class="form-control"
                                    value="{{ empty(old('name')) ? $item->name : old('name') }}" id="name"
                                    name="name">
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="text" class="form-control"
                                    value="{{ empty(old('price')) ? $item->price : old('price') }}" id="price"
                                    name="price">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-delete-{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Paket</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.paket.delete') }}" method="post"
                            class="d-flex justify-content-center">
                            @csrf
                            <input type="number" name="id" value="{{ $item->id }}" hidden>
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
