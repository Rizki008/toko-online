@extends('layout.app')

@section('title', 'Tentang')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data Tentang
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-tentang" method="POST" enctype="multipart/form-data"
                        action="/tentang/{{ $about->id }}">
                        {{-- <input type="hidden" name="type" id=""> --}}
                        @csrf
                        <div class="form-group">
                            <label for="">Judul Website</label>
                            <input type="text" class="form-control" name="judul_website" id="judul_website"
                                placeholder="Judul Website" required value="{{ $about->judul_website }}">
                        </div>
                        <img src="/uploads/about/{{ $about->logo }}" alt="" width="200">
                        <div class="form-group">
                            <label for="">Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo">
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi </label>
                            <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" id="" cols="30" rows="10"
                                required>{{ $about->deskripsi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" placeholder="Alamat" class="form-control" id="" cols="30" rows="10"
                                required>{{ $about->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                                required value="{{ $about->email }}">
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input type="text" class="form-control" name="telepon" id="telepon" placeholder="Telepon"
                                required value="{{ $about->telepon }}">
                        </div>
                        <div class="form-group">
                            <label for="">Atas Nama</label>
                            <input type="text" class="form-control" name="atas_nama" id="atas_nama"
                                placeholder="Atas Nama" required value="{{ $about->atas_nama }}">
                        </div>
                        <div class="form-group">
                            <label for="">No Rekening</label>
                            <input type="text" class="form-control" name="no_rekening" id="no_rekening"
                                placeholder="No Rekening" required value="{{ $about->no_rekening }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
