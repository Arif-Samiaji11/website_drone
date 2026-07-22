<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-white leading-tight">
      {{ __('Profile') }}
    </h2>
  </x-slot>

  <!-- Google Fonts (Videograph Theme) -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Style Khusus Tema Gelap Slate-Blue / Navy -->
  <style>
    .vg-theme {
      font-family: 'Play', sans-serif;
      background-color: #1a2035;
      color: #fff;
    }

    .vg-profile-card {
      background: #202940;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    /* Style Form Inputs & Labels */
    .vg-label {
      display: block;
      font-family: 'Josefin Sans', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: rgba(255, 255, 255, 0.94);
      margin-bottom: 8px;
    }

    .vg-input {
      width: 100%;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 12px 16px;
      color: #fff;
      font-size: 14px;
      outline: none;
      transition: all 0.3s ease;
      font-family: 'Josefin Sans', sans-serif;
    }

    .vg-input:focus {
      border-color: #ff003c;
      box-shadow: 0 0 0 3px rgba(255, 0, 60, 0.2);
      background: rgba(255, 255, 255, 0.08);
    }

    .vg-input::placeholder {
      color: rgba(255, 255, 255, 0.4);
    }

    /* Action Buttons */
    .vg-btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 28px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 13px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #fff;
      background: #ff003c;
      border: 1px solid #ff003c;
      transition: all 0.3s ease;
      cursor: pointer;
      text-decoration: none !important;
    }

    .vg-btn-primary:hover {
      background: transparent;
      color: #ff003c;
      transform: translateY(-2px);
    }

    .vg-btn-danger {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 28px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 13px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #fff;
      background: #ff003c;
      border: 1px solid #ff003c;
      transition: all 0.3s ease;
      cursor: pointer;
      text-decoration: none !important;
    }

    .vg-btn-danger:hover {
      background: transparent;
      color: #ff003c;
      transform: translateY(-2px);
    }

    .vg-btn-secondary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 28px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 13px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.15);
      background: rgba(255, 255, 255, 0.05);
      transition: all 0.3s ease;
      cursor: pointer;
      text-decoration: none !important;
    }

    .vg-btn-secondary:hover {
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.3);
      color: #fff;
      transform: translateY(-2px);
    }

    /* Descriptions & Errors */
    .vg-desc {
      font-family: 'Josefin Sans', sans-serif;
      font-size: 14px;
      line-height: 1.6;
      color: rgba(255, 255, 255, 0.7);
    }

    .vg-error {
      font-family: 'Josefin Sans', sans-serif;
      color: #ffd0d0;
      font-size: 13px;
      margin-top: 6px;
      line-height: 1.4;
    }
  </style>

  <div class="py-12 vg-theme">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
      
      {{-- Card 1: Update Profile Info --}}
      <div class="vg-profile-card">
        <div class="max-w-2xl">
          @include('profile.partials.update-profile-information-form')
        </div>
      </div>

      {{-- Card 2: Update Password --}}
      <div class="vg-profile-card">
        <div class="max-w-2xl">
          @include('profile.partials.update-password-form')
        </div>
      </div>

      {{-- Card 3: Delete User --}}
      <div class="vg-profile-card">
        <div class="max-w-2xl">
          @include('profile.partials.delete-user-form')
        </div>
      </div>

    </div>
  </div>
</x-app-layout>
