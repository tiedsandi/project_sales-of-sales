@extends('layouts.app')
@section('page-name', 'Login POS')

@section('content')
    <main class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                            <span class="d-none d-lg-block">Point Of Sales</span>
                        </a>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
        
                            <div class="pt-4 pb-2  text-center">
                                
                                <img src="{{asset('assets/image/img.jpeg')}}" alt="" width="80" height="80">
                                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                <p class="text-center small">Enter your email & password to login</p>
                            </div>
        
                            <form class="row g-3 needs-validation" novalidatefg method="post" action="/action-login">
                                @csrf
                                <div class="col-12">
                                <label for="yourUsername" class="form-label">Email
                                    <span class="text-danger small">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="yourUsername" required>
                                </div>
                                </div>
            
                                <div class="col-12">
                                <label for="yourPassword" class="form-label">Password
                                    <span class="text-danger small">*</span>
                                </label>
                                <input type="password" value="{{ old('password') }}" name="password" class="form-control" id="yourPassword" required>
                                </div>
            
                                <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
                                </div>
                            </form>
        
                        </div>
                    </div>
                    <div class="credits">
                        <div class="credits">
                            <script>document.write(new Date().getFullYear())</script> &copy; All Rights Reserved
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
