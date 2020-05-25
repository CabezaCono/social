<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;

class StatusesController extends Controller
{

    public function index()
    {
        return StatusResource::collection(
            Status::latest()->paginate()
        );
    }

    public function store()
    {

        request()->validate(['body' => 'required|min:5']);

        $status = Status::create([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        return StatusResource::make($status);
    }
}
