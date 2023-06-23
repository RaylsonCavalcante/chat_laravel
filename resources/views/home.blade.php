@extends('layouts.main')

@section('title', 'Chat')

@section('content')

  <section style="background-color: #508bfc;">
    <div class="container py-5">

      <div class="row">
        <div class="col-md-12">

          <div class="card" id="chat3" style="border-radius: 15px; width:100; margin-top: 6%;">
            <div class="card-body">

              <div class="row">
                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                  <div class="p-3">

                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 450px; overflow: auto;">
                      <ul class="list-unstyled mb-0">
                        {{-- List Users --}}
                      </ul>
                    </div>

                  </div>

                </div>

                <div class="col-md-6 col-lg-7 col-xl-8 align-self-center" id="iconLogo">
                  <div style="color: #508bfc;">
                    <center>
                    <i class="far fa-comments fa-9x" style="margin-right: 7px;"></i> 
                    <span class="h1 fw-bold mb-0" style=" font-size: 120px; margin-top: 10px; font-family: 'Allura', cursive;">Chat</span><br>
                    <span style="font-style: oblique;">Envie mensagens de onde e quando quiser.</span>
                    </center>
                  </div>
                </div>

                <div class="col-md-6 col-lg-7 col-xl-8" style="display: none;" id="screenMessages">

                  <div class="pt-3 pe-3 messages" data-mdb-perfect-scrollbar="true"
                    style="position: relative; height: 400px; overflow: auto;">
                    {{-- Messages --}}
                  </div>

                  <div id="inputMessage" class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2" style="display: none;">
                      <img alt="Avatar Message" id="imgMessage" style="width: 40px; height: 100%;">
                      <input type="text" class="form-control form-control-lg" id="message" placeholder="Digite a mensagem">
                      <a class="ms-4 btn btn-primary disabled" onclick="sendMessage()" id="btnMessage"><i style="font-size: 15px;" class="fas fa-paper-plane"></i></a>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

@endsection