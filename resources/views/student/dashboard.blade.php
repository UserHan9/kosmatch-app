@php($active = 'dashboard')
@extends('layouts.app')

@section('title', 'Owner Dashboard - LuxHome')
@section('page-title', 'Dashboard')

@section('styles')
    .content-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .content-card h1 {
        font-size: 22px;
        margin-bottom: 12px;
    }

    .content-card p {
        margin-bottom: 8px;
        color: #4b5563;
    }

    .logout-form {
        margin-top: 16px;
    }

    .logout-form button {
        background: #ef4444;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .logout-form button:hover {
        background: #dc2626;
    }
@endsection

@section('content')

    <div class="content-card">
        <h1>User Dashboard</h1>

        <p>
            Selamat datang, {{ auth()->user()->name }}
        </p>

        <p>
            Role: {{ auth()->user()->role }}
        </p>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">Logout</button>
        </form>

        <a href="{{ route('student.kosts.index') }}">
    Cari Kost
</a>

<a href="{{ route('student.bookings.index') }}">
    Booking Saya
</a>
    </div>

@endsection