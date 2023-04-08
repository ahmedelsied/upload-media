<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\MediaModel;
use App\Support\API\ApiResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $model;
    public function index()
    {
        $data = MediaModel::with('media')->paginate();
        return ApiResponse::success(MediaResource::paginate($data));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' =>  'required|image',
            'text'  =>  'nullable|string',
            'audio' =>  'nullable|image|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
        ]);

        $this->model = MediaModel::create([]);

        foreach($validated as $key => $val){
            $this->filter($key,$val);
        }
        return  ApiResponse::success('Saved Successfully');
    }

    private function filter($key,$val)
    {
        match($key){
            'image' =>  $this->model->addMedia($val)->toMediaCollection('image'),
            'audio' =>  $this->model->addMedia($val)->toMediaCollection('audio'),
            'text'  =>  $this->model->update(['text' => $val]),
        };
    }
}
