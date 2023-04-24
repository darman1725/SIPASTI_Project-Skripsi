<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Menu\DataKegiatan;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    protected $table = "pendaftaran";
    protected $fillable = ['id_data_user','id_data_kegiatan','provinsi','kabupaten_kota','jabatan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_data_user');
    }

    public function kegiatan()
    {
        return $this->belongsTo(DataKegiatan::class, 'id_data_kegiatan');
    }
}
