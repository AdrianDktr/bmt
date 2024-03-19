@extends('layouts.app')

@section('content')
<div id="carouselAboutUs" class="carousel slide d-flex flex-column" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('assets/slide/bg/DJI_0686.JPG') }}" class="d-block w-100 img-fluid center-block" alt="...">
            <div class="carousel-caption d-none d-md-block position-absolute top-50 start-50 translate-middle">
                <h3>Tondok bakaru </h5>
                <p>Drone view</p>
            </div>
        </div>
        {{-- <div class="carousel-item">
            <img src="{{ asset('assets/slide/bg/DSCF6878.JPG') }}" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Some representative placeholder content for the second slide.</p>
            </div>
        </div> --}}
        {{-- <div class="carousel-item">
            <img src="{{ asset('assets/slide/bg/DSCF8539.JPG') }}" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>Some representative placeholder content for the third slide.</p>
            </div>
        </div> --}}
    </div>
    {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselAboutUs" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span classs="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselAboutUs" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button> --}}
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col text-center">
            <h2>Selamat datang di Busur Mamasa!</h2>
            <p>Kami adalah platform yang didedikasikan untuk memperkenalkan Anda pada informasi seputar Mamasa, sebuah destinasi yang tak terlupakan di Indonesia. Dengan semangat #mengenalMamasa, kami berkomitmen untuk menghadirkan kepada Anda cerita-cerita inspiratif, informasi terkini, dan panduan perjalanan yang membawa Anda menjelajahi setiap sudut keajaiban Mamasa.</p>
            <p>Kami percaya bahwa setiap detik yang dihabiskan di sini adalah sebuah petualangan yang membangkitkan semangat, menyentuh hati, dan memperkaya jiwa. Bergabunglah dengan kami dalam perjalanan ini untuk mengeksplorasi kekayaan budaya, sejarah yang kaya, serta keindahan alam yang menakjubkan dari Mamasa. Bersama-sama, mari kita menelusuri keajaiban Syurga yang tersembunyi di Bumi Kondosapata!</p>
        </div>
    </div>
</div>
<hr>
<h1 class="display-5 text-center">Our Team</h1>
<br>
    {{-- baris founder --}}
    <div class="row gy-6" style="margin: auto">
        <div class="col-md-6 offset-md-3 text-center" style="text-align: center">
            <img src="{{ asset('assets/founding/blek1.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover;" alt="Avatar">
            <h3 class="mt-3">Ashraf Fikri Yathier</h2>
            <p style="font-size: 19px">Director</p>
        </div>
    </div>
    {{-- baris 1 --}}
    <div class="row gy-3 mt-4" style="margin: auto">
        {{-- 3 foto --}}
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/Adrian.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: center 50%;" alt="Avatar">
            <h4 class="mt-3">Adrian Adhi Wicaksana</h3>
            <p style="font-size: 17px">Head of IT Division</p>
        </div>
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/ardi.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: center 50%;" alt="Avatar">
            <h4 class="mt-3">Ardiansyah</h3>
            <p style="font-size: 17px">Content Creator & Videographer</p>
        </div>
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/Burhan.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: top;" alt="Avatar">
            <h4 class="mt-3">Burhan Mangewa</h3>
            <p style="font-size: 17px">Head of Content Creator & Videographer</p>
        </div>
        {{-- baris 2 --}}
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/farhan.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: center 50%;" alt="Avatar">
            <h4 class="mt-3">Farhan Rahmat</h3>
            <p style="font-size: 17px">Author I</p>
        </div>
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/haliq.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: center 50%;" alt="Avatar">
            <h4 class="mt-3">Haly Potret</h3>
            <p style="font-size: 17px">Social Media Manager & Photographer</p>
        </div>
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/kevin2.png') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: top;" alt="Avatar">
            <h4 class="mt-3">Kevin</h3>
            <p style="font-size: 17px">IT Front-End Developer</p>
        </div>
        {{-- baris 3 --}}
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/mursalin.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover; object-position: top;" alt="Avatar">
            <h4 class="mt-3">Mursalin Mustamin</h3>
            <p style="font-size: 17px">Head of Public Relations </p>
        </div>
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/riswan.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover;" alt="Avatar">
            <h4 class="mt-3">Riswan Sakir</h3>
            <p style="font-size: 17px">Public Relations</p>
        </div>
        <div class="col-lg-4 center-block" style="text-align: center">
            <img src="{{ asset('assets/founding/Zulfihadi.jpg') }}" class="rounded-circle" width="100" height="100" style="object-fit: cover;" alt="Avatar">
            <h4 class="mt-3">Zulfihadi</h3>
            <p style="font-size: 17px">Author II</p>
        </div>
    </div>
</div>

<hr>
<div class="row me-auto">
    <div class="col-md-7">
        <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It’ll blow your mind.</span></h2>
        <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting prose here.</p>
    </div>
    <div class="col-md-5 d-flex align-items-center justify-content-center">
        <img src="{{ asset('path/to/your/image.jpg') }}" class="img-fluid" alt="Placeholder Image">
    </div>
</div>





@endsection
