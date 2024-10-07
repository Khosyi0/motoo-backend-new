<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirtualMachine extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['group', 'name', 'description','ip_address','created_by','updated_by'];

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
        return $this->belongsToMany(Application::class, 'vm_apps', 'vm_id', 'app_id')->withPivot('environment');
    }
    public function vm_createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function vm_updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
