<?php

namespace Tests\Feature; // Adjust the namespace as needed

use App\Models\Booking;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Post;
use Tests\TestCase;

class RouteTest extends TestCase
{

    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    // public function test_can_visit_home()
    // {
    //     $response = $this->get('/');
    //     $response->assertStatus(200);
    // }

    // public function test_can_visit_login()
    // {
    //     $response = $this->get(route('login'));
    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_shop_register()
    // {
    //     $response = $this->get(route('shop.register'));
    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_post()
    // {
    //     $posts = Post::all();
    //     foreach ($posts as $post) {

    //         $response = $this->get(route('posts', $post->slug));
    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_coupon()
    // {
    //     $response = $this->get(route('shop.coupon'));
    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_coupon_destroy()
    // {
    //     $response = $this->get(route('coupon.destroy'));
    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_contact()
    // {
    //     $response = $this->get(route('contact'));
    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_()
    // {
    //     $response = $this->get(route('about'));
    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_shop_home()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $response = $this->get(route('shop.home', $shop->user_name));
    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_products()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $response = $this->get(route('products', $shop->user_name));
    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_scan()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $response = $this->get(route('shop.scan', $shop->user_name));
    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_product()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $products = $shop->products;
    //         foreach ($products as $product) {

    //             $response = $this->get(route('product', [$shop->user_name, $product->slug]));
    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_shop_checkout()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {


    //         $response = $this->get(route('checkout', $shop->user_name));
    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_payment()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $orders = $shop->orders;
    //         foreach ($orders as $order) {

    //             $response = $this->get(route('payment', [$shop->user_name, $order]));
    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_shop_traniner()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $trainers = $shop->users()->personalTrainer()->get();
    //         foreach ($trainers as $trainer) {
    //             $response = $this->get(route('trainer.index', [$shop->user_name, $trainer]));
    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_shop_thankyou_page()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {



    //         $response = $this->get(route('thankyou', $shop->user_name));
    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_traininer_serivice_schedule()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {

    //         $users = $shop->users()->personalTrainer()->get();
    //         foreach ($users as $user) {
    //             $response = $this->get(route('trainer.index', [$shop->user_name, $user, $shop->defaultoption]));
    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_shop_traininer_confirm_booking()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {

    //         $users = $shop->users()->personalTrainer()->get();
    //         foreach ($users as $user) {
    //             $response = $this->get(route('confirm.booking', [$shop->user_name, $user, $shop->defaultoption]));

    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_shop_serivices()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {



    //         $response = $this->get(route('services', $shop->user_name));

    //         $response->assertStatus(200);
    //     }
    // }
    // public function test_can_visit_shop_service()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $services = $shop->services;
    //         if ($services !== null) {
    //             foreach ($services as $service) {
    //                 $response = $this->get(route('serviceSingle', [$shop->user_name, $service->slug]));

    //                 $response->assertStatus(200);
    //             }
    //         }
    //     }
    // }
    // public function test_can_visit_subscription_boxes(){
    //     $shops = Shop::all();
    //         foreach ($shops as $shop) {

    //                     $response = $this->get(route('subscription-boxes', $shop->user_name));

    //                     $response->assertStatus(200);

    //         }
    // }
    // public function test_can_visit_subscription_box()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $boxes = $shop->boxes;
    //         foreach ($boxes as $box) {
    //             $response = $this->get(route('subscription-box', [$shop->user_name, $box]));

    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_subscription_box_subscribe()
    // {
    //     $shops = Shop::all();
    //     foreach ($shops as $shop) {
    //         $boxes = $shop->boxes;
    //         foreach ($boxes as $box) {
    //             $response = $this->get(route('subscription-box-subscribe', [$shop->user_name, $box]));

    //             $response->assertStatus(200);
    //         }
    //     }
    // }
    // public function test_can_visit_manager_index()
    // {
    //     $response = $this->get(route('manager.dashboard'));

    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_manager_products()
    // {
    //     $response = $this->get(route('manager.products'));

    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_manager_availability_create()
    // {
    //     $response = $this->get(route('manager.availability.create'));

    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_manager_booking_index()
    // {
    //     $response = $this->get(route('manager.booking.index'));

    //     $response->assertStatus(200);
    // }
    // public function test_can_visit_manager_booking_bulk()
    // {
    //     $response = $this->get(route('manager.booking.bulk'));

    //     $response->assertStatus(200);
    // }
    public function test_can_visit_manager_booking_bulk()
    {
        $user = User::where("role_id", 4)->first();
        $this->actingAs($user);

        $response = $this->get(route('manager.dashboard'));

        $response->assertStatus(200);
    }
}
