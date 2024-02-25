<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Variable_type;

class VariableTypeController extends Controller
{
    public function getVariableTypes() {
        $variableTypes = Variable_type::get();
        return json_encode($variableTypes);
    }
}
