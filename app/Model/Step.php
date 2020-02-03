<?php

namespace App\Model;

class Step extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['body'];

    public $timestamps = false;

    public function complete()
    {
        $this->is_completed = true;
        $this->save();
    }

    public function uncomplete()
    {
        $this->is_completed = false;
        $this->save();
    }
}
