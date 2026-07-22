<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('favicon-256.png') }}">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register | Mriki Project</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    *{ box-sizing: border-box; }
    html, body{
      height: 100%;
      margin: 0;
      overflow: hidden; /* NO SCROLL */
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

    /* ===== Background (soft modern) ===== */
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

    label{
      display:block;
      color: var(--text);
      font-weight: 700;
      margin-bottom: 6px;
      letter-spacing: .15px;
    }

    .mriki-input{
      width:100%;
      background: var(--card2);
      border: 1px solid rgba(255,255,255,.18);
      border-radius: 12px;
      padding: 12px 14px;
      color: #fff;
      font-size: 14px;
      outline: none;
      transition: all 0.2s ease;
    }
    .mriki-input::placeholder{ color: rgba(255,255,255,.72); }
    .mriki-input:focus{
      border-color: rgba(229,54,55,.95);
      box-shadow: 0 0 0 3px rgba(229,54,55,.20);
      background: rgba(255,255,255,.12);
    }

    /* Validasi Input Error State */
    .mriki-input.is-invalid {
      border-color: #ff4d4d !important;
      box-shadow: 0 0 0 3px rgba(255, 77, 77, 0.25) !important;
    }

    .mriki-row{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      flex-wrap:wrap;
      margin-top: 14px;
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

    .mriki-link{
      color: rgba(255,255,255,.92);
      text-decoration: underline;
      text-underline-offset: 2px;
      white-space: nowrap;
    }
    .mriki-link:hover{ opacity:.85; }

    .mriki-error{
      margin-top: 8px;
      color: #ffd0d0;
      font-size: 13px;
      line-height: 1.4;
    }

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
          <h1 class="mriki-card__title">Register</h1>
          <p class="mriki-card__subtitle">Daftar akun baru pakai email asli kamu.</p>
        </div>
      </div>

      <div class="mriki-card__body">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          {{-- Name --}}
          <div>
            <label for="name">Name</label>
            <input
              id="name"
              class="mriki-input"
              type="text"
              name="name"
              value="{{ old('name') }}"
              required
              autofocus
              autocomplete="name"
              placeholder="Nama kamu"
            />
            <div id="name-error" class="mriki-error">
              @if ($errors->has('name'))
                @foreach ($errors->get('name') as $msg)
                  <div>{{ $msg }}</div>
                @endforeach
              @endif
            </div>
          </div>

          {{-- Email --}}
          <div style="margin-top:14px;">
            <label for="email">Email</label>
            <input
              id="email"
              class="mriki-input"
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              autocomplete="username"
              placeholder="emailkamu@gmail.com"
            />
            <div id="email-error" class="mriki-error">
              @if ($errors->has('email'))
                @foreach ($errors->get('email') as $msg)
                  <div>{{ $msg }}</div>
                @endforeach
              @endif
            </div>
          </div>

          {{-- Password --}}
          <div style="margin-top:14px;">
            <label for="password">Password</label>
            <input
              id="password"
              class="mriki-input"
              type="password"
              name="password"
              required
              autocomplete="new-password"
              placeholder="Buat password (min. 8 karakter)"
            />
            <div id="password-error" class="mriki-error">
              @if ($errors->has('password'))
                @foreach ($errors->get('password') as $msg)
                  <div>{{ $msg }}</div>
                @endforeach
              @endif
            </div>
          </div>

          {{-- Confirm Password --}}
          <div style="margin-top:14px;">
            <label for="password_confirmation">Confirm Password</label>
            <input
              id="password_confirmation"
              class="mriki-input"
              type="password"
              name="password_confirmation"
              required
              autocomplete="new-password"
              placeholder="Ulangi password"
            />
            <div id="password_confirmation-error" class="mriki-error">
              @if ($errors->has('password_confirmation'))
                @foreach ($errors->get('password_confirmation') as $msg)
                  <div>{{ $msg }}</div>
                @endforeach
              @endif
            </div>
          </div>

          <div class="mriki-row">
            <a class="mriki-link" href="{{ route('login') }}">Sudah punya akun? Login</a>
            <button type="submit" class="mriki-btn">Register</button>
          </div>

          <div class="mriki-footer">
            © <script>document.write(new Date().getFullYear());</script> Mriki_Project
          </div>
        </form>
      </div>
    </section>
  </div>

  <!-- JAVASCRIPT VALIDASI REAL-TIME & CEK DATABASE -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      const nameInput = document.getElementById('name');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const passwordConfirmInput = document.getElementById('password_confirmation');

      const nameError = document.getElementById('name-error');
      const emailError = document.getElementById('email-error');
      const passwordError = document.getElementById('password-error');
      const passwordConfirmError = document.getElementById('password_confirmation-error');

      let debounceTimer;
      let isEmailAvailable = true; // Flag status ketersediaan email di database

      // 1. Validasi Nama
      function validateName() {
        const name = nameInput.value.trim();
        if (name === '') {
          showError(nameInput, nameError, 'Nama wajib diisi.');
          return false;
        } else {
          clearError(nameInput, nameError);
          return true;
        }
      }

      // 2. Validasi Format Email
      function validateEmail() {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === '') {
          showError(emailInput, emailError, 'Alamat email wajib diisi.');
          isEmailAvailable = false;
          return false;
        } else if (!emailRegex.test(email)) {
          showError(emailInput, emailError, 'Format alamat email tidak valid.');
          isEmailAvailable = false;
          return false;
        } else {
          clearError(emailInput, emailError);
          return true;
        }
      }

      // AJAX Check Email availability ke /check-email (dengan debounce 500ms)
      function checkEmailAvailability() {
        clearTimeout(debounceTimer);
        const email = emailInput.value.trim();
        
        if (email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return;

        debounceTimer = setTimeout(() => {
          fetch("{{ url('/check-email') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
          })
          .then(response => response.json())
          .then(data => {
            if (data.exists) {
              isEmailAvailable = false;
              showError(emailInput, emailError, 'Email sudah tersedia, silahkan gunakan alamat email yang lain.');
            } else {
              isEmailAvailable = true;
              clearError(emailInput, emailError);
            }
          })
          .catch(err => {
            console.error('Error saat memeriksa ketersediaan email:', err);
          });
        }, 500);
      }

      // 3. Validasi Panjang Password (Min. 8 Karakter)
      function validatePassword() {
        const password = passwordInput.value;
        if (password === '') {
          showError(passwordInput, passwordError, 'Password wajib diisi.');
          return false;
        } else if (password.length < 8) {
          showError(passwordInput, passwordError, 'Password minimal harus terdiri dari 8 karakter.');
          return false;
        } else {
          clearError(passwordInput, passwordError);
          if (passwordConfirmInput.value !== '') {
            validatePasswordConfirm();
          }
          return true;
        }
      }

      // 4. Validasi Kesamaan Konfirmasi Password
      function validatePasswordConfirm() {
        const password = passwordInput.value;
        const confirm = passwordConfirmInput.value;
        
        if (confirm === '') {
          showError(passwordConfirmInput, passwordConfirmError, 'Konfirmasi password wajib diisi.');
          return false;
        } else if (confirm !== password) {
          showError(passwordConfirmInput, passwordConfirmError, 'Konfirmasi password tidak cocok / tidak sama.');
          return false;
        } else {
          clearError(passwordConfirmInput, passwordConfirmError);
          return true;
        }
      }

      // Helper: Tampilkan error
      function showError(input, errorElement, message) {
        input.classList.add('is-invalid');
        errorElement.innerHTML = `<div>${message}</div>`;
      }

      // Helper: Hapus error
      function clearError(input, errorElement) {
        input.classList.remove('is-invalid');
        errorElement.innerHTML = '';
      }

      // Input Event Listeners
      nameInput.addEventListener('input', validateName);
      passwordInput.addEventListener('input', validatePassword);
      passwordConfirmInput.addEventListener('input', validatePasswordConfirm);
      
      // Validasi format email & trigger AJAX check
      emailInput.addEventListener('input', function() {
        if (validateEmail()) {
          checkEmailAvailability();
        }
      });

      // Validasi saat form dikirim (Submit)
      form.addEventListener('submit', function(event) {
        const isNameValid = validateName();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isConfirmValid = validatePasswordConfirm();

        // Jika ada input tidak valid atau email sudah terdaftar di database
        if (!isNameValid || !isEmailValid || !isPasswordValid || !isConfirmValid || !isEmailAvailable) {
          event.preventDefault(); // Batalkan submit form
          
          if (!isNameValid) {
            nameInput.focus();
          } else if (!isEmailValid || !isEmailAvailable) {
            emailInput.focus();
            if (!isEmailAvailable && isEmailValid) {
              showError(emailInput, emailError, 'Email sudah tersedia, silahkan gunakan alamat email yang lain.');
            }
          } else if (!isPasswordValid) {
            passwordInput.focus();
          } else if (!isConfirmValid) {
            passwordConfirmInput.focus();
          }
        }
      });
    });
  </script>
</body>
</html>