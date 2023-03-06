@extends('layout.app')

@section('title', 'Data Testimoni')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data Testimoni
            </h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah Data</a>
                {{-- <a href="/kategori/create" class="btn btn-primary">Tambah Data</a> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hove table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Testimoni</th>
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
                    <h5 class="modal-title">Form Testimoni</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-testimoni">
                                {{-- <input type="hidden" name="type" id=""> --}}
                                <div class="form-group">
                                    <label for="">Nama Testimoni</label>
                                    <input type="text" class="form-control" name="nama_testimoni" id="nama_testimoni"
                                        placeholder="Nama Testimoni" required>
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
                url: '/api/testimonis',
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
                            <td>${val.nama_testimoni}</td>
                            <td>${val.deskripsi}</td>
                            <td><img src="/uploads/testimoni/${val.gambar}" width="150"></td>
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
                // const token = localStorage.getItem('token');
                const token = getCookie('token');
                // console.log(token);
                // return;
                // console.log(id);
                confirm_dialog = confirm('Apakah anda yakin akan hapus katagori ini ?');


                if (confirm_dialog) {
                    $.ajax({
                        url: '/api/testimonis/' + id,
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
                $('input[name="nama_testimoni"]').val('');
                $('input[textarea="deskripsi"]').val('');

                $('.form-testimoni').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: 'api/testimonis',
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

                $.get('/api/testimonis/' + id, function({
                    data
                }) {
                    $('input[name="nama_testimoni"]').val(data.nama_testimoni);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                });
                $('.form-testimoni').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: `api/testimonis/${id}?_method=PUT`,
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
