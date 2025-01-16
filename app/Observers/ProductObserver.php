<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class ProductObserver
{
    public function creating(Product $product)
    {
        $this->resizeImage($product);
    }

    public function updating(Product $product)
    {

        $this->resizeImage($product);
    }

    private function resizeImage(Product $product)
    {
        // Check if an image is being uploaded
        if ($product->image && request()->hasFile('image')) {
            $uploadedImage = request()->file('image');
            
            // Resize the image while maintaining aspect ratio
            $resizedImage = InterventionImage::make($uploadedImage)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio(); // Maintain aspect ratio
                $constraint->upsize(); // Prevent up-sizing if the image is smaller than the specified dimensions
            });

            // Generate a unique filename for the resized image
            $filename = 'resized_' . time() . '_' . $uploadedImage->getClientOriginalName();

            // Save the resized image on S3
            $resizedImagePath = 'products/' . $filename;
            Storage::disk('s3')->put($resizedImagePath, $resizedImage->stream(), 'public');

            // Update the product model with the path to the resized image on S3
            $product->image = $resizedImagePath;
        }
    }
}
