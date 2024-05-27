@extends('layouts.main')

@section('title', 'Client')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Client</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modal-default">
                                        Tambah
                                    </button>
                                    <div class="modal fade" id="modal-default">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Tambah Data Client</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">Logo</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="exampleInputFile" name="logo"
                                                                            accept="image/*" required>
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">Choose
                                                                            file</label>
                                                                    </div>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="link">Link</label> <span
                                                                    class="text-danger">* Opsional</span>
                                                                <input type="text" class="form-control" name="link"
                                                                    id="link" placeholder="Link">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Logo</th>
                                            <th>Link</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Data Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('client.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" name="id_client" id="id_client">
                                <div class="form-group">
                                    <label for="exampleInputFile">Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                name="logo" accept="image/*">
                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link">Link</label> <span class="text-danger">* Opsional</span>
                                    <input type="text" class="form-control" name="link" id="link"
                                        placeholder="Link">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}'
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oopss...',
                text: '{{ $errors->first() }}'
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#myTable").DataTable({
                processing: true,
                ordering: true,
                responsive: true,
                serverSide: true,
                ajax: "{{ route('client') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'logo',
                        name: 'logo',
                        render: function(data) {
                            if (data == '') {
                                return '<img src="{{ asset('dist/img/LOGO POLITEKNIK NEGERI  JEMBER.png') }}" alt="" style="width: 50px; height: 50px;">';
                            } else {
                                return '<img src="{{ asset('logo/') }}/' + data +
                                    '" alt="" style="width: 50; height: 50px;">';
                            }
                        }
                    },
                    {
                        data: 'link',
                        name: 'link',
                        render: function(data) {
                            if (data === null || data === '') {
                                return '<a href="#">No link available</a>';
                            } else {
                                return '<a href="' + data + '" target="_blank">' + data + '</a>';
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return '<div class="row justify-content-center">' +
                                '<div class="col-auto">' +
                                '<button type="button" class="btn btn-warning m-1" data-toggle="modal"' +
                                'data-target="#modal-edit" data-id="' + data
                                .id_client + '" data-link="' + data.link + '">' +
                                'Edit' +
                                '</button>' +
                                '<button type="button" class="btn btn-danger m-1" onclick="confirmDelete(' +
                                data.id_client + ')"' +
                                'data-id="' + data.id_client +
                                '">Hapus</button>' +
                                '</div>' +
                                '</div>';
                        }
                    }
                ],
                rowCallback: function(row, data, index) {
                    var dt = this.api();
                    $(row).attr('data-id', data.id);
                    $('td:eq(0)', row).html(dt.page.info().start + index + 1);
                }
            });
            $('#modal-edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id_client = button.data('id');
                var link = button.data('link');
                var modal = $(this);

                modal.find('.modal-body #id_client').val(id_client);
                modal.find('.modal-body #link').val(link);
            });

            $('.datatable-input').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                $('.table tr').each(function() {
                    var rowData = $(this).text().toLowerCase();
                    if (rowData.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/client') }}/" + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            );
                            $('#myTable').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data. Silahkan coba lagi',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
