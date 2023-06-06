<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use OpenAI\Laravel\Facades\OpenAI;

use App\Models\Chat;
use App\Models\Image;


class OpenAIController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $chats = Chat::whereBelongsTo(auth()->user())->orderByDesc('created_at')->get();
            return view('pages.index', compact('chats'));
        }
        return view('pages.index');
    }

    public function voice()
    {
        if (Auth::check()) {
            $chats = Chat::whereBelongsTo(auth()->user())->orderByDesc('created_at')->get();
            return view('pages.voice', compact('chats'));
        }
        return view('pages.voice');
    }

    public function speak(Request $request)
    {
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $request->prompt,
            'max_tokens' => 500,
            'temperature' => 0.3,
            'n' => 3
        ]);

        if (Auth::check()) {
            Chat::create([
                'prompt' => $request->prompt,
                'response' => $result['choices'][0]['text'],
                'user_id' => auth()->user()->id
            ]);
            $selected = Chat::latest()->first();
            $selected_id = $selected->id;
        }
        // return response()->json(['answer' => $result['choices'][0]['text']]);
        return response()->json([
            'answer' => $result['choices']
        ]);
    }

    public function image() {
        if (Auth::check()) {
            $images = Image::whereBelongsTo(auth()->user())->orderByDesc('created_at')->get();
            return view('pages.image', [
                'src' => false, 
                'images' => $images, 
                'selected' => false
            ]);
        }
       
        return view('pages.image', [
            'src' => false, 
            'images' => false, 
            'selected' => false
        ]);
    }

    public function generateImage(Request $request) {
        $src = false;
        if ($request->prompt) {
            $response = OpenAI::images()->create([
                'prompt' => $request->prompt,
                'n' => 1,
                'size' => '256x256',
                'response_format' => 'url',
            ]);
            $src = $response['data'][0]['url'];
            if (Auth::check()) {
                Image::create([
                    'prompt' => $request->prompt,
                    'image_url' => $response['data'][0]['url'],
                    'user_id' => auth()->user()->id
                ]);
                $images = Image::whereBelongsTo(auth()->user())->orderByDesc('created_at')->get();
                $selected = Image::latest()->first();
                $selected_id = $selected->id;
                return view('pages.image', [
                    'src' => $src, 
                    'images' => $images, 
                    'selected' => $selected_id
                ]);
            }
        }
        return view('pages.image', ['src' => $src]);
    }

    public function getImage(Request $request) {
        $src = Image::find($request->image_id);
        $images = Image::whereBelongsTo(auth()->user())->orderByDesc('created_at')->get();
        return view('pages.image', ['src' => $src->image_url, 'images' => $images, 'selected' => $request->image_id]);
    }
}
