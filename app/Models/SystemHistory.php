<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemHistory extends Model
{
    protected $fillable = ['user_id', 'action', 'module', 'description', 'icon'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function log(string $action, string $module, string $description, string $icon = 'info')
    {
        self::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'icon'        => $icon,
        ]);
    }
}
