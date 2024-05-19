<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center">
        <div>
                <h1>Daftar Transaksi</h1>
            </div>
    </div>
    
    <div class="container d-flex align-items-center justify-content-center">
        <div class="mt-3">
            
            
            <table class="table table-bordered text-center" id="product-table">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No Transaksi</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Customer</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="row">Sub Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Ongkir</th>
                    <th scope="col">Total</th>
                </tr>
                </thead>
                @foreach ($sales as $item)
                <tbody>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['kode'] }}</td>
                    <td>{{ $item['tgl'] }}</td>
                    <td>{{ $item->customer['name'] }}</td>
                    <td></td>
                    <td>{{ $item['subtotal'] }}</td>
                    <td><input type="number" name="diskon" class="form-control" value="{{ $item['diskon'] }}"></td>
                    <td><input type="number" name="ongkir" class="form-control" value="{{ $item['ongkir'] }}"></td>
                    <td> <input type="number" name="total" class="form-control" value="{{ $item['total_bayar'] }}"></td>
                </tbody>
                @endforeach

                <tfoot>
                    <tr>
                        <td colspan="8"><strong>Grand Total</strong></td>
                        <td><input type="number" id="grand-total" readonly class="form-control"></td>
                    </tr>
                    
                </tfoot>

            </table>

            <div class="container fluid">
                <div class="container">
                    <a class="btn btn-primary" href="/transaksi">Transaksi</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script  src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>

    <script>

        Calucalte();

        function Calucalte() {
            var sum = 0;
            var amts = document.getElementsByName("total");

            for (let i = 0; i < amts.length; i++) {
                var amt = amts[i].value;
                sum = +(sum) + +(amt);
            }
            var subTotal = document.getElementById("grand-total").value = sum.toFixed(2);

            // $(document).on('change','#sub-total', function() {

            // var diskon = parseFloat($('#diskon').val()) || 0;
            // var ongkir = parseFloat($('#ongkir').val()) || 0;
            // var Sub = parseFloat($('#sub-total').val()) || 0;
            // var hasil = Sub - (diskon + ongkir);
            
            // document.getElementById('grand-total').value = hasil.toFixed(2);
            // });
        }
    </script>

</body>
</html>