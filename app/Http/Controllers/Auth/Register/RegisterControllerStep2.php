<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use App\MultiStep\Steps;
use Illuminate\Http\Request;

class RegisterControllerStep2 extends Controller
{
    public function index(Steps $steps)
    {
        $step = $steps->step('auth.register', 2);

        if ($step->notCompleted(1)) {
            return redirect()->route('auth.register.1.index');
        }

        return view('auth.register.2', compact('step'));
    }

    public function store(Steps $steps, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $steps->step('auth.register', 2)
            ->store($request->only('name'))
            ->complete();

        return redirect()->route('auth.register.3.index');
    }
}
