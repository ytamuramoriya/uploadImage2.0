<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Arquivo extends Model
{
    use Notifiable;
    const UPLOAD_FOLDER_DEFAULT = 'internal-uploads';
    const TIPOS_PERMITIDOS = [
        'doc',
        'docx',
        'zip',
        'pdf',
        'xls',
        'xlsx',
        'jpg',
        'jpeg',
        'png',
        'bmp',
        'psd',
        'ai'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entidade_id',
        'nome_entidade',
        'nome',
        'arquivo',
        'extensao',
        'mime_type',
        'tamanho',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
