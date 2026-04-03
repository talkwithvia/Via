@extends('layouts.app')

@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Edit User')

@section('content_body')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row">
                    <!-- Name -->
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Contact Number -->
                    <div class="form-group col-md-6">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number"
                            value="{{ old('contact_number', $user->contact_number) }}"
                            class="form-control @error('contact_number') is-invalid @enderror">
                        @error('contact_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- TIN -->
                    <div class="form-group col-md-6">
                        <label>TIN</label>
                        <input type="text" name="tin" value="{{ old('tin', $user->tin) }}" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <!-- Employee Identifier -->
                    <div class="form-group col-md-6">
                        <label>Employee Identifier</label>
                        <input type="text" name="employee_identifier"
                            value="{{ old('employee_identifier', $user->employee_identifier) }}" class="form-control">
                    </div>

                    <!-- Password -->
                    <div class="form-group col-md-6">
                        <label>Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Roles -->
                    <div class="form-group col-12">
                        @if ($roles->count() > 0)
                            <label>Assign Roles</label>
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ ucfirst($role->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
