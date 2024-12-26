<section class="mb-5">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Hapus Akun') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
                    </p>
                </header>

                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeletionModal">{{ __('Hapus Akun') }}</button>

                <div class="modal fade" id="confirmDeletionModal" tabindex="-1" aria-labelledby="confirmDeletionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeletionModalLabel">{{ __('Confirm Deletion') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')
                                <div class="modal-body">
                                    <p>{{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi.') }}</p>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Password') }}</label>
                                        <input id="password" name="password" type="password" class="form-control">
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('Hapus Akun') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>