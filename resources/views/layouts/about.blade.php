@extends('layouts.app')

@section('content')
<div id="carouselAboutUs" class="carousel slide d-flex flex-column" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('assets/slide/bg/DJI_0686.JPG') }}" class="d-block w-100 img-fluid center-block" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h3>Tempat </h5>
                <p>perbaikan apa saja di daerah tsb</p>
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

<div class="container mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Selamat datang di Busur Mamasa!</h2>
            <p>Kami adalah platform yang didedikasikan untuk memperkenalkan Anda pada informasi seputar Mamasa, sebuah destinasi yang tak terlupakan di Indonesia. Dengan semangat #mengenalMamasa, kami berkomitmen untuk menghadirkan kepada Anda cerita-cerita inspiratif, informasi terkini, dan panduan perjalanan yang membawa Anda menjelajahi setiap sudut keajaiban Mamasa.</p>
            <p>Kami percaya bahwa setiap detik yang dihabiskan di sini adalah sebuah petualangan yang membangkitkan semangat, menyentuh hati, dan memperkaya jiwa. Bergabunglah dengan kami dalam perjalanan ini untuk mengeksplorasi kekayaan budaya, sejarah yang kaya, serta keindahan alam yang menakjubkan dari Mamasa. Bersama-sama, mari kita menelusuri keajaiban Syurga yang tersembunyi di Bumi Kondosapata!</p>
        </div>
    </div>
</div>





@endsection
