<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function links()
    {
        return $this->hasMany(Buylink::class);
    }

    public function deleteImages()
    {
        $i = 0;
        $cover = $this->cover;
        try {
            if (unlink(public_path() . "/storage" . $cover)) {
                $i++;
            }
        } catch (Exception $e) {
        }
        $images = $this->images;
        foreach ($images as $image) {
            try {
                if (unlink(public_path() . "/storage" . $image->url)) {
                    $i++;
                }
                $image->delete();
            } catch (Exception $e) {
            }
        }

        return $i;
    }
    public function deleteImage($key)
    {
        $image = $this[$key];
        try {
            if (unlink(public_path() . "/storage" . $image)) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function deleteReviews()
    {
        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            $review->delete();
        }
    }
    public function deleteLinks()
    {
        $links = $this->links;
        foreach ($links as $link) {
            $link->delete();
        }
    }
}