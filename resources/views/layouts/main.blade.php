<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Font Awesome -->
        <link
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet"
        />
        <!-- Google Fonts -->
        <link
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet"
        />
        <!-- MDB -->
        <link
          href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css"
          rel="stylesheet"
        />

        <!-- MDB -->
        <script
          type="text/javascript"
          src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"
        ></script>

        <!-- css -->
        <link rel="stylesheet" type="text/css" href="/css/style-navbar.css">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">

        <!-- Jquery.js -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js"></script>
        <!-- Jquery Mask Plugin -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

        <!-- script.js -->
        <script type="text/javascript" src="/js/script.js"></script>
        
        <!-- ajaxRequest -->
        <script type="text/javascript" src="/js/ajaxRequest.js"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- tiny-slider.css -->
        <!--<link rel="stylesheet" href="../css/tiny-slider.css">-->

        <!-- Fonts do Google (Allura) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">

        <!-- Navbar -->
        <nav class="navbar navbar-light  fixed-top" style="background-color: #508bfc;">
          <div class="container">
            <a class="navbar-brand text-white">
              <i class="far fa-comments fa-2x"></i> 
                <span class="h1 fw-bold mb-0" style=" font-size: 30px; margin-left: 6%; margin-top: 10px; font-family: 'Allura', cursive;">Chat</span>
            </a>

            <!-- Right elements -->
            <div class="d-flex align-items-center">
              
              <!-- Avatar -->
              <div class="dropdown">
                <a
                  class="dropdown-toggle d-flex align-items-center hidden-arrow"
                  href="#"
                  id="navbarDropdownMenuAvatar"
                  role="button"
                  data-mdb-toggle="dropdown"
                  aria-expanded="false"
                >
                  <img id="imgProfiles" style="object-fit: cover; border: solid 2px; border-color: white;" class="rounded-circle"
                      height="35" width="35" alt="Avatar" loading="lazy" />
                </a>
                <ul
                  class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="navbarDropdownMenuAvatar"
                >
                  <li>
                    <a class="dropdown-item" onclick="showProfile()" style="cursor: pointer;">Meu Perfil</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">Sair</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- Right elements -->
          </div>
        </nav>
        <!-- Navbar -->
        
    </head>
    <body>
        <div class="add-spinner"></div>
        <div class="bg-loading">
       	@yield('content')
        </div>
    </body>
</html>