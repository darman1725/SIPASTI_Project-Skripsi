<x-app-layout>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Form Pendaftaran Calon Petugas Statistik') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('pendaftaran.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="id_data_user">{{ __('Nama Pelamar') }}</label>
                                <input id="id_data_user" type="hidden" class="form-control" name="id_data_user" readonly
                                    value="{{ Auth::user()->id }}">
                                <p class="form-control">{{ Auth::user()->nama_lengkap }}</p>
                            </div>
                            <div class="form-group">
                                <label for="id_data_kegiatan">{{ __('Pilih Kegiatan') }}</label>
                                <select id="id_data_kegiatan"
                                    class="form-control @error('id_data_kegiatan') is-invalid @enderror"
                                    name="id_data_kegiatan" required>
                                    <option value="" disabled selected>-- Pilih Data Kegiatan --</option>
                                    @foreach($kegiatans as $kg)
                                    <option value="{{ $kg->id }}">{{ $kg->nama }} - {{ $kg->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p>
                            <div>{{ __('Letak Keberadaan Anda Sekarang') }}</div>
                            </p>
                            <div class="form-group">
                                <label for="provinsi">{{ __('Provinsi') }}</label>
                                <select class="form-control" id="provinsi" name="provinsi">
                                    <option value="">-- Pilih Provinsi --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kabupaten_kota">{{ __('Kabupaten/Kota') }}</label>
                                <select class="form-control" id="kabupaten_kota" name="kabupaten_kota">
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kabupaten_kota">{{ __('Kecamatan') }}</label>
                                <select class="form-control" id="kecamatan" name="kecamatan">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                <a href="{{ route('pendaftaran') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        fetch(`https://darman1725.github.io/api-wilayah-indonesia/api/provinces.json`)
            .then((response) => response.json())
            .then((provinces) => {
                var data = provinces;
                var tampung = `<option>-- Pilih Provinsi --</option>`;
                data.forEach((element) => {
                    tampung += `<option data-prov="${element.id}" value="${element.name}">${element.name}</option>`;
                });
                document.getElementById("provinsi").innerHTML = tampung;
            });
    </script>

    <script>
        const selectProvinsi = document.getElementById('provinsi');
    const selectKota = document.getElementById('kabupaten_kota');
    const selectKecamatan = document.getElementById('kecamatan');

    selectProvinsi.addEventListener('change', (e) => {
        var provinsi = e.target.options[e.target.selectedIndex].dataset.prov;
        fetch(`https://darman1725.github.io/api-wilayah-indonesia/api/regencies/${provinsi}.json`)
            .then((response) => response.json())
            .then((regencies) => {
                var data = regencies;
                var tampung = `<option>-- Pilih Kabupaten/Kota --</option>`;
                document.getElementById('kabupaten_kota').innerHTML = '<option>Pilih</option>';
                data.forEach((element) => {
                    tampung += `<option data-prov="${element.id}" value="${element.name}">${element.name}</option>`;
                });
                document.getElementById("kabupaten_kota").innerHTML = tampung;
            });
    });

    selectKota.addEventListener('change', (e) => {
        var kota = e.target.options[e.target.selectedIndex].dataset.prov;
        fetch(`https://darman1725.github.io/api-wilayah-indonesia/api/districts/${kota}.json`)
            .then((response) => response.json())
            .then((districts) => {
                var data = districts;
                var tampung = `<option>-- Pilih Kecamatan --</option>`;
                document.getElementById('kecamatan').innerHTML = '<option>Pilih</option>';
                data.forEach((element) => {
                    tampung += `<option data-prov="${element.id}" value="${element.name}">${element.name}</option>`;
                });
                document.getElementById("kecamatan").innerHTML = tampung;
            });
    });

    selectKecamatan.addEventListener('change', (e) => {
            var kecamatan = e.target.options[e.target.selectedIndex].dataset.prov;
            fetch(`https://darman1725.github.io/api-wilayah-indonesia/api/villages/${kecamatan}.json`)
                .then((response) => response.json())
                .then((villages) => {
                    var data = villages;
                    var tampung = `<option>Pilih</option>`;
                    document.getElementById('kelurahan').innerHTML = '<option>Pilih</option>';
                    data.forEach((element) => {
                        tampung += `<option data-prov="${element.id}" value="${element.name}">${element.name}</option>`;
                    });
                    document.getElementById("kelurahan").innerHTML = tampung;
                });
    });
    </script>

</x-app-layout>