<section class="mb-5">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Ubah Password') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}</p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-4">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">{{ __('Password Saat Ini') }}</label>
                        <input id="current_password" name="current_password" type="password" class="form-control">
                        @error('current_password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password Baru') }}</label>
                        <input id="password" name="password" type="password" class="form-control">
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Password') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                    </div>
                </form>
            </section>