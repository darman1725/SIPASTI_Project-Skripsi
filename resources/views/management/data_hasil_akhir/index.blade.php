<x-app-layout>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>

        <a href="{{ url('Laporan/cetak_laporan_hasil') }}" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak
            Data </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Urutan Rangking</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr align="center">
                            <th width="5%">No</th>
                            <th>Alternatif</th>
                            <th width="15%">Total Nilai</th>
                            <th width="10%">Rangking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $no = 1;
                    $total_bobot = \App\Models\Management\DataPerhitungan::get_total_kriteria();
                    $alternatif = \App\Models\Menu\DataAlternatif::orderBy('nama', 'asc')->get();
                    $alternatif_data = array();
                    foreach ($alternatif as $keys) {
                        $nilai_total = 0;
                        foreach ($kriteria as $key) {
                            $data_pencocokan = \App\Models\Management\DataPerhitungan::data_nilai($keys->id, $key->id);
                            $min_max = \App\Models\Management\DataPerhitungan::get_max_min($key->id);
    
                            if ($total_bobot['total_bobot'] != 0) {
                                $bobot_normalisasi = $key->bobot / $total_bobot['total_bobot'];
                            } else {
                                $bobot_normalisasi = 0;
                            }
    
                            if ($min_max && $min_max['max'] != $min_max['min']) {
                                if ($key->jenis == "Benefit") {
                                    $nilai_utility = @(($data_pencocokan->nilai - $min_max['min']) / ($min_max['max'] - $min_max['min']));
                                } else {
                                    $nilai_utility = @(($min_max['max'] - $data_pencocokan->nilai) / ($min_max['max'] - $min_max['min']));
                                }
                            } else {
                                $nilai_utility = 0;
                            }
    
                            $nilai_total += $bobot_normalisasi * $nilai_utility;
                        }
                        $alternatif_data[] = [
                            'id' => $keys->id,
                            'nama' => $keys->nama,
                            'nilai_total' => $nilai_total
                        ];
                    }
    
                    // Urutkan data alternatif berdasarkan nilai total secara descending
                    usort($alternatif_data, function($a, $b) {
                        return $b['nilai_total'] <=> $a['nilai_total'];
                    });
    
                    foreach ($alternatif_data as $keys) {
                    ?>
                        <tr align="center">
                            <td>
                                <?= $no++; ?>
                            </td>
                            <td align="left">
                                <?= $keys['nama']; ?>
                            </td>
                            <td>
                                <?= $keys['nilai_total']; ?>
                            </td>
                            <td>
                                <?= $no-1; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>