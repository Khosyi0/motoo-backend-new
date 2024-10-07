<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Pic extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = ['user_id','name','contact','jobdesc','photo','status'];

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
        return $this->belongsToMany(Application::class, 'pic_apps', 'pic_id', 'app_id')->withPivot('pic_type');
    }
    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
