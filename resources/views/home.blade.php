@extends('layouts.template')

@section('content')
    <!-- Call to Action Image Slider -->
    <section id="cta-slider" class="carousel slide cta-section" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="cta-image1.jpg" class="d-block w-100" alt="Image 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Join Our Reading Community</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img src="cta-image2.jpg" class="d-block w-100" alt="Image 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Read, Learn, and Grow Together</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img src="cta-image3.jpg" class="d-block w-100" alt="Image 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Discover the World Through Books</h5>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#cta-slider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cta-slider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <!-- Cards Section with Icons -->
    <section class="cards-section mb-lg-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <a href="{{ route('books') }}" class="text-decoration-none">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-book-fill display-4 mb-3"></i>
                                <h5 class="card-title">Data Buku</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('readers') }}" class="text-decoration-none">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-people-fill display-4 mb-3"></i>
                                <h5 class="card-title">Data Pembaca</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('read.activity') }}" class="text-decoration-none">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-journal-richtext display-4 mb-3"></i>
                                <h5 class="card-title">Data Membaca</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('reading.statistic') }}" class="text-decoration-none">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-journal-richtext display-4 mb-3"></i>
                                <h5 class="card-title">TGM</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- Favorite Books Section -->
    <section class="books-section mb-lg-5">
        <div class="container">
            <h3 class="text-center mb-4">Daftar Buku Terfavorit</h3>
            <div id="book-slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="book1.jpg" class="card-img-top" alt="Book 1">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Title 1</h5>
                                        <p class="card-text">Description of book 1.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="book2.jpg" class="card-img-top" alt="Book 2">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Title 2</h5>
                                        <p class="card-text">Description of book 2.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="book3.jpg" class="card-img-top" alt="Book 3">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Title 3</h5>
                                        <p class="card-text">Description of book 3.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="book4.jpg" class="card-img-top" alt="Book 4">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Title 4</h5>
                                        <p class="card-text">Description of book 4.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="book5.jpg" class="card-img-top" alt="Book 5">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Title 5</h5>
                                        <p class="card-text">Description of book 5.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="book6.jpg" class="card-img-top" alt="Book 6">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Title 6</h5>
                                        <p class="card-text">Description of book 6.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#book-slider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#book-slider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- User Ranking Section -->
    <section class="ranking-section mb-lg-5">
        <div class="container">
            <h3 class="text-center mb-4">Ranking Pengguna Teraktif</h3>
            <div class="row text-center">
                <div class="col-md-4">
                    <h4>1. User A</h4>
                    <p>Jumlah Buku Dibaca: 120</p>
                </div>
                <div class="col-md-4">
                    <h4>2. User B</h4>
                    <p>Jumlah Buku Dibaca: 98</p>
                </div>
                <div class="col-md-4">
                    <h4>3. User C</h4>
                    <p>Jumlah Buku Dibaca: 75</p>
                </div>
            </div>
        </div>
    </section>
@endsection
