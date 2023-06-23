<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">
    <title>Login</title>

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
    <link rel="stylesheet" type="text/css" href="/css/styles.css">

    <!-- js -->
    <script type="text/javascript" src="/js/script.js"></script>

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

    <!-- Fonts do Google (Allura) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">

</head>
<body>
    <div class="login-spinner"></div>
    <div class="bg-loading-login">
    <section class="vh-100" style="background-color: #508bfc;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            {{-- Login --}}
            <div class="card shadow-2-strong" id="divLogin" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">

                <h3 class="mb-5" style="color: #508bfc;"><i class="far fa-comments" style="color: #508bfc;"></i> Login</h3>

                <form id="login">
                @csrf
                <div class="mb-4">
                  <input type="email" name="email" required class="form-control form-control-lg" placeholder="Email" />
                </div>

                <div class="mb-4">
                  <input type="password" name="password" required id="password" class="form-control form-control-lg" placeholder="Senha" />
                </div>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-start mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="viewPassLogin" onclick="viewPass()"/>
                  <label class="form-check-label" for="viewPassLogin"> Mostrar senha </label>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">
                  <div class="spinner-border spinner-border-sm" id="spin" style="visibility: hidden; position: absolute; margin-left: -20px; margin-top:2px;" role="status">
                  </div>
                  Login
                </button>

                <hr class="my-4">
                <span>Não tem uma conta? </span>
                <a class="small" onclick="formRegister()" style="cursor: pointer;">Cadastre-se</a>
                </form>

              </div>
            </div>

            {{-- Registro --}}
            <div class="card shadow-2-strong" id="divRegister" style="border-radius: 1rem; display: none;">
              <div class="card-body p-5 text-center">
                <button class="btn btn-primary" onclick="formRegister()" style="position: absolute; top: 0; left:0; margin-top:2%; margin-left: 2%;">
                <i class="fas fa-arrow-left"></i>
                </button>
                <h3 class="mb-5" style="color: #508bfc;"><i class="far fa-comments" style="color: #508bfc;"></i> Registro</h3>

                <form id="register">
                @csrf

                <div class="profile-userpic">
                  <label id="labelProfile" for="fileProfile">
                  <img src="/img/profile.png" id="imgProfile" class="img-responsive" alt=""></label>
                  <input type="file" class="disabilitar" name="fileProfile" id="fileProfile" accept=".png, .jpeg, .jpg" required>
                </div>

                <div class="mb-4">
                  <input type="text" name="name" id="name" required class="form-control form-control-lg inputRegister" placeholder="Nome" />
                </div>

                <div class="mb-4">
                  <input type="email" name="email" id="email" required class="form-control form-control-lg inputRegister" placeholder="Email" />
                </div>

                <div class="mb-4">
                  <input type="password" name="pass" required id="pass" class="form-control form-control-lg inputRegister" placeholder="Senha" />
                </div>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-start mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="viewPass" onclick="viewPassRegister()"/>
                  <label class="form-check-label" for="viewPass"> Mostrar senha </label>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">
                  <div class="spinner-border spinner-border-sm" id="spin2" style="visibility: hidden; position: absolute; margin-left: -20px; margin-top:2px;" role="status">
                  </div>
                  Registrar
                </button>
                </form>

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    </div>
    @include('sweetalert::alert',['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>
</html>