<?php

namespace App\EloquentHelpers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait Filler
{
    /**
     * @param $request Request|array
     */
    public function fillRequest($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }
        $this->fill($request->all());
    }

    /**
     * @param $request Request|array
     */
    public function fillExceptFile($request)
    {
        if (is_array($request)) {
            $input = collect($request)->except(['file'])->toArray();
        } else {
            $input = $request->except(['file']);
        }

        $this->fill($input);

    }

    /**
     * @param $request Request|array
     */
    public function fillExceptImage($request)
    {
        if (is_array($request)) {
            $this->fill(collect($request)->except(['image'])->toArray());
        } else {
            $this->fill($request->except(['image']));
        }
    }

    /**
     * @param $request Request|array
     */
    public function fillExceptImageAndFile($request)
    {
        if (is_array($request)) {
            $this->fill(collect($request)->except(['image', 'file'])->toArray());
        } else {
            $this->fill($request->except(['image', 'file']));
        }
    }

    /**
     * @param $request Request|array
     */
    public function fillPublishedAt($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }

        $published_at_date = $request->get('published_at_date');
        $published_at_time = $request->get('published_at_time');
        $published_at = $request->get('published_at');

        if (!empty($published_at_date) && !empty($published_at_time)) {
            $this->fill(['published_at' => g_to_j("{$published_at_date} {$published_at_time}")]);
        } elseif (!empty($published_at)) {
            $this->fill(['published_at' => g_to_j($published_at)]);
        } else {
            $this->fill(['published_at' => null]);
        }
    }

    /**
     * @param $request Request|array
     */
    public function fillExpiredAt($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }

        $expired_at_date = $request->get('expires_at_date');
        $expired_at_time = $request->get('expires_at_time');
        $expired_at = $request->get('expires_at');

        if (!empty($expired_at_date) && !empty($expired_at_time)) {
            $this->fill(['expires_at' => g_to_j("{$expired_at_date} {$expired_at_time}")]);
        } elseif (!empty($expired_at)) {
            $this->fill(['expires_at' => g_to_j($expired_at)]);
        } else {
            $this->fill(['expires_at' => null]);
        }
    }

    /**
     * @return void
     */
    public function fillUserId()
    {
        $this->user_id = auth()->id();
    }

    /**
     * @param $request Request|array
     */
    public function fillFileFromTemp($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }

        $this->fill(['file' => move_file_from_temp($request->get('file'), $this->file_path)]);
    }

    /**
     * @param $request Request|array
     */
    public function attachTags($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }

        $tag_ids = [];

        foreach ($request->get('tags') as $input_tag) {
            $tag_ids[] = Tag::firstOrCreate(['name' => $input_tag['text']])->id;
        }
        $this->tags()->attach($tag_ids);
    }

    /**
     * @param $request Request|array
     */
    public function syncTags($request)
    {
        if (is_array($request)) {
            $request = collect($request);
        }

        $tag_ids = [];

        foreach ($request->get('tags') as $input_tag) {
            $tag_ids[] = Tag::firstOrCreate(['name' => $input_tag['text']])->id;
        }
        $this->tags()->sync($tag_ids);
    }

    /**
     * @param $password Request|array|string
     */
    public function fillPassword($password)
    {
        if (is_array($password)) {
            $password = collect($password);
        }

        if (is_string($password)) {
            $password_string = $password;
        } else {
            $password_string = $password->get('password');
        }

        if (isset($password_string)) {
            $this->fill(['password' => Hash::make($password_string)]);
        }
    }

    /**
     * @param $password Request|array|string
     */
    public function fillPasswordWhenIsDirty($password)
    {
        if (!$this->isDirty('password')) {
            $this->fillPassword($password);
        }
    }
}