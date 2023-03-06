@extends('layout.app')

@section('title', 'Data Slider')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data Slider
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
                            <th>Nama Slider</th>
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
                    <h5 class="modal-title">Form Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-kategori">
                                {{-- <input type="hidden" name="type" id=""> --}}
                                <div class="form-group">
                                    <label for="">Nama Slider</label>
                                    <input type="text" class="form-control" name="nama_slider" id="nama_slider"
                                        placeholder="Nama Slider" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Deskripsi Slider</label>
                                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" id="" cols="30" rows="10"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Gambar Slider</label>
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
                url: '/api/sliders',
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
                            <td>${val.nama_slider}</td>
                            <td>${val.deskripsi}</td>
                            <td><img src="/uploads/slider/${val.gambar}" width="150"></td>
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
                confirm_dialog = confirm('Apakah anda yakin akan hapus slider ini ?');


                if (confirm_dialog) {
                    $.ajax({
                        url: '/api/sliders/' + id,
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
                $('input[name="nama_slider"]').val('');
                $('input[textarea="deskripsi"]').val('');

                $('.form-kategori').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: 'api/sliders',
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

                $.get('/api/sliders/' + id, function({
                    data
                }) {
                    $('input[name="nama_slider"]').val(data.nama_slider);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                });
                $('.form-kategori').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: `api/sliders/${id}?_method=PUT`,
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
