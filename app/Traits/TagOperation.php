<?php
namespace App\Traits;

use App\Tag;
use Illuminate\Support\Arr;

trait TagOperation
{

    function tags()
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'taggable_id', 'tag_id')
            ->where('taggable_type', self::class)
            ->withPivot('taggable_type');
    }

    function tag_attach($tag_ids)
    {
        if ($tag_ids) {
            foreach (Arr::wrap($tag_ids) as $tag_id) {
                $data[$tag_id] = [
                    'taggable_type' => self::class
                ];
            }
            $this->tags()->attach($data);
        }
    }

    function tag_sync($tag_ids)
    {
        if ($tag_ids) {
            $tag_ids = (is_array($tag_ids)) ? $tag_ids : [
                $tag_ids
            ];

            foreach (Arr::wrap($tag_ids) as $tag_id) {
                $data[$tag_id] = [
                    'taggable_type' => self::class
                ];
            }

            $this->tags()
                ->wherePivot('taggable_type', self::class)
                ->sync($data);
        } else {
            $this->tags()
                ->wherePivot('taggable_type', self::class)
                ->sync([]);
        }
    }

    function get_tags_as_badges($with_line_break = NULL)
    {
        $tags = $this->tags;
        $line_break = ($with_line_break) ? '<br>' : '';
        if (count($tags) > 0) {
            $tag_list = array_column($tags->toArray(), 'name');
            $str = "";
            foreach ($tag_list as $item) {
                $str .= '<span class="badge badge-light">' . $item . '</span>' . $line_break;
            }
            return $str;
        }
    }
}