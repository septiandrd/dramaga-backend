<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">

    <style>
        .navbar-color {
            background-color: rgb(27, 102, 177);
        }

        .navbar-title {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            color: white;
            font-size: 1.2rem   
        }

        .title {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* font-weight: bold; */
            font-size: 1rem;
            color: white;
            text-align: center;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            background-color:rgb(21, 71, 122);
        }

        .form-container {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border-style: solid;
            border-width: 1px;
        }

        .form-desc {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.8rem;
            text-align: center;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            margin: 1rem;   
        }

        .form-group {
            margin: 1rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1rem;
            text-align: center;
        }

        .form-group ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: gray;
            font-size: 0.8rem;
            text-align: center
        }

        .form-group input {
            text-align: center
        }

        p.upload-desc {
            font-size: 0.8rem;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            color: grey
        }
        
        select {
            text-align-last: center
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm justify-content-center navbar-color">
        <div class="navbar-title">
            SerbaLokal
        </div>
    </nav>
    <div class="col-md-8 container">
        <div class="form-container">
            <div class="title">
                Konfirmasi Pembayaran
            </div>
            <p class="form-desc">
                Terima kasih telah berbelanja di SerbaLokal!
                Bila anda telah melakukan pembayaran secara bank transfer,
                konfirmasikan pembayaran anda disini agar dapat kami proses segera.
            </p>
            <form action="/api/transaction/confirmGet" method="GET">
                <div class="form-group">
                    <label for="transaction_id">Nomor Transaksi</label>
                    <input name="transaction_id" id="transaction_id" type="text" class="form-control" placeholder="Masukkan Nomor Transaksi">
                </div>
                <div class="form-group">
                    <label for="bank-tujuan">Bank Tujuan</label>
                    <select class="form-control" id="bank-tujuan">
                        <option>BCA</option>
                        <option>Mandiri</option>
                        <option>BRI</option>
                        <option>BNI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bank-tujuan">Bank Anda</label>
                    <select class="form-control" id="bank-tujuan">
                        <option>BCA</option>
                        <option>Mandiri</option>
                        <option>BRI</option>
                        <option>BNI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rek-nama">Rekening Atas Nama</label>
                    <input type="text" class="form-control" id="rek-nama" placeholder="Masukkan Nama Anda">
                </div>
                <div class="form-group">
                    <label for="trf-nominal">Nominal Transfer</label>
                    <input type="text" class="form-control" id="trf-nominal" placeholder="Masukkan Nominal">
                </div>
                <div class="form-group">
                    <label for="trf-date">Tanggal Transfer</label>
                    <input type="date" class="form-control" id="trf-date">
                </div>
                <div class="form-group">
                    <label for="trf-date">Bukti Transfer</label>
                    <p class="upload-desc">Max. ukuran file 5 mb. Gunakan format file .jpg, .png atau .bmp</p>
                    <input type="file" class="form-control-file border">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>
