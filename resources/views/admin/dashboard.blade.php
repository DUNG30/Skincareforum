@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<style>
    body.dashboard {
        background: url('{{ asset('images/admin-bg.jpg') }}') no-repeat center center fixed;
        background-size: cover;
    }
    .dashboard-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        margin: 20px;
    }
</style>

<div class="dashboard-container">
    <h1>Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $usersCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Categories</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $categoriesCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Posts</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $postsCount }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
