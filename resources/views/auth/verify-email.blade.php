<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('favicon-256.png') }}">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Verifikasi Email | Mriki Project</title>

  <!-- Google Font (same as login) -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ===== FIX: NO SCROLL TOTAL (desktop + mobile) ===== */
    *{ box-sizing: border-box; }
    html, body{
      height: 100%;
      margin: 0;
      overflow: hidden;
    }
    body{
      font-family: "Josefin Sans", sans-serif;
      background: #13283d;
      overscroll-behavior: none;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    :root{
      --brand-red:#e53637;
      --brand-purple:#8a5cff;

      --card: rgba(255,255,255,.12);
      --card2: rgba(255,255,255,.10);
      --border: rgba(255,255,255,.18);

      --text: rgba(255,255,255,.94);
      --muted: rgba(255,255,255,.78);
      --radius: 16px;
    }

    /* ===== Background ===== */
    .mriki-bg{
      height: 100dvh;
      width: 100%;
      display:flex;
      align-items:center;
      justify-content:center;
      padding: clamp(12px, 2vw, 24px);
      position: relative;
      isolation: isolate;
      overflow: hidden;
      background: linear-gradient(135deg,
        #244a6d 0%,
        #1f3f5f 35%,
        #17324c 75%,
        #13283d 100%);
    }

    .mriki-bg::before{
      content:"";
      position:absolute;
      inset:-25%;
      z-index:-2;
      background:
        radial-gradient(900px 520px at 18% 22%, rgba(90,160,255,.24), transparent 62%),
        radial-gradient(900px 520px at 82% 18%, rgba(138,92,255,.18), transparent 62%),
        radial-gradient(900px 520px at 70% 88%, rgba(229,54,55,.14), transparent 62%);
      filter: blur(22px);
      opacity: .95;
      animation: softShift 18s ease-in-out infinite alternate;
      transform: translateZ(0);
      will-change: transform;
    }

    .mriki-bg::after{
      content:"";
      position:absolute;
      inset:0;
      z-index:-1;
      background:
        radial-gradient(900px 560px at 20% 30%, rgba(255,255,255,.08), transparent 62%),
        radial-gradient(900px 620px at 85% 70%, rgba(255,255,255,.05), transparent 65%);
      opacity: .9;
      animation: softBreath 14s ease-in-out infinite alternate;
      pointer-events:none;
      transform: translateZ(0);
      will-change: opacity, transform;
    }

    @keyframes softShift{
      0%   { transform: translate3d(-0.5%, -0.35%, 0) scale(1.02); }
      100% { transform: translate3d(0.5%, 0.35%, 0) scale(1.03); }
    }
    @keyframes softBreath{
      0%   { opacity:.78; transform: translate3d(0,0,0) scale(1); }
      100% { opacity:.92; transform: translate3d(0.25%,-0.2%,0) scale(1.01); }
    }

    .blob{
      position:absolute;
      border-radius: 999px;
      filter: blur(36px);
      opacity:.55;
      z-index:-1;
      pointer-events:none;
      transform: translateZ(0);
      will-change: transform;
    }
    .blob.blob1{
      width: 520px; height: 520px;
      left: -220px; top: -220px;
      background: radial-gradient(circle at 30% 30%, rgba(229,54,55,.18), rgba(229,54,55,0) 68%);
      animation: blobA 20s ease-in-out infinite alternate;
    }
    .blob.blob2{
      width: 660px; height: 660px;
      right: -280px; top: 8%;
      background: radial-gradient(circle at 40% 40%, rgba(90,160,255,.18), rgba(90,160,255,0) 68%);
      animation: blobB 24s ease-in-out infinite alternate;
    }
    @keyframes blobA{
      0%   { transform: translate(-6px, -6px) scale(1); }
      100% { transform: translate(18px, 14px) scale(1.05); }
    }
    @keyframes blobB{
      0%   { transform: translate(8px, 0px) scale(1); }
      100% { transform: translate(-18px, 16px) scale(1.04); }
    }

    /* ===== Card ===== */
    .mriki-card{
      width: min(560px, 100%);
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: 0 18px 70px rgba(0,0,0,.20);
      overflow:hidden;
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
    }

    .mriki-card__header{
      padding: 18px 20px 14px;
      border-bottom: 1px solid rgba(255,255,255,.14);
      display:flex;
      gap: 14px;
      align-items:center;
    }

    .mriki-logo{
      width: 52px; height: 52px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--brand-red), var(--brand-purple));
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 12px 26px rgba(0,0,0,.16);
      flex:0 0 auto;
    }
    .mriki-logo svg{ width: 24px; height: 24px; color:#fff; }

    .mriki-card__title{
      margin:0;
      font-family:"Play", sans-serif;
      font-weight: 800;
      font-size: 22px;
      color: var(--text);
      line-height: 1.1;
    }
    .mriki-card__subtitle{
      margin: 6px 0 0;
      color: var(--muted);
      font-size: 14px;
      line-height: 1.45;
    }

    .mriki-card__body{ padding: 16px 20px 20px; }

    .mriki-info{
      color: rgba(255,255,255,.88);
      font-size: 14px;
      line-height: 1.55;
      margin: 0;
    }

    .mriki-status{
      margin-top: 12px;
      background: rgba(52,199,89,.18);
      border: 1px solid rgba(52,199,89,.35);
      color:#e8ffe8;
      border-radius: 12px;
      padding:10px 12px;
      font-size: 14px;
      line-height: 1.45;
    }

    .mriki-row{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      flex-wrap:wrap;
      margin-top: 16px;
    }

    .mriki-btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      background: var(--brand-red);
      border: 1px solid var(--brand-red);
      color:#fff;
      border-radius: 12px;
      padding: 12px 16px;
      font-family:"Play", sans-serif;
      font-weight: 800;
      letter-spacing: .2px;
      cursor:pointer;
      width: 100%;
    }
    @media (min-width: 520px){ .mriki-btn{ width:auto; } }
    .mriki-btn:hover{ filter: brightness(1.06); }

    .mriki-link-btn{
      background: transparent;
      border: 1px solid rgba(255,255,255,.22);
      color: rgba(255,255,255,.92);
      border-radius: 12px;
      padding: 12px 16px;
      font-family:"Play", sans-serif;
      font-weight: 800;
      letter-spacing: .2px;
      cursor:pointer;
      width: 100%;
    }
    @media (min-width: 520px){ .mriki-link-btn{ width:auto; } }
    .mriki-link-btn:hover{ background: rgba(255,255,255,.08); }

    .mriki-footer{
      margin-top: 14px;
      color: rgba(255,255,255,.70);
      font-size: 12px;
      text-align:center;
    }

    @media (prefers-reduced-motion: reduce){
      .mriki-bg::before, .mriki-bg::after, .blob { animation: none !important; }
    }
  </style>
</head>

<body>
  <div class="mriki-bg">
    <div class="blob blob1" aria-hidden="true"></div>
    <div class="blob blob2" aria-hidden="true"></div>

    <section class="mriki-card">
      <div class="mriki-card__header">
        <a href="{{ route('home') }}" aria-label="Kembali ke beranda" style="text-decoration:none">
          <div class="mriki-logo">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2l8 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8l8-6z" stroke="currentColor" stroke-width="1.6"/>
              <path d="M9 22V12h6v10" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </div>
        </a>

        <div>
          <h1 class="mriki-card__title">Verifikasi Email</h1>
          <p class="mriki-card__subtitle">Cek inbox kamu untuk link verifikasi.</p>

          @if (session('status') == 'verification-link-sent')
            <div class="mriki-status">
              Link verifikasi baru sudah dikirim ke email kamu.
            </div>
          @endif
        </div>
      </div>

      <div class="mriki-card__body">
        <p class="mriki-info">
          Terima kasih sudah daftar! Sebelum lanjut, silakan verifikasi email kamu dengan klik link yang kami kirim.
          Kalau belum menerima email, kamu bisa kirim ulang link verifikasi di bawah.
        </p>

        <div class="mriki-row">
          <form method="POST" action="{{ route('verification.send') }}" style="margin:0;">
            @csrf
            <button type="submit" class="mriki-btn">Kirim Ulang Email Verifikasi</button>
          </form>

          <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="mriki-link-btn">Log Out</button>
          </form>
        </div>

        <div class="mriki-footer">
          © <script>document.write(new Date().getFullYear());</script> Mriki_Project
        </div>
      </div>
    </section>
  </div>
</body>
</html>
