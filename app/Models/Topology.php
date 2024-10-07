<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Topology extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['group','link','description','status','created_by','updated_by'];

public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        // Generate UUID saat model dibuat
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'topo_apps', 'topo_id', 'app_id');
    }
    public function topo_createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function topo_updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
