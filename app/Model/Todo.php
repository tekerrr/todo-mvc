<?php

namespace App\Model;

class Todo extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['session', 'name'];

    public $timestamps = false;

    public static function fromSession(): self
    {
        return self::firstOrCreate([
            'session' => (new \App\Auth\Session())->getId()
        ]);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
}
