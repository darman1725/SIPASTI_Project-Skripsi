<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Management\DataPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DataPenilaianRequest;

class DataPenilaianController extends Controller
{
    public function index()
    {
        $data = [
            'page' => "Penilaian",
            'list' => DataPenilaian::tampil(),
            'kriteria'=> DataPenilaian::get_kriteria(),
            'pendaftaran'=> DataPenilaian::get_pendaftaran(),
            'sub_kriteria'=> DataPenilaian::get_sub_kriteria(),
            'perhitungan' => DataPenilaian::tampil()
        ];
        return view('management.data_penilaian.index', $data);
    }

    public function tambah_penilaian(DataPenilaianRequest $request)
    {
        $id_pendaftaran = $request->input('id_pendaftaran');
        $id_data_kriteria = $request->input('id_data_kriteria');
        $nilai = $request->input('nilai');
        $i = 0;
        foreach ($nilai as $key) {
            DataPenilaian::tambah_penilaian($id_pendaftaran,$id_data_kriteria[$i],$key);
            $i++;
        }

        $request->session()->flash('success', 'Data Penilaian berhasil ditambahkan');
        return redirect()->route('data_penilaian');
    }

    public function update_penilaian(DataPenilaianRequest $request)
    {
        $id_pendaftaran = $request->input('id_pendaftaran');
        $id_data_kriteria = $request->input('id_data_kriteria');
        $nilai = $request->input('nilai');
        $i = 0;

        foreach ($nilai as $key) {
            $cek = DataPenilaian::data_penilaian($id_pendaftaran,$id_data_kriteria[$i]);
            if ($cek==0) {
                DataPenilaian::tambah_penilaian($id_pendaftaran,$id_data_kriteria[$i],$key);
            } else {
                DataPenilaian::edit_penilaian($id_pendaftaran,$id_data_kriteria[$i],$key);
            }
            $i++;
        }
        $request->session()->flash('success', 'Data Penilaian berhasil diupdate');
        return redirect()->route('data_penilaian');
    }
}
