<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="x-apple-disable-message-reformatting" />
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <title>Verifikasi Email</title>

  <style>
    /* ===== RESET (email-safe) ===== */
    html, body { margin:0 !important; padding:0 !important; height:100% !important; width:100% !important; }
    * { -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; display:block; }
    a { text-decoration:none; }
    table { border-collapse:collapse !important; }

    /* ===== Base ===== */
    body { background:#0f2233; }
    .bg { background:#0f2233; }
    .container { padding: 28px 12px; }

    /* ===== Card width for desktop ===== */
    .card { width: 640px; max-width: 640px; }

    /* ===== Typography ===== */
    .brand { font-family: Arial, Helvetica, sans-serif; font-size:14px; opacity:.95; letter-spacing:.3px; color:#ffffff; }
    .title { font-family: Arial, Helvetica, sans-serif; font-size:22px; line-height:1.25; font-weight:800; color:#ffffff; margin: 10px 0 0; }
    .p { font-family: Arial, Helvetica, sans-serif; font-size:14px; line-height:1.6; color:#334155; margin:0 0 12px; }
    .hi { font-weight:700; color:#0f172a; }
    .muted { font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height:1.6; color:#64748b; word-break:break-word; }
    .footer { font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#94a3b8; text-align:center; }

    /* ===== Button ===== */
    .btn {
      font-family: Arial, Helvetica, sans-serif;
      font-size:14px;
      font-weight:800;
      letter-spacing:.2px;
      background:#e53637;
      color:#ffffff !important;
      display:inline-block;
      padding:14px 18px;
      border-radius:12px;
    }

    /* ===== Divider ===== */
    .hr { height:1px; background:#e2e8f0; line-height:1px; font-size:1px; }

    /* ===== Mobile responsiveness ===== */
    @media screen and (max-width: 680px){
      .card { width: 100% !important; max-width: 100% !important; }
      .pad { padding-left:16px !important; padding-right:16px !important; }
      .title { font-size:20px !important; }
      .btn { width:100% !important; text-align:center !important; }
    }

    /* ===== Dark mode friendly (not perfect on all clients) ===== */
    @media (prefers-color-scheme: dark) {
      body, .bg { background:#0b1220 !important; }
      .body-bg { background:#0b1220 !important; }
      .p { color:#cbd5e1 !important; }
      .hi { color:#ffffff !important; }
      .muted, .footer { color:#94a3b8 !important; }
      .hr { background:#1f2937 !important; }
    }
  </style>
</head>

<body>
  <!-- Preheader (teks kecil yang muncul di preview inbox) -->
  <div style="display:none; font-size:1px; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden;">
    Verifikasi email untuk mengaktifkan akun Mriki Project.
  </div>

  <table role="presentation" width="100%" class="bg" style="background:#0f2233;">
    <tr>
      <td align="center" class="container" style="padding:28px 12px;">

        <!--[if (mso)]>
        <table role="presentation" width="640" align="center" style="width:640px;">
          <tr>
            <td>
        <![endif]-->

        <table role="presentation" class="card" width="100%" align="center" style="width:100%; max-width:640px; background:#ffffff; border-radius:18px; overflow:hidden;">
          <!-- Header -->
          <tr>
            <td style="background: #e53637; background: linear-gradient(135deg, #e53637 0%, #8a5cff 100%); padding:22px 22px;">
              <div class="brand" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; opacity:.95; letter-spacing:.3px; color:#ffffff;">
                MRIKI PROJECT
              </div>
              <div class="title" style="font-family:Arial,Helvetica,sans-serif; font-size:22px; line-height:1.25; font-weight:800; color:#ffffff; margin:10px 0 0;">
                Verifikasi Email Kamu
              </div>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td class="pad body-bg" style="padding:22px; background:#ffffff;">
              <p class="p" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#334155; margin:0 0 12px;">
                <span class="hi" style="font-weight:700; color:#0f172a;">Halo, {{ $name }} 👋</span>
              </p>

              <p class="p" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#334155; margin:0 0 12px;">
                Terima kasih sudah mendaftar di <b>Mriki Project</b>.
                Untuk mengaktifkan akun kamu, silakan verifikasi email dengan menekan tombol di bawah ini.
              </p>

              <!-- Button (table-based, email-safe) -->
              <table role="presentation" cellspacing="0" cellpadding="0" style="margin: 10px 0 6px;">
                <tr>
                  <td style="border-radius:12px;" bgcolor="#e53637">
                    <a href="{{ $verifyUrl }}"
                       target="_blank"
                       rel="noopener"
                       class="btn"
                       style="font-family:Arial,Helvetica,sans-serif; font-size:14px; font-weight:800; letter-spacing:.2px; background:#e53637; color:#ffffff !important; display:inline-block; padding:14px 18px; border-radius:12px;">
                      Verifikasi Email
                    </a>
                  </td>
                </tr>
              </table>

              <p class="p" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#334155; margin:10px 0 8px;">
                Kalau tombol tidak bisa diklik, salin dan buka link ini di browser:
              </p>

              <p class="muted" style="font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:1.6; color:#64748b; word-break:break-word; margin:0 0 12px;">
                {{ $verifyUrl }}
              </p>

              <div class="hr" style="height:1px; background:#e2e8f0; line-height:1px; font-size:1px; margin:18px 0;"></div>

              <p class="p" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#334155; margin:0;">
                Kalau kamu tidak merasa membuat akun, abaikan email ini. Tidak ada perubahan yang terjadi pada akun kamu.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:16px 22px 20px; background:#f8fafc;">
              <div class="footer" style="font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#94a3b8; text-align:center;">
                © {{ date('Y') }} Mriki Project • Email ini dikirim otomatis, mohon tidak membalas.
              </div>
            </td>
          </tr>
        </table>

        <!--[if (mso)]>
            </td>
          </tr>
        </table>
        <![endif]-->

      </td>
    </tr>
  </table>
</body>
</html>
