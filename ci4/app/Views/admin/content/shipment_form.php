<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Alamat Pengiriman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #result {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Form Input Alamat Pengiriman</h1>
    <form id="shippingForm" action="#" method="POST">
        <label for="name">Nama Penerima</label>
        <input type="text" id="name" name="name" placeholder="Masukkan nama penerima" required>

        <label for="phone">Nomor Telepon</label>
        <input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>

        <label for="address">Alamat Lengkap</label>
        <textarea id="address" name="address" rows="4" placeholder="Masukkan alamat lengkap" required></textarea>

        <label for="city">Kota/Kabupaten</label>
        <input type="text" id="city" name="city" placeholder="Masukkan kota atau kabupaten" required>

        <label for="postal">Kode Pos</label>
        <input type="text" id="postal" name="postal" placeholder="Masukkan kode pos" required>

        <button type="button" onclick="showResult()">Kirim</button>
    </form>

    <div id="result" style="display: none;">
        <h2>Hasil Input Alamat Pengiriman</h2>
        <p><strong>Nama Penerima:</strong> <span id="resultName"></span></p>
        <p><strong>Nomor Telepon:</strong> <span id="resultPhone"></span></p>
        <p><strong>Alamat Lengkap:</strong> <span id="resultAddress"></span></p>
        <p><strong>Kota/Kabupaten:</strong> <span id="resultCity"></span></p>
        <p><strong>Kode Pos:</strong> <span id="resultPostal"></span></p>
        <button onclick="window.print()">Print</button>
    </div>

    <script>
        function showResult() {
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const postal = document.getElementById('postal').value;

            document.getElementById('resultName').textContent = name;
            document.getElementById('resultPhone').textContent = phone;
            document.getElementById('resultAddress').textContent = address;
            document.getElementById('resultCity').textContent = city;
            document.getElementById('resultPostal').textContent = postal;

            document.getElementById('result').style.display = 'block';
        }
    </script>
</body>
</html>
