@extends('layouts.public')

@section('meta')
{{-- Ini Meta Tag Google Scholar --}}
<meta name="citation_title" content="Judul Buku Dummy">
<meta name="citation_author" content="Dr. Penulis Dummy">
<meta name="citation_publication_date" content="2026/05/10">
<meta name="citation_pdf_url" content="{{ url('/dummy.pdf') }}">
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <a href="/katalog" class="text-green-600 hover:text-green-800 text-sm font-medium mb-4 inline-block"> Kembali ke Katalog</a>
    <h1 class="text-3xl font-bold text-slate-900 mb-2">Judul Buku </h1>
    <p class="text-lg text-slate-600 mb-8">Penulis:  Penulis  | ISBN: 978-000-000-00-1</p>
    
    <x-card>
        <h2 class="text-xl font-semibold mb-4">Abstrak</h2>
        <p class="text-slate-600 mb-6">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, at..</p>
        <x-button type="primary" x-data @click="alert('PDF akan terbuka di sini')">Download Full PDF</x-button>
    </x-card>
</div>
@endsection