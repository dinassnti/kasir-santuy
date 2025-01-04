<section class="mb-5">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Informasi Profile') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ __("Perbarui informasi profil dan alamat email akun Anda.") }}</p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="nama" class="form-label">{{ __('Nama') }}</label>
                        <input id="nama" name="nama" type="text" class="form-control" value="{{ old('nama', $user->nama) }}" required autofocus>
                        @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="text-sm text-muted">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="btn btn-link p-0">{{ __('
                                        Klik di sini untuk mengirim ulang email verifikasi.') }}</button>
                                </p>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="text-sm text-success mt-1">{{ __('Tautan verifikasi baru telah dikirimkan ke alamat email Anda.') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Tampilan Role (readonly) -->
                    <div class="mb-3">
                        <label for="role" class="form-label">{{ __('Role') }}</label>
                        <input id="role" name="role" type="text" class="form-control" value="{{ $user->role }}" readonly>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                    </div>
                </form>
            </section>