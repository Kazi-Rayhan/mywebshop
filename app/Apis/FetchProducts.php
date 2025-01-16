<?php

namespace App\Apis;

use App\Models\Area;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Iziibuy;
use App\Apis\TendenzApi;
use Illuminate\Support\Str;
class FetchProducts
{

    const PRICEGROUPS =
    [
        ['priceGroup1', 'discount1'],
        ['priceGroup2', 'discount2'],
        ['priceGroup3', 'discount3'],
        ['priceGroup4', 'discount4']
    ];

    public Shop $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    protected function create__or_update_price_groups()
    {
        foreach ($this::PRICEGROUPS as $group) {
            Area::updateOrCreate(['key' => $group[0]], [
                'name' => $group[0],
                'key' => $group[0]
            ]);
        }
    }



    protected function create_or_update_product($product)
    {
        $attribute = array_values(array_filter($product->attributes, function ($attribute) {
            return $attribute->key === 'showsuggestedretailprice';
        }));
        $data = [
            'shop_id' => $this->shop->id,
            'item' => $product->id,
            'name' => $product->title,
            'price' => Iziibuy::round_num($product->priceInfo->suggestedRetailPrice),
            'saleprice' =>  null,
            'slug' => $product->seoName,
            'created_at' => $product->createdWhen,
            'details' => $product->moreInfo,
            'tax' => $product->priceInfo->vat,
            'sku' => $product->sku,
            'qrcode' => null,
            'quantity' => $product->stock[0]->available,
            'retailerprice' => Iziibuy::round_num($product->priceInfo->retailPrice)

        ];
        if (isset($attribute[0]->content)) {
            if ($product->hidden == false &&  $attribute[0]->content == 1) {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
        } else {
            $data['status'] = 0;
        }


        if ($product->images) {
            $data['image'] = 'https://image.friggcms.no/images/' . $product->images[0]->imageUrl;
        }

        return Product::updateOrCreate(['item' => $product->id], $data);
    }

    protected function attach_prices_from_group_to_product($product, $product_from_api)
    {
        $areas = [];
        foreach ($this::PRICEGROUPS as $group) {
            $price = Iziibuy::round_num(((array)$product_from_api->priceInfo)[$group[0]]);
            $discount = Iziibuy::round_num(((array)$product_from_api->priceInfo)[$group[1]]);
            $area = Area::where('key', $group[0])->first();
            $areas[$area->id] = [
                'saleprice' => $discount,
                'price' => $price,
                'retailerprice' => $product_from_api->priceInfo->retailPrice,
                'quantity' => $product_from_api->stock[0]->available,

            ];
        }

        $product->areas = $areas;
        $product->save();
    }

    protected function attach_categories_to_product($product, $product_from_api)
    {
        foreach ($product_from_api->categories as $category) {
            $category = Category::where('main_id', $category->categoryId)->first();
            if ($category) {
                $ids =  $this->findParent($category->id);
                if ($ids) {
                    $product->categories()->sync($ids);
                }
            }
        }
    }

    protected function findParent($id)
    {
        $category = Category::where('id', $id)->first();
        $category_ids = [$category->id];
        if ($category->parent_id != null) {
            $category_ids = array_merge($category_ids, $this->findParent($category->parent_id));
        }
        return $category_ids;
    }
    protected function fetch_products($params)
    {
        return (new TendenzApi($params))->products(); //['ExpandCategories' => 'true']
    }
    protected function fetch_categories($params)
    {
        return (new TendenzApi($params))->categories(); //['ExpandCategories' => 'true']
    }

    protected function create_or_update_category($category)
    {
        try {
            $cat = Category::updateOrCreate(['main_id' => $category->categoryId], [
                'shop_id' => $this->shop->id,
                'main_id' => $category->categoryId,
                'name' => $category->title,
                'slug' => Str::slug($category->title.'-'.$category->categoryId, '-'),

            ]);
            if ($category->parentId) {
                $parent = Category::where('main_id', $category->parentId)->first();
                if ($cat) {
                    $cat->parent_id = $parent->id;
                    $cat->save();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage() . '' . $category->parentId;
        }
    }

    public function feth_category($params = [])
    {
        try {
            $category_from_api = $this->fetch_categories($params);
            DB::beginTransaction();
            foreach ($category_from_api as $category) {
                $this->create_or_update_category($category);
            }
            DB::commit();
        } catch (Error $error) {
            DB::rollBack();
            throw $error;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public  function fetch($params = [])
    {
        try {
            $this->create__or_update_price_groups();
            $products_from_api = $this->fetch_products($params);
            DB::beginTransaction();
            foreach ($products_from_api->products as $product_from_api) {
                $product = $this->create_or_update_product($product_from_api);
                $this->attach_prices_from_group_to_product($product, $product_from_api);
                $this->attach_categories_to_product($product, $product_from_api);
            }
            DB::commit();
        } catch (Error $error) {

            DB::rollBack();
            throw $error;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
