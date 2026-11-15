<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
DB::statement("SET FOREIGN_KEY_CHECKS=0");
DB::table("products")->truncate();
DB::table("categories")->truncate();
DB::statement("SET FOREIGN_KEY_CHECKS=1");
$c1 = DB::table("categories")->insertGetId(["name"=>"Personal Care","slug"=>"personal-care","is_active"=>1,"sort_order"=>1,"created_at"=>now(),"updated_at"=>now()]);
$c2 = DB::table("categories")->insertGetId(["name"=>"Home Care","slug"=>"home-care","is_active"=>1,"sort_order"=>2,"created_at"=>now(),"updated_at"=>now()]);
DB::table("products")->insert([
["name"=>"Hand Sanitizer 500ml","slug"=>"hand-sanitizer-500ml","description"=>"<p>Alcohol based hand sanitizer.</p>","short_description"=>"Kills germs","price"=>150,"stock_quantity"=>200,"category_id"=>$c1,"is_active"=>1,"images"=>"[]","created_at"=>now(),"updated_at"=>now()],
["name"=>"Liquid Hand Wash","slug"=>"liquid-hand-wash","description"=>"<p>Gentle liquid hand wash.</p>","short_description"=>"Moisturizing","price"=>250,"stock_quantity"=>150,"category_id"=>$c1,"is_active"=>1,"images"=>"[]","created_at"=>now(),"updated_at"=>now()],
["name"=>"Body Lotion 200ml","slug"=>"body-lotion-200ml","description"=>"<p>Nourishing body lotion.</p>","short_description"=>"24hr moisture","price"=>450,"stock_quantity"=>100,"category_id"=>$c1,"is_active"=>1,"images"=>"[]","created_at"=>now(),"updated_at"=>now()],
["name"=>"Dishwashing Liquid","slug"=>"dishwashing-liquid","description"=>"<p>Grease cutting formula.</p>","short_description"=>"Sparkling clean","price"=>200,"stock_quantity"=>180,"category_id"=>$c2,"is_active"=>1,"images"=>"[]","created_at"=>now(),"updated_at"=>now()],
["name"=>"Floor Cleaner 1L","slug"=>"floor-cleaner-1l","description"=>"<p>Multi-surface floor cleaner.</p>","short_description"=>"Fresh fragrance","price"=>320,"stock_quantity"=>120,"category_id"=>$c2,"is_active"=>1,"images"=>"[]","created_at"=>now(),"updated_at"=>now()],
]);
echo DB::table("products")->count();
