@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom text-left">
    <h1 class="h2">Edit Profil</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- Form Update Profile Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Form Update Password -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Form Delete User -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
