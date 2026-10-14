@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}


@endsection

@section('content')
    <style>
        .modal-header {
            background: linear-gradient(to right, #78c046, #26a9cd);
            color: white;
        }

        .btn:hover {
            color: black;
        }

        .btn1:hover {
            color: black;
        }

        .btn-modal {
            color: #fff;
            background: linear-gradient(to right, #78c046, #26a9cd);
            font-weight: bold;
            border-radius: 8px;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px !important;
            font-family: "Archivo", sans-serif;
            font-size: 15px !important;
            margin: 0px 5px 5px 0px;
            border: 1px solid #ccc;

        }

        .btn-modal:hover {
            background: #fff !important;
            color: black;
            transition: all 1s ease-in-out;
        }

        .cnt {
            background-color: white;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            border-radius: 10px;
            padding: 20px;
            / left: 20%;/
        }

        .modal-header {
            background: linear-gradient(to right, #78c046, #26a9cd);
            color: white;
            font-size: 17px;
            padding: 7px 10px;
        }

        .modal-title {
            margin-bottom: 0;
            line-height: var(--bs-modal-title-line-height);
            font-size: 17px;
        }

        .close {
            border: none;
            color: white;
            background-color: transparent;
            font-size: 22px;
        }


        .email-fr {
            border: 1px solid lightgrey !important;
            margin: 20px 0px 30px 0px !important;
            padding: 15px !important;
        }

        .modal-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            pointer-events: none;
        }
    </style>
    <main>
        <section class="login-area section-gap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="wrapper-login">
                      @include('common.alert')
                        <!-- @if (session('error'))
                            <span class="text-danger"> {{ session('error') }}</span>
                        @endif -->
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <h2 class="text-center">Login</h2>
                                <div class="input-box ">
                                    <input type="email" placeholder="Username" name="email"  class="form-control  @error('email') is-invalid @enderror" @if(isset($_COOKIE['email'])) value="{{ $_COOKIE['email'] }}" @endif
                                        required />
                                    <i class='bx bxs-user'></i>
                                                 @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                </div>
                                <div class="input-box">
                                    <input type="password" placeholder="Password"
                                        class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                        name="password" @if(isset($_COOKIE['password'])) value="{{ $_COOKIE['password'] }}" @endif autocomplete="current-password" required />
                                    <i class='bx bxs-lock-alt'></i>
                                </div>
                                <!-- <div class="remember-forgot">
                                    <label>
                                        <input type="checkbox">
                                        Remember me
                                    </label>
                                    <a type="button" class="text-white" onclick="openForgetPasswordModal()">Forget
                                        Password</a>
                                </div> -->
                                <div class="remember-forgot">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" @if(isset($_COOKIE['email'])) checked="" @endif>
                                        Remember me
                                    </label>
                                    <a type="button" class="text-white" onclick="openForgetPasswordModal()">Forgot Password</a>
                                </div>
                                <button type="submit" class="btn">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
    <div class="modal" id="forgetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Forgot Your Password?</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeForgetPasswordModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('forgetpasswordpost')}}" method="Post">
                        @csrf
                        <div class="text-center ">
                            <p>If you have forgotten your password you can reset it here.</p>

                            <div class="form-group input-box">
                                <input class="form-control email email-fr" placeholder="E-mail Address" name="email"
                                    type="email">
                            </div>
                            <div class="d-flex justify-content-center">
                                <input class="btn-modal justify-content-center" value="Send My Password" type="submit">
                                <button class="btn-modal justify-content-center" data-dismiss="modal"
                                    aria-hidden="true">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openForgetPasswordModal() {
            var modal = document.getElementById("forgetPasswordModal");
            modal.style.display = "block";
        }

        function closeForgetPasswordModal() {
            var modal = document.getElementById("forgetPasswordModal");
            modal.style.display = "none";
        }
    </script>

@endsection
