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
                    {{ __('Beban Kinerja Dosen') }}
                </h2>
            </div>

            <div class="flex items-center space-x-4 mt-4">
                {{-- Dropdown Filter Tahun Akademik --}}
                <form method="GET" action="{{ route('dosen.beban_kinerja_dosen') }}"
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
                    <a href="{{ route('dosen.beban_kinerja_dosen.export') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin mendownload CSV?')">
                        Download CSV
                    </a>

                    @if (!$sudahAdaData && $tahunTerpilih && $tahunList->where('id', $tahunTerpilih)->first()->is_active)
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
                            <th class="px-2 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">NIDN</th>
                            <th class="px-4 py-2 border">Prodi Sendiri</th>
                            <th class="px-4 py-2 border">Prodi Lain</th>
                            <th class="px-4 py-2 border">Prodi diluar PT</th>
                            <th class="px-4 py-2 border">Penelitian</th>
                            <th class="px-4 py-2 border">PKM</th>
                            <th class="px-4 py-2 border">Penunjang</th>
                            <th class="px-4 py-2 border">Jumlah sks</th>
                            <th class="px-4 py-2 border">Rata-rata sks</th>
                            <th class="px-4 py-2 border text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beban_kinerja_dosen as $bebankinerjadosen)
                            <tr>
                                <td class="px-1 py-2 border text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $bebankinerjadosen->nama }}</td>
                                <td class="px-4 py-2 border text-sm">{{ $bebankinerjadosen->nidn }}</td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->ps_sendiri, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->ps_lain, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->ps_diluar_pt, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->penelitian, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->pkm, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->penunjang, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->jumlah_sks, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-4 py-2 border text-sm">
                                    {{ rtrim(rtrim(number_format($bebankinerjadosen->rata_rata_sks, 4, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-1 py-3 border flex flex-col items-center space-y-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $bebankinerjadosen->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form
                                        action="{{ route('dosen.beban_kinerja_dosen.destroy', $bebankinerjadosen->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $bebankinerjadosen->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Beban Kinerja Dosen
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('dosen.beban_kinerja_dosen.update', $bebankinerjadosen->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" hidden name="id"
                                                    value="{{ $bebankinerjadosen->id }}">

                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        name="nama" value="{{ $bebankinerjadosen->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nidn" class="form-label">NIDN:</label>
                                                    <input type="text" class="form-control" id="nidn"
                                                        name="nidn" value="{{ $bebankinerjadosen->nidn }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ps_sendiri" class="form-label">Prodi Sendiri:</label>
                                                    <input type="text" class="form-control" id="ps_sendiri"
                                                        name="ps_sendiri"
                                                        value="{{ $bebankinerjadosen->ps_sendiri }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ps_lain" class="form-label">Prodi Lain:</label>
                                                    <input type="text" class="form-control" id="ps_lain"
                                                        name="ps_lain" value="{{ $bebankinerjadosen->ps_lain }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ps_diluar_pt" class="form-label">Prodi diluar
                                                        PT:</label>
                                                    <input type="text" class="form-control" id="ps_diluar_pt"
                                                        name="ps_diluar_pt"
                                                        value="{{ $bebankinerjadosen->ps_diluar_pt }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="penelitian" class="form-label">Penelitian:</label>
                                                    <input type="text" class="form-control" id="penelitian"
                                                        name="penelitian"
                                                        value="{{ $bebankinerjadosen->penelitian }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pkm" class="form-label">PKM:</label>
                                                    <input type="text" class="form-control" id="pkm"
                                                        name="pkm" value="{{ $bebankinerjadosen->pkm }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="penunjang" class="form-label">Penunjang:</label>
                                                    <input type="text" class="form-control" id="penunjang"
                                                        name="penunjang" value="{{ $bebankinerjadosen->penunjang }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah_sks" class="form-label">Jumlah SKS:</label>
                                                    <input type="text" class="form-control" id="jumlah_sks"
                                                        name="jumlah_sks"
                                                        value="{{ $bebankinerjadosen->jumlah_sks }}"readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rata_rata_sks" class="form-label">Rata Rata SKS per
                                                        Semester:</label>
                                                    <input type="text" class="form-control" id="rata_rata_sks"
                                                        name="rata_rata_sks"
                                                        value="{{ $bebankinerjadosen->rata_rata_sks }}"readonly>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Beban Kinerja Dosen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dosen.beban_kinerja_dosen.add') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="ps_sendiri" class="form-label">Prodi Sendiri:</label>
                                        <input type="text" class="form-control" id="ps_sendiri" name="ps_sendiri"
                                            value="{{ session('ps_sendiri') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ps_lain" class="form-label">Prodi Lain:</label>
                                        <input type="text" class="form-control" id="ps_lain" name="ps_lain"
                                            value="{{ session('ps_lain') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ps_diluar_pt" class="form-label">Prodi diluar PT:</label>
                                        <input type="text" class="form-control" id="ps_diluar_pt"
                                            name="ps_diluar_pt" value="{{ session('ps_diluar_pt') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="penelitian" class="form-label">Penelitian:</label>
                                        <input type="text" class="form-control" id="penelitian" name="penelitian"
                                            value="{{ session('penelitian') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pkm" class="form-label">PKM:</label>
                                        <input type="text" class="form-control" id="pkm" name="pkm"
                                            value="{{ session('pkm') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="penunjang" class="form-label">Penunjang:</label>
                                        <input type="text" class="form-control" id="penunjang" name="penunjang"
                                            value="{{ session('penunjang') }}">
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

                @if ($beban_kinerja_dosen->isEmpty())
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
            const modalTitle = this.querySelector('.modal-title');
            const modalBodyInput = this.querySelector('.modal-body input');

            modalTitle.textContent = 'Tambah Beban Kinerja Dosen ';
            // modalBodyInput.value = recipient;
        });
    </script>
</x-app-layout>
