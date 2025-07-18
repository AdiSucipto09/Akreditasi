<x-app-layout>
    <x-slot name="header">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kerjasama Penelitian') }}
            </h2>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
            </button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border">No</th>
                            <th class="px-4 py-2 border">Lembaga Mitra</th>
                            <th class="px-4 py-2 border">Tingkat</th>
                            <th class="px-4 py-2 border">Judul Kegiatan</th>
                            <th class="px-4 py-2 border">Waktu</th>
                            <th class="px-4 py-2 border">Realisasi Kerjasama</th>
                            <th class="px-4 py-2 border">SPK</th>
                            <th class="px-4 py-2 border">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kerjasama_penelitian as $kerjasamapenelitian)
                            <tr>
                                <td class="px-1 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $kerjasamapenelitian->lembaga_mitra }}</td>
                                <td class="px-4 py-2 border">{{ $kerjasamapenelitian->tingkat }}</td>
                                <td class="px-4 py-2 border">{{ $kerjasamapenelitian->judul_kegiatan }}</td>
                                <td class="px-4 py-2 border">{{ $kerjasamapenelitian->waktu_durasi }}</td>
                                <td class="px-4 py-2 border">{{ $kerjasamapenelitian->realisasi_kerjasama }}</td>
                                <td class="px-4 py-2 border">{{ $kerjasamapenelitian->spk == 1 ? 'Ya' : 'Tidak' }}</td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $kerjasamapenelitian->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $kerjasamapenelitian->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pages.kerjasama_penelitian.update', $kerjasamapenelitian->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id" value="{{ $kerjasamapenelitian->id }}">
            
                                                <div class="mb-3">
                                                    <label for="lembaga_mitra" class="form-label">Lembaga Mitra:</label>
                                                    <input type="text" class="form-control" id="lembaga_mitra" name="lembaga_mitra" value="{{ $kerjasamapenelitian->lembaga_mitra }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat" value="{{ $kerjasamapenelitian->tingkat }}">
                                                      <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                                      <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                      <option value="Lokal/Wilayah" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="judul_kegiatan" class="form-label">Judul Kegiatan:</label>
                                                  <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" value="{{ $kerjasamapenelitian->judul_kegiatan }}" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="waktu_durasi" class="form-label">Waktu:</label>
                                                  <input type="text" class="form-control" id="waktu_durasi" name="waktu_durasi" value="{{ $kerjasamapenelitian->waktu_durasi }}" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="realisasi_kerjasama" class="form-label">Realisasi Kerjasama:</label>
                                                  <input type="text" class="form-control" id="realisasi_kerjasama" name="realisasi_kerjasama" value="{{ $kerjasamapenelitian->realisasi_kerjasama }}" required>
                                              </div>
                                              <div class="form-group">
                                                    <label>SPK</label>
                                                    <select class="form-control" name="spk" value="{{ $kerjasamapenelitian->spk }}">
                                                      <option value="1" {{ old('spk') == '1' ? 'selected' : '' }}>Ya</option>
                                                      <option value="0" {{ old('spk') == '0' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pages.kerjasama_penelitian.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="lembaga_mitra" class="form-label">Lembaga Mitra:</label>
                                        <input type="text" class="form-control" id="lembaga_mitra" name="lembaga_mitra" value="{{ session('lembaga_mitra') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                          <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                          <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                          <option value="Lokal/Wilayah" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan:</label>
                                        <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" value="{{ session('judul_kegiatan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_durasi" class="form-label">Waktu:</label>
                                        <input type="text" class="form-control" id="waktu_durasi" name="waktu_durasi" value="{{ session('waktu_durasi') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="realisasi_kerjasama" class="form-label">Realisasi Kerjasama:</label>
                                        <input type="text" class="form-control" id="realisasi_kerjasama" name="realisasi_kerjasama" value="{{ session('realisasi_kerjasama') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>SPK</label>
                                        <select class="form-control" name="spk">
                                          <option value="1" {{ old('spk') == '1' ? 'selected' : '' }}>Ya</option>
                                          <option value="0" {{ old('spk') == '0' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>   
                  {{-- End Modal --}}

                {{-- @if($users->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada pengguna yang terdaftar.</p>
                @endif --}}
            </div>
        </div>
    </div>
    <script>
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function (event) {
         const button = event.relatedTarget; // Button yang memicu modal
         const recipient = button.getAttribute('data-whatever'); // Ambil data dari button
         const modalTitle = this.querySelector('.modal-title');
         const modalBodyInput = this.querySelector('.modal-body input');
     
         modalTitle.textContent = 'Tambah Visi Misi ';
         // modalBodyInput.value = recipient;
    });
</x-app-layout>