<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyKepuasanPersuratan extends Model
{
    protected $table = 'kepuasan_layananpersuratan';
    protected $primaryKey = 'id_kepuasan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_kepuasan',
        'id_pengajuan',
        'rating',
        'sebagai',
        'keandalan',
        'daya_tanggap',
        'kepastian',
        'empati',
        'sarana',
        'keterangan',
        'created_at',
        'updated_at'
    ];
}
