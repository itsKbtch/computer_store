<?php

namespace App\Http\Controllers\Admin;

use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slideshow = Slideshow::all();

        return view('admin.slideshow.index', ['slideshow' => $slideshow]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slideshow.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|max:100',
            'link' => 'required|url|max:191',
            'photo' => 'required|image|max:2048',
            'active' => 'nullable|boolean'
        ]);

        $slideshow = new Slideshow;

        $slideshow->fill($request->except(['active', 'photo']));

        if (!empty($request->active)) {
            $slideshow->active = 1;
        } else {
            $slideshow->active = 0;
        }

        if ($request->hasFile('photo')) {
            $image = time() . "-" . $request->photo->getClientOriginalName();
            $request->photo->storeAs("public/slide", $image);
            $slideshow->photo = $image;
        }
        
        $check = $slideshow->save();

        if ($check) {
            return redirect('admin/slideshow')->with('success', 'Thêm mới thành công');
        }
        return back()->with('fail', 'Thêm mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function show(Slideshow $slideshow)
    {
       	//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function edit(Slideshow $slideshow, $id)
    {
        $slideshow = $slideshow->findOrFail($id);

        return view('admin.slideshow.edit', ['slideshow' => $slideshow]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slideshow $slideshow, $id)
    {
        $request->validate([
            'caption' => 'required|max:100',
            'link' => 'required|url|max:191',
            'photo' => 'nullable|image|max:2048',
            'active' => 'nullable|boolean'
        ]);

        $slideshow = Slideshow::findOrFail($id);

        $slideshow->fill($request->except(['active', 'photo']));

        if (!empty($request->active)) {
            $slideshow->active = 1;
        } else {
            $slideshow->active = 0;
        }

        if ($request->hasFile('photo')) {
        	Storage::delete('public/slide/'.$slideshow->photo);
            $image = time() . "-" . $request->photo->getClientOriginalName();
            $request->photo->storeAs("public/slide", $image);
            $slideshow->photo = $image;
        }
        
        $check = $slideshow->save();

        if ($check) {
            return back()->with('success', 'Chỉnh sửa thành công');
        }
        return back()->with('fail', 'Chỉnh sửa thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slideshow $slideshow, $id)
    {
        $slideshow = $slideshow->findOrFail($id);

        Storage::delete('public/slide/'.$slideshow->photo);

        $check = $slideshow->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }

    public function destroyMany(Slideshow $slideshows, Request $request)
    {
        $slideshows = $slideshows->whereIn('id', $request->id);

        foreach ($slideshows as $slideshow) {
        	Storage::delete('public/slide/'.$slideshow->photo);
        }

        $check = $slideshows->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }
}
