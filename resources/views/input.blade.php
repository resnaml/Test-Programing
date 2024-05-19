<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

    <form action="/transaksi" method="post">
        @csrf
        <div class="container-fluid">
            <div class="container">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row">
                    <h1 class="text-center">Form Input</h1>
                    <div class="card" style="width: 15rem;">
                        <div class="card-body">
                            <h5 class="card-title" >Transaksi</h5>
                            <label>Tanggal</label>
                            <input type="date" name="tgl" class="form-control" id="invoice-date">
                            <label>No</label>
                            <input type="text" name="kode" class="form-control" id="invoice-number">
                        </div>
                    </div>
        
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Customer</h5>
                            <label>Kode</label>
                            <select class="form-select form-select-sm mb-1"  id="select" name="cust_id">
                                <option selected disabled>Pilih Customer</option>
                                @foreach ($customer as $item)
                                <option namme value="{{ $item['id'] }}" 
                                >{{ $item['kode'] }}</option>
                                @endforeach
                            </select>
                            <label for="">Nama</label>
                            <input type="text" id="customer-name" class="form-control" name="" readonly>
                            <label for="">Telp</label>
                            <input type="number" id="customer-telp" class="form-control" name="" readonly>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <table class="table table-bordered text-center" id="product-table">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div class="card">

                                    <select class="form-select form-select-sm" id="product-select">
                                    <option value="Pilih Barang">Select Barang</option>
                                    @foreach($barangs as $barang)
                                    <option value="{{ $barang['id'] }}" data-name="{{ $barang['nama'] }}" data-harga="{{ $barang['harga'] }}">{{ $barang['nama'] }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-success" type="button" id="add-product">Tambah</button>
                                </div>
                            </th>
                            <th scope="col">No</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Harga Bandrol</th>
                            <th class="text-danger" scope="row">(%)</th>
                            <th scope="row">(Rp)</th>
                            <th scope="col">Harga Diskon</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            {{-- Append Disini --}}
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="8"><strong>Sub Total:</strong></td>
                                <td><input type="number" id="sub-total" name="sub_total" readonly class="form-control"></td>
                            </tr>
                            <tr>
                                <td colspan="8"><strong>Diskon</strong></td>
                                <td><input type="number" id="diskon" name="diskon" class="form-control"></td>
                            </tr>
                            <tr>
                                <td colspan="8"><strong>Ongkir</strong></td>
                                <td><input type="number" id="ongkir" name="ongkir" class="form-control"></td>
                            </tr>
                            <tr>
                                <td colspan="8"><strong>Total Bayar</strong></td>
                                <td><input type="number" readonly name="total_bayar" id="total-bayar" class="form-control"></td>
                            </tr>
                            
                        </tfoot>

                    </table>

                    <div class="container fluid">
                        <div class="container">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a class="btn btn-warning">Batal</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script  src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>

<script>
    $(document).ready(function(){
        $('#select').change(function(){
            var costumerId = $(this).val();
            if (costumerId) {
                $.ajax({
                    url : '/costumer/' + costumerId,
                    type: 'GET',
                    success: function(data){
                        $('#customer-name').val(data.name);
                        $('#customer-telp').val(data.telp);
                    }
                });
            } else {
                $('#customer-name').val('');
                $('#customer-telp').val('');
            }
    });

        // no generate
        $(document).ready(function() {
            let invoiceCounter = 1;

            function formatDate(date) {
                const d = new Date(date);
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                const year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month].join('');
            }

            $('#invoice-date').change(function() {
                const selectedDate = $('#invoice-date').val();
                if (!selectedDate) {
                    alert("Please select a date.");
                    return;
                }

                const formattedDate = formatDate(selectedDate);
                const invoiceNumber = `${formattedDate}-${invoiceCounter.toString().padStart(4, '0')}`;
                $('#invoice-number').val(invoiceNumber);
                
                invoiceCounter++;
            });
        });
        // $('#date').click(function(){
        //     var noTransaksi = $(this).val();
        //     $('#no-transaksi').val(noTransaksi);
        // });

        // Tabel 
        $(document).ready(function() {
        $('#add-product').click(function() {
            var selectedOption = $('#product-select option:selected');
            var productId = selectedOption.val();
            var productName = selectedOption.data('name');
            var productPrice = selectedOption.data('harga');
            if (productId) {
                var productRow = '<tr data-product-id="'+ productId + '">' +
                                    '<td><button class="btn btn-warning">Ubah</button><button class="btn btn-danger remove-product">Kurang</button> </td>' +
                                    '<td class="row-number"></td>' +
                                    '<td>' + productName + '</td>' +
                                    '<td hidden ><input type="number"  name="id_barang[]" value="'+productId+'" class="form-control"></td>' +
                                    '<td><input type="number" id="quantity" name="quantity[]" class="form-control"></td>' +
                                    '<td><input type="number" name="harga[]" readonly value="'+ productPrice+'" class="form-control"></td>' +
                                    '<td><input type="number" name="persen[]" id="persen" maxlength="6" pattern="[0-9]*" class="form-control"></td>' +
                                    '<td><input type="number" name="diskon_persen[]" readonly class="form-control"></td>' +
                                    '<td><input type="number" name="diskon_harga[]" readonly class="form-control"></td>' +
                                    '<td><input type="number" name="total[]" readonly class="form-control"></td>' +
                                '</tr>';

                $('#product-table tbody').append(productRow);

                // Reset Box
                $('#product-select').val('');

                // Update number
                updateRowNumbers();
            }
        });

        // increment number row
        function updateRowNumbers() {
            $('#product-table tbody tr').each(function(index) {
                $(this).find('.row-number').text(index + 1);
            });
        }


        $(document).on('click', '.remove-product', function() {
            $(this).closest('tr').remove();
            Calucalte();
            Reset();
        });

        $(document).on('keyup', ('#quantity','#persen'), function() {
        var index = $(this).closest('tr').index();
        
        // Sum cell Qty * HargaDiskon
        var qty = document.getElementsByName("quantity[]")[index].value;
        var harga = document.getElementsByName("harga[]")[index].value;
        var DiskonRp = document.getElementsByName("diskon_persen[]")[index];
        var persen = document.getElementsByName("persen[]")[index].value;
        var HargaDiskon = document.getElementsByName("diskon_harga[]")[index];
        
        // Perhitungan
        hasilPersen = (harga / 100) * persen;
        DiskonRp.value = hasilPersen.toFixed(2);
        totalDiskon = harga - DiskonRp.value;
        HargaDiskon.value = totalDiskon.toFixed(2);
        var total = HargaDiskon.value * qty;

        var Total = document.getElementsByName("total[]")[index].value = total.toFixed(2);
        Calucalte();
        });

        function Calucalte() {
            
            var sum = 0;
            var amts = document.getElementsByName("qty[]");
            var amts = document.getElementsByName("total[]");

            for (let i = 0; i < amts.length; i++) {
                var amt = amts[i].value;
                sum = +(sum) + +(amt);
            }
            var subTotal = document.getElementById("sub-total").value = sum.toFixed(2);

            $(document).on('keyup','#ongkir', function() {

            var diskon = parseFloat($('#diskon').val()) || 0;
            var ongkir = parseFloat($('#ongkir').val()) || 0;
            var Sub = parseFloat($('#sub-total').val()) || 0;
            var hasil = Sub - (diskon + ongkir);
            
            document.getElementById('total-bayar').value = hasil.toFixed(2);
            document.getElementById('total-bayar').value = hasil.toFixed(2);
            });
        }
        
        // reset tabel footer value
        function Reset() {
            $('#diskon').val(0);
            $('#ongkir').val(0);
            $('#sub-total').val(0);
            $('#total-bayar').val(0);
        }
        
    });

    });
</script>
</body>
</html>