<?php

namespace App\Services;


use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Str;
use App\Models\UserProduct;
use Error;
use Exception;
use Shop as ShopFacade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;


class ShopProductImportService
{

    protected $data;
    protected $shop;

    public function __construct(Collection $data, Shop $shop)
    {
        $this->data = $data;
        $this->shop = $shop;
    }
    public  function import()
    {

        $product = $this->create_new_product_or_update_existing_one();
        $categories = [];



        if ($this->data->has('category')) {

            $category = $this->create_new_category_or_subcategory($this->data['category']);

            array_push($categories, $category->id);
        }

        if ($this->data->has(['category', 'sub_category'])) {

            $sub_category = $this->create_new_category_or_subcategory($this->data['sub_category'], $category);
            array_push($categories, $sub_category->id);
        }

        if ($this->data->has(['category', 'sub_category', 'sub_category2'])) {

            $sub_category2 = $this->create_new_category_or_subcategory($this->data['sub_category2'], $sub_category);
            array_push($categories, $sub_category2->id);
        }
        $this->attachCategoryToProduct($categories, $product);
        
    }
    private function create_new_product_or_update_existing_one()
    {

        return Product::updateOrCreate(
            [
                'shop_id' => $this->shop->id,
                'item' => $this->data['item']
            ],
            [
                'item' => $this->data['item'],
                'shop_id' => $this->shop->id,
                'name' => $this->data['name'],
                'quantity' => $this->data['quantity'],
                'sku' => $this->data['sku'],
                'description' => $this->data['description'],
                'slug' => Str::slug('izzibuy' . ' ' . $this->data['name'] . '' . Str::random(10)),
                'image' => self::getImage($this->data['image']),
                'price' => $this->data['price'],
                'tax' => $this->data['tax'],
                'saleprice' => $this->data['saleprice'],
                'status' => $this->data['status'],
                'featured' => @$this->data['featured'] ?? false,
            ]
        );
    }
    private function attachCategoryToProduct($categories, $product)
    {


        $product->categories()->sync($categories);
    }




    private function create_new_category_or_subcategory($name, $parent_category = null)
    {
        $category = Category::where('name', $name)->where('shop_id', $this->shop->id)
            ->when(
                $parent_category,
                function ($query) use ($parent_category) {

                    return $query->where('parent_id', $parent_category->id);
                }
            )
            ->where('name', $name)
            ->first();

        if ($category) return $category;

        return $this->make_new_category($name, $parent_category);
    }

    private function make_new_category($name, $parent_category = null)
    {
        $slug = Str::slug($this->shop->name . ' ' . $name);
        return $this->shop->categories()->create([
            'name' => $name,
            'slug' => $slug,
            'parent_id' => @$parent_category->id,
            // 'qrcode' => ShopFacade::qrcode(route('products', ['user_name' => $this->shop->user_name, 'category' => $slug]))
        ]);
    }


    private  function getImage($url)
    {
        return $url;
        // try{

        //     if ($url) {
        //         $contents = file_get_contents($url);
        //         $name = 'products/' . substr($url, strrpos($url, '/') + 1);
        //         Storage::put($name, $contents);
        //         return $name;
        //     }
        //     return null;
        // }catch(Exception $e){
        //     return null;
        // }catch(Error $e){
        //     return null;

        // }
    }
}