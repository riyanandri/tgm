@extends('layouts.template')

@section('content')
    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-center mb-4">Login</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <input type="email" class="form-control" id="email" placeholder="Masukkan email" required>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control" id="password" placeholder="Masukkan password" required>
                                    </div>
                                </div>
                                {{--                            <div class="mb-3 text-end">--}}
                                {{--                                <a href="#" class="text-muted">Lupa password?</a>--}}
                                {{--                            </div>--}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                            {{--                        <div class="mt-2 text-center">--}}
                            {{--                            <a href="#" class="text-muted">Don't have an account? Create one</a>--}}
                            {{--                        </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
