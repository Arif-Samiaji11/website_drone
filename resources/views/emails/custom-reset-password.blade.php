@php
    // Membuat URL reset password secara otomatis menggunakan APP_URL terbaru
    $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Mriki Project</title>
    <!-- Font Google agar serupa dengan login & website -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&family=Josefin+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #13283d !important;
            font-family: 'Josefin Sans', 'Play', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                padding: 10px !important;
            }
            .content-box {
                padding: 30px 20px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #13283d; -webkit-text-size-adjust: none; text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #13283d; padding: 40px 10px;">
        <tr>
            <td align="center">
                <!-- Wrapper Box -->
                <table class="email-container" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; width: 100%;">
                    
                    <!-- Logo Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <!-- Menyisipkan gambar dari folder public secara langsung -->
                            <img src="{{ $message->embed(public_path('img/logo.png')) }}" alt="Mriki Project Logo" style="height: 50px; width: auto; display: block; object-fit: contain;">
                        </td>
                    </tr>

                    <!-- Main Content Card (Disamakan dengan mriki-card login) -->
                    <tr>
                        <td class="content-box" style="background-color: #1d354d; border-top: 4px solid #e53637; border-left: 1px solid rgba(255,255,255,.18); border-right: 1px solid rgba(255,255,255,.18); border-bottom: 1px solid rgba(255,255,255,.18); border-radius: 16px; padding: 40px 40px; box-shadow: 0 18px 70px rgba(0,0,0,.20);">
                            
                            <!-- Sub-header -->
                            <span style="display: block; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: rgba(255, 255, 255, 0.6); margin-bottom: 10px; font-weight: 700; text-align: center;">
                                WEBSITE RESMI MRIKI_PROJECT
                            </span>

                            <!-- Headline -->
                            <h2 style="font-size: 24px; color: rgba(255,255,255,.94); margin-top: 0; margin-bottom: 20px; font-weight: 800; text-align: center; font-family: 'Play', sans-serif; letter-spacing: .2px;">
                                Atur Ulang Kata Sandi
                            </h2>

                            <p style="font-size: 15px; color: rgba(255,255,255,.86); line-height: 1.6; margin-bottom: 25px; text-align: center; font-family: 'Josefin Sans', sans-serif;">
                                Halo! Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Silakan klik tombol di bawah ini untuk melanjutkan proses reset password.
                            </p>

                            <!-- Button Center -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 10px 0 25px 0;">
                                        <!-- Tombol Desain Rounded 12px Merah khas Mriki Project Login -->
                                        <a href="{{ $resetUrl }}" style="background-color: #e53637; border: 1px solid #e53637; border-radius: 12px; color: #ffffff; display: inline-block; font-size: 14px; font-weight: 800; letter-spacing: 0.5px; padding: 14px 35px; text-decoration: none; text-transform: uppercase; font-family: 'Play', sans-serif; transition: all 0.3s ease;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Expiry Note -->
                            <p style="font-size: 13px; color: rgba(255,255,255,.6); line-height: 1.6; margin-top: 20px; margin-bottom: 10px; text-align: center; font-style: italic; font-family: 'Josefin Sans', sans-serif;">
                                *Tautan reset password ini hanya berlaku selama 60 menit.
                            </p>

                            <p style="font-size: 14px; color: rgba(255,255,255,.78); line-height: 1.6; margin-top: 20px; margin-bottom: 0; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.14); padding-top: 20px; font-family: 'Josefin Sans', sans-serif;">
                                Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan saja email ini.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer Area -->
                    <tr>
                        <td align="center" style="padding-top: 30px;">
                            
                            <!-- Troubleshooting Link -->
                            <p style="font-size: 11px; color: rgba(255,255,255,.70); line-height: 1.5; text-align: center; max-width: 500px; margin-bottom: 20px; font-family: 'Josefin Sans', sans-serif;">
                                Jika Anda mengalami kesulitan menekan tombol "Reset Password", salin dan tempel tautan di bawah ini ke peramban (browser) Anda:<br>
                                <a href="{{ $resetUrl }}" style="color: #e53637; text-decoration: underline; word-break: break-all;">
                                    {{ $resetUrl }}
                                </a>
                            </p>

                            <!-- Copyright -->
                            <p style="font-size: 11px; color: rgba(255,255,255,.6); text-align: center; margin: 0; text-transform: uppercase; letter-spacing: 1px; font-family: 'Play', sans-serif;">
                                &copy; {{ date('Y') }} Mriki_Project. All Rights Reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>