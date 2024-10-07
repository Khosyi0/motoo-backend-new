<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'short_name'; 
    protected $guarded = [
                        // 'id', 
                        'created_at', 'updated_at'];
    protected $fillable = ['short_name','long_name','logo'];

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
        return $this->hasMany(Application::class, 'company');
    }  

    public function users()
    {
        return $this->hasMany(User::class, 'company');
    }
}
