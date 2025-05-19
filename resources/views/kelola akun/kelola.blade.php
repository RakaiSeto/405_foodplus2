<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Donatur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <style>
        body {
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary {
            background: #70B9B0;
            color: white;
        }
        .btn-secondary {
            background: gray;
            color: black;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kelola Akun Donatur</h1>
    </div>

    <div class="form-container">
        <form id="kelolaAkunForm" onsubmit="handleSubmit(event)">
            <div class="form-group">
                <label for="nama">Nama Donatur</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Donatur</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Non Aktif</option>
                </select>
            </div>

            <div class="button-container">
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function handleSubmit(event) {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin menyimpan perubahan?')) {
                alert('Data berhasil disimpan!');
                window.location.href = "{{ route('dashboard') }}";
            }
        }

        function cancelEdit() {
            if (confirm('Apakah Anda yakin ingin membatalkan perubahan?')) {
                window.location.href = "{{ route('dashboard') }}";
            }
        }
    </script>
    @endpush

    @stack('scripts')
</body>
</html>