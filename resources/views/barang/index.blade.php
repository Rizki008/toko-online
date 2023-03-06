@extends('layout.app')

@section('title', 'Data Product')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data Product
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
                            <th>Nama katagori</th>
                            <th>Nama Subkatagori</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Diskon Produk</th>
                            <th>Bahan Produk</th>
                            <th>Tags Produk</th>
                            <th>Sku Produk</th>
                            <th>Ukuran Produk</th>
                            <th>Warna Produk</th>
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
                    <h5 class="modal-title">Form Product</h5>
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
                                    <label for="">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_barang" id="nama_barang"
                                        placeholder="Nama Produk" required>
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
                                    <label for="">Nama Subkategori</label>
                                    <select name="id_subkategori" id="id_subkategori" class="form-control">
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->nama_subkategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Harga Produk</label>
                                    <input type="text" class="form-control" name="harga" id="harga"
                                        placeholder="Harga Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Diskon Produk</label>
                                    <input type="text" class="form-control" name="diskon" id="diskon"
                                        placeholder="Diskon Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Bahan Produk</label>
                                    <input type="text" class="form-control" name="bahan" id="bahan"
                                        placeholder="Nama Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Tags Produk</label>
                                    <input type="text" class="form-control" name="tags" id="tags"
                                        placeholder="Tags Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">SKU Produk</label>
                                    <input type="text" class="form-control" name="sku" id="sku"
                                        placeholder="SKU Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Ukuran Produk</label>
                                    <input type="text" class="form-control" name="ukuran" id="ukuran"
                                        placeholder="Ukuran Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Warna</label>
                                    <input type="text" class="form-control" name="warna" id="warna"
                                        placeholder="Warna Produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Deskripsi Kategiri</label>
                                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" id="" cols="30" rows="10"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Gambar Kategiri</label>
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
                url: '/api/products',
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
                            <td>${val.nama_barang}</td>
                            <td>${val.category.nama_kategori}</td>
                            <td>${val.subcategory.nama_subkategori}</td>
                            <td>${val.harga}</td>
                            <td>${val.diskon}</td>
                            <td>${val.bahan}</td>
                            <td>${val.tags}</td>
                            <td>${val.sku}</td>
                            <td>${val.ukuran}</td>
                            <td>${val.warna}</td>
                            <td>${val.deskripsi}</td>
                            <td><img src="/uploads/product/${val.gambar}" width="150"></td>
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
                        url: '/api/products/' + id,
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
                $('input[name="nama_barang"]').val('');
                $('input[name="nama_kategori"]').val('');
                $('input[name="nama_subkategori"]').val('');
                $('input[name="harga"]').val('');
                $('input[name="diskon"]').val('');
                $('input[name="bahan"]').val('');
                $('input[name="tags"]').val('');
                $('input[name="sku"]').val('');
                $('input[name="ukuran"]').val('');
                $('input[name="warna"]').val('');
                $('input[textarea="deskripsi"]').val('');

                $('.form-kategori').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: 'api/products',
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

                $.get('/api/products/' + id, function({
                    data
                }) {
                    $('input[name="nama_barang"]').val(data.nama_barang);
                    $('input[name="nama_kategori"]').val(data.nama_kategori);
                    $('input[name="nama_subkategori"]').val(data.nama_subkategori);
                    $('input[name="harga"]').val(data.harga);
                    $('input[name="diskon"]').val(data.diskon);
                    $('input[name="bahan"]').val(data.bahan);
                    $('input[name="tags"]').val(data.tags);
                    $('input[name="sku"]').val(data.sku);
                    $('input[name="ukuran"]').val(data.ukuran);
                    $('input[name="warna"]').val(data.warna);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                });
                $('.form-kategori').submit(function(e) {
                    e.preventDefault()
                    const token = getCookie('token');

                    const frmdata = new FormData(this)
                    // console.log(frmdata);
                    // return
                    $.ajax({
                        url: `api/products/${id}?_method=PUT`,
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
