<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi Email - Sagara Jersey</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px;">
        <h2 style="color: #333;">Verifikasi Email Anda</h2>
        <p>Terima kasih telah mendaftar di Sagara Jersey.</p>
        <p>Silakan klik tombol di bawah ini untuk verifikasi email Anda:</p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="<?= base_url('register/verify/' . $token) ?>" 
               style="background-color: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px;">
                Verifikasi Email
            </a>
        </p>
        <p>Jika tombol tidak berfungsi, copy dan paste link berikut:</p>
        <p><?= base_url('register/verify/' . $token) ?></p>
        <hr style="border: none; border-top: 1px solid #eee;">
        <p style="color: #666; font-size: 12px;">Email ini dikirim oleh Sagara Jersey. Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
    </div>
</body>
</html>