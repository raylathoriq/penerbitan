@extends('layouts.public')

@php
    $bookTitle = $book->title ?? 'Judul Buku Dummy';
    $bookAuthor = $book->author ?? 'Dr. Penulis Dummy';
    $bookIsbn = $book->isbn ?? '978-000-000-00-1';
    $bookPublished = optional($book->published_at)->format('Y/m/d') ?? '2026/05/10';
    $bookPdfUrl = $book->pdf_url ? url($book->pdf_url) : url('/dummy.pdf');
@endphp

@section('meta')
{{-- Ini Meta Tag Google Scholar --}}
<meta name="citation_title" content="{{ $bookTitle }}">
<meta name="citation_author" content="{{ $bookAuthor }}">
<meta name="citation_publication_date" content="{{ $bookPublished }}">
<meta name="citation_pdf_url" content="{{ $bookPdfUrl }}">
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <a href="/katalog" class="text-green-600 hover:text-green-800 text-sm font-medium mb-4 inline-block"> Kembali ke Katalog</a>
    <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $bookTitle }}</h1>
    <p class="text-lg text-slate-600 mb-8">Penulis: {{ $bookAuthor }} | ISBN: {{ $bookIsbn }}</p>
    
    <x-card>
        <h2 class="text-xl font-semibold mb-4">Abstrak</h2>
        <p class="text-slate-600 mb-6">{{ $book->abstract ?? 'Abstrak belum tersedia.' }}</p>
        <x-button type="primary" x-data @click="window.location.href='{{ $bookPdfUrl }}'">Download Full PDF</x-button>
    </x-card>
</div>
@endsection