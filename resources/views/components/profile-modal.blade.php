@auth
    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-bold" id="profileModalLabel">Profil Saya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Left Column: Photo & Read-only Info -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block mb-3">
                                    @php
                                        $photo = Auth::user()->profile_photo_path;
                                        if ($photo && str_starts_with($photo, 'http')) {
                                            $photoUrl = $photo;
                                        } else {
                                            $photoUrl = $photo
                                                ? asset('storage/' . $photo)
                                                : asset('images/placeholder-profile.webp');
                                        }
                                    @endphp
                                    <img src="{{ $photoUrl }}" id="profilePhotoPreview"
                                        class="rounded-circle object-fit-cover shadow-sm border"
                                        style="width: 150px; height: 150px;" alt="Profile Photo">
                                    <label for="profile_photo"
                                        class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm p-2 cursor-pointer border"
                                        style="width: 40px; height: 40px; cursor: pointer;">
                                        <i class="bi bi-camera-fill text-primary"></i>
                                        <input type="file" name="profile_photo" id="profile_photo" class="d-none"
                                            accept="image/png, image/jpeg" onchange="previewImage(this)">
                                    </label>
                                </div>
                                <small class="text-muted d-block mb-3">Format: JPG, PNG. Maks 2MB.</small>

                                <div class="bg-light p-3 rounded-3 text-start">
                                    <div class="mb-2">
                                        <small class="text-secondary d-block">Email</small>
                                        <span class="fw-bold text-dark text-break">{{ Auth::user()->email }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-secondary d-block">Poin Loyalty</small>
                                        <span
                                            class="fw-bold text-warning">{{ number_format(Auth::user()->points ?? 0, 0, ',', '.') }}
                                            Poin</span>
                                    </div>
                                    <div>
                                        <small class="text-secondary d-block">Status Member</small>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ Auth::user()->member_status ?? 'Aktif' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Editable Form -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nama_user" class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_user" name="nama_user"
                                        value="{{ Auth::user()->nama_user }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label fw-semibold">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ Auth::user()->phone_number }}" placeholder="Contoh: 08123456789">
                                </div>
                                <div class="mb-4">
                                    <label for="address" class="form-label fw-semibold">Alamat Lengkap</label>
                                    <textarea class="form-control" id="address" name="address" rows="4" maxlength="500"
                                        placeholder="Masukkan alamat lengkap pengiriman...">{{ Auth::user()->address }}</textarea>
                                    <div class="form-text text-end"><span id="addressCount">0</span>/500</div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold"
                                        id="btnSaveProfile">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePhotoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('address').addEventListener('input', function() {
            document.getElementById('addressCount').textContent = this.value.length;
        });

        // Initial count
        document.getElementById('addressCount').textContent = document.getElementById('address').value.length;
    </script>
@endauth
