@extends('layouts.app')

@section('title', 'Bantuan | Tanahku.id')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary">Pusat Bantuan</h1>
    <p class="lead">Berikut beberapa pertanyaan umum dan panduan penggunaan:</p>

    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    Bagaimana cara menambahkan data tanah?
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Kamu bisa klik tombol <strong>+ Tambah Tanah</strong> di halaman peta atau beranda. Isi data dengan lengkap lalu simpan.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                    Siapa yang bisa melihat data saya?
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Semua pengunjung dapat melihat data yang kamu tambahkan. Namun hanya pengguna yang terdaftar yang bisa menambahkan atau mengedit data.
                </div>
            </div>
        </div>

        {{-- Tambah pertanyaan lainnya di sini --}}
    </div>
</div>
@endsection
