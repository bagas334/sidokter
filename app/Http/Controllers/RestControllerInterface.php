<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

interface RestControllerInterface
{
    public function create(): View;
    public function store(Request $request);
    public function edit($id): View;
    public function update(Request $request, $id);
    public function delete($id);
}
