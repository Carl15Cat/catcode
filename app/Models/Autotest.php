<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autotest extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function stdin() {
        $vars = json_decode($this->variables);

        $stdin = "";
        foreach ($vars as $value) {
            $stdin .= $value."\n";
        }

        return $stdin;
    }
}
