@extends('layout.app')

@section('title', 'Data Pesanan Diterima')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Data Pesanan Diterima
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hove table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Nama Member</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>Tanggal Pemesanan</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(function() {

            function rupiah(angka) {
                const format = angka.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                return 'Rp ' + convert.join('.').split('').reverse().join('')
            }

            function date(date) {
                var date = new Date(date);
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();

                return `${day}-${month}-${year}`
            }

            const token = getCookie('token');
            $.ajax({
                url: '/api/pesanan/diterima',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer' + token);
                },
                // url: '/api/orders',
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
                            <td>${val.invoice}</td>
                            <td>${val.member.nama_member}</td>
                            <td>${rupiah(val.grand_total)}</td>
                            <td>${val.status}</td>
                            <td>${date(val.created_at)}</td>
                            <td>
                                <a herf="#" data-id="${val.id}" class="btn btn-success btn-aksi">Terima</a>
                            </td>
                        </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            });

            $(document).on('click', '.btn-aksi', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/api/pesanan/ubah_status/' + id,
                    type: 'POST',
                    data: {
                        status: 'Selesai'
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer' + token);
                    },
                    success: function(data) {
                        location.reload();
                        // console.log(data);
                    }
                })
            });
        });
    </script>
@endpush
