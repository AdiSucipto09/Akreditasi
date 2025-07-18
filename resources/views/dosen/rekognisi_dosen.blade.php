<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dosen.dashboard') }}"
                    class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-black-700 text-sm px-3 py-1.5 rounded-lg shadow-sm transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                    {{ __('Rekognisi Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('dosen.rekognisi_dosen') }}"
                    class="flex flex-col md:flex-row md:items-center gap-2">
                    <label for="tahun" class="text-sm font-medium text-gray-700">Tahun Akademik:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="block w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-700 bg-white">
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun->id }}" {{ $tahunTerpilih == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->tahun }} {{ $tahun->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('dosen.rekognisi_dosen.export') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>

                    @if ($tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-500">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border text-sm">No</th>
                            <th class="px-4 py-2 border text-sm">Nama</th>
                            <th class="px-4 py-2 border text-sm">NIDN</th>
                            <th class="px-4 py-2 border text-sm">Nama Kegiatan Rekognisi</th>
                            <th class="px-4 py-2 border text-sm">Tingkat</th>
                            <th class="px-4 py-2 border text-sm">Bahan Ajar</th>
                            <th class="px-4 py-2 border text-sm">Tahun Perolehan</th>
                            <th class="px-4 py-2 border text-sm">Url</th>
                            <th class="px-4 py-2 border text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekognisi_dosen as $rekognisidosen)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisidosen->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisidosen->nidn }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisidosen->nama_kegiatan_rekognisi }}
                                </td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisidosen->tingkat }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisidosen->bahan_ajar }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $rekognisidosen->tahun_perolehan }}</td>
                                <td class="px-1 py-2 border text-sm">
                                    <a href="{{ $rekognisidosen->url }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Link
                                    </a>
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2 text-sm">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $rekognisidosen->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('dosen.rekognisi_dosen.destroy', $rekognisidosen->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $rekognisidosen->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Rekognisi Dosen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('dosen.rekognisi_dosen.update', $rekognisidosen->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $rekognisidosen->id }}">

                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        name="nama" value="{{ $rekognisidosen->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nidn" class="form-label">NIDN:</label>
                                                    <input type="text" class="form-control" id="nidn"
                                                        name="nidn" value="{{ $rekognisidosen->nidn }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_kegiatan_rekognisi" class="form-label">Nama
                                                        Kegiatan Rekognisi:</label>
                                                    <textarea class="form-control" id="nama_kegiatan_rekognisi" name="nama_kegiatan_rekognisi">{{ $rekognisidosen->nama_kegiatan_rekognisi }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat</label>
                                                    <select class="form-control" name="tingkat">
                                                        <option value="Internasional"
                                                            {{ $rekognisidosen->tingkat == 'Internasional' ? 'selected' : '' }}>
                                                            Internasional</option>
                                                        <option value="Nasional"
                                                            {{ $rekognisidosen->tingkat == 'Nasional' ? 'selected' : '' }}>
                                                            Nasional</option>
                                                        <option value="Lokal"
                                                            {{ $rekognisidosen->tingkat == 'Lokal' ? 'selected' : '' }}>
                                                            Lokal</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bahan Ajar</label>
                                                    <select class="form-control" name="bahan_ajar">
                                                        <option value="PPT"
                                                            {{ $rekognisidosen->bahan_ajar == 'PPT' ? 'selected' : '' }}>
                                                            PPT</option>
                                                        <option value="Modul Praktikum"
                                                            {{ $rekognisidosen->bahan_ajar == 'Modul Praktikum' ? 'selected' : '' }}>
                                                            Modul Praktikum</option>
                                                        <option value="Monograf"
                                                            {{ $rekognisidosen->bahan_ajar == 'Monograf' ? 'selected' : '' }}>
                                                            Monograf</option>
                                                        <option value="Diktat"
                                                            {{ $rekognisidosen->bahan_ajar == 'Diktat' ? 'selected' : '' }}>
                                                            Diktat</option>
                                                        <option value="Buku Ajar"
                                                            {{ $rekognisidosen->bahan_ajar == 'Buku Ajar' ? 'selected' : '' }}>
                                                            Buku Ajar</option>
                                                        <option value="Modul Pembelajaran"
                                                            {{ $rekognisidosen->bahan_ajar == 'Modul Pembelajaran' ? 'selected' : '' }}>
                                                            Modul Pembelajaran</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun_perolehan" class="form-label">Tahun
                                                        Perolehan:</label>
                                                    <input type="text" class="form-control" id="tahun_perolehan"
                                                        name="tahun_perolehan"
                                                        value="{{ $rekognisidosen->tahun_perolehan }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="url" class="form-label">Url:</label>
                                                    <textarea class="form-control" id="url" name="url">{{ $rekognisidosen->url }}</textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
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
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Rekognisi Dosen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dosen.rekognisi_dosen.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">NIDN:</label>
                                        <input type="number" class="form-control" id="nidn" name="nidn"
                                            value="{{ old('nidn') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_kegiatan_rekognisi" class="form-label">Nama Kegiatan
                                            Rekognisi:</label>
                                        <textarea class="form-control" id="nama_kegiatan_rekognisi" name="nama_kegiatan_rekognisi">{{ old('nama_kegiatan_rekognisi') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat</label>
                                        <select class="form-control" name="tingkat">
                                            <option value="Internasional"
                                                {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>
                                                Internasional</option>
                                            <option value="Nasional"
                                                {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>
                                                Nasional</option>
                                            <option value="Lokal" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>
                                                Lokal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bahan Ajar</label>
                                        <select class="form-control" name="bahan_ajar">
                                            <option value="PPT" {{ old('bahan_ajar') == 'PPT' ? 'selected' : '' }}>
                                                PPT</option>
                                            <option value="Modul Praktikum"
                                                {{ old('bahan_ajar') == 'Modul Praktikum' ? 'selected' : '' }}>
                                                Modul Praktikum</option>
                                            <option value="Monograf"
                                                {{ old('bahan_ajar') == 'Monograf' ? 'selected' : '' }}>
                                                Monograf</option>
                                            <option value="Diktat"
                                                {{ old('bahan_ajar') == 'Diktat' ? 'selected' : '' }}>
                                                Diktat</option>
                                            <option value="Buku Ajar"
                                                {{ old('bahan_ajar') == 'Buku Ajar' ? 'selected' : '' }}>
                                                Buku Ajar</option>
                                            <option value="Modul Pembelajaran"
                                                {{ old('bahan_ajar') == 'Modul Pembelajaran' ? 'selected' : '' }}>
                                                Modul Pembelajaran</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_perolehan" class="form-label">Tahun Perolehan:</label>
                                        <input type="text" class="form-control" id="tahun_perolehan"
                                            name="tahun_perolehan" value="{{ old('tahun_perolehan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="url" class="form-label">Url:</label>
                                        <textarea class="form-control" id="url" name="url" placeholder="eg: https://drive.google.com/">{{ old('url') }}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal --}}

                @if ($rekognisi_dosen->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Tidak ada data yang diinput.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Komentar --}}
    <div class="py-4">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-bold mb-3">Komentar</h3>
                <ul>
                    @if ($komentar->isNotEmpty())
                        @foreach ($komentar as $item)
                            <li class="mb-4 p-3 border rounded-md shadow-sm">
                                <div class="flex items-center mb-1">
                                    <div class=" bg-gray-500 rounded-full mr-2" style="width: 40px; height: 40px">
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">Admin</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->created_at->format('d F Y - H:i') }} WIB</p>
                                    </div>
                                </div>
                                <div class="text-sm mt-1 whitespace-pre-line">
                                    {!! nl2br(e($item->komentar)) !!}
                                </div>
                            </li>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 mt-4">Belum ada komentar.</p>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button yang memicu modal
            const recipient = button.getAttribute('data-whatever'); // Ambil data dari button
            const modalTitle = this.querySelector('.modal-title');
            const modalBodyInput = this.querySelector('.modal-body input');

            modalTitle.textContent = 'Tambah Rekognisi Dosen ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
