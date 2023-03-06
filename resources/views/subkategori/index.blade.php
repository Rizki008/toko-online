@extends('layout.app')

@section('title', 'Data subkategori')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data subkategori
            </h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah Data</a>
                {{-- <a href="/subkategori/create" class="btn btn-primary">Tambah Data</a> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hove table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Nama Subkatagori</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Subkategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-subkategori">
                                {{-- <input type="hidden" name="type" id=""> --}}
                                <div class="form-group">
                                    <label for="">Nama Subkategori</label>
                                    <input type="text" class="form-control" name="nama_subkategori" id="nama_subkategori"
                                        placeholder="Nama subkategori" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Kategori</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" id="" cols="30" rows="10"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Gambar</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(function() {

            $.ajax({
                url: '/api/subcategories',
                success: function({
                    data
                }) {
                    // console.log(data);
                    let row;
                    data.map(function(val, index) {
                        // console.log(val);
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.nama_subkategori}</td>
                            <td>${val.category.nama_kategori}</td>
                            <td>${val.deskripsi}</td>
                            <td><img src="/uploads/subkategori/${val.gambar}" width="150"></td>
                            <td>
                                <a data-toggle="modal" herf="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                                <a herf="#" data-id="${val.id}" class="btn btn-danger btn-hapus">Hapus</a>
                            </td>
                        </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            });

            $(document).on('click', '.btn-hapus', function() {
                const id = $(this).data('id')
                const token = getCookie('token');
                confirm_dialog = confirm('Apakah anda yakin akan hapus subkatagori ini ?');


                if (confirm_dialog) {
                    $.ajax({
                        url: '/api/subcategories/' + id,
                        type: "DELETE",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer' + token);
                        },
                        // headers: {
                        //     "Authorization": token
                        // },
                        // headers: {
                        //     "Authorization": "Bearer" + getCookie('token')
                        // },
                        success: function(data) {
                            if (data.message == 'Success') {
                                alert('Data Berhasil Dihapus')
                                location.reload()
                            }
                            // console.log(data);
                        }
                    });
                }

            });

            $('.modal-tambah').click(function() {
                $('#modal-form').modal('show');
                $('input[name="nama_subkategori"]').val('');
                $('input[textarea="deskripsi"]').val('');

                $('.form-subkategori').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: 'api/subcategories',
                        type: 'POST',
                        data: frmdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer' + token);
                        },
                        success: function(data) {
                            // console.log(data);
                            // return
                            if (data.success) {
                                alert('Data Berhasil Ditambahkan!!!')
                                location.reload();
                            }
                        }
                    })
                });
            });

            $(document).on('click', '.modal-ubah', function() {
                $('#modal-form').modal('show');
                const id = $(this).data('id');

                $.get('/api/subcategories/' + id, function({
                    data
                }) {
                    $('input[name="nama_subkategori"]').val(data.nama_subkategori);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                });
                $('.form-subkategori').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: `api/subcategories/${id}?_method=PUT`,
                        type: 'POST',
                        data: frmdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer' + token);
                        },
                        success: function(data) {
                            // console.log(data);
                            // return
                            if (data.success) {
                                alert('Data Berhasil Diubah!!!')
                                location.reload();
                            }
                        }
                    })
                });
            });
        });
    </script>
@endpush
