<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/assets/images/logo-white.svg') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      .description-container .description {
          width: 100%;
          word-wrap: break-word;
          overflow-wrap: break-word;
      }

      .description-container img {
        max-width: 100%;
      }

      .description-container figcaption{
        text-align: center;
      }

      .description-container figure .media{
        border: 1px solid #000;
        width: 100px;
      }
      .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 300px;
        padding: 12px 15px;
        border-radius: 4px;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .custom-alert.show {
        opacity: 1;
        transform: translateY(0);
    }
    .custom-alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    .custom-alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    .custom-alert-content {
        display: flex;
        align-items: center;
        flex-grow: 1;
        margin-right: 10px;
    }
    .custom-alert-icon {
        margin-right: 10px;
        font-size: 1.2em;
    }
    .custom-alert-message {
        line-height: 1.4;
        font-size: 14px;
    }
    .custom-alert-close {
        font-size: 1.2em;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        cursor: pointer;
        padding-left: 10px;
    }
    .custom-alert-close:hover {
        opacity: .75;
    }
    </style>
  </head>
  <body style="font-family: 'Poppins', sans-serif;">
    @if(Session::has('success') || Session::has('error'))
    <div id="customAlert" class="custom-alert {{ Session::has('success') ? 'custom-alert-success' : 'custom-alert-error' }}">
        <div class="custom-alert-content">
          <span class="custom-alert-icon">
              @if(Session::has('success'))
                  <i class="bx bx-check-circle"></i>
              @else
                  <i class="bx bx-error-circle"></i>
              @endif
          </span>
          <span class="custom-alert-message">{{ Session::get('success') ?? Session::get('error') }}</span>
        </div>
        <span class="custom-alert-close" onclick="closeAlert()">&times;</span>
        </div>
    @endif
    @include('layouts.frontend.navbar')
    @yield('content')
    @include('layouts.frontend.footer')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          var alert = document.getElementById('customAlert');
          if (alert) {
              setTimeout(function() {
                  alert.classList.add('show');
              }, 100);
              setTimeout(function() {
                  closeAlert();
              }, 5000);
          }
      });

      function closeAlert() {
          var alert = document.getElementById('customAlert');
          if (alert) {
              alert.classList.remove('show');
              setTimeout(function() {
                  alert.remove();
              }, 300);
          }
      }
    </script>
    @stack('scripts')
  </body>
</html>