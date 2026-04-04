@extends('layouts.user_layout')

@section('content')

<div class="container mt-4">

    <div class="mb-4">
        <h2 class="fw-bold">👋 Welcome, {{ auth()->user()->name }}</h2>
        <p class="text-muted">Manage your notes and uploads easily</p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <div class="mb-2 fs-1">📒</div>
                    <h6 class="text-muted">My Notes</h6>
                    <h3 class="fw-bold">{{$totalNotes}}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <div class="mb-2 fs-1">🌍</div>
                    <h6 class="text-muted">Public Notes</h6>
                    <h3 class="fw-bold text-success">{{$publicNotesCount}}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <div class="mb-2 fs-1">🔒</div>
                    <h6 class="text-muted">Private Notes</h6>
                    <h3 class="fw-bold text-danger">{{$privateNotesCount}}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-5">
    <h5 class="mb-3">Quick Actions</h5>

    <div class="d-flex gap-2">
        <a href="{{url('user/upload_notes')}}" class="btn btn-primary btn-sm">
            ⬆ Upload Note
        </a>

        <a href="{{url('user/list_notes')}}" class="btn btn-outline-secondary btn-sm">
            📑 View My Notes
        </a>
    </div>
</div>

</div>

@endsection