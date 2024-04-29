<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\UserActivity;

trait ProductRecomendationTrait
{
    public function getRecommendedProducts($user_id)
    {
        // Lấy 5 từ khóa tìm kiếm mới nhất của người dùng
        $recentSearchQueries = UserActivity::where('user_id', $user_id)
                                           ->where('type', 'search')
                                           ->orderBy('created_at', 'desc')
                                           ->limit(3)
                                           ->pluck('search_query')
                                           ->toArray();

        // Lấy danh sách sản phẩm liên quan từ từ khóa tìm kiếm gần đây
        $recommendedProductsFromSearch = Product::query();
        foreach ($recentSearchQueries as $searchQuery) {
            $recommendedProductsFromSearch->orWhere('name', 'like', '%' . $searchQuery . '%');
        }
        $recommendedProductsFromSearch = $recommendedProductsFromSearch->get();

        // Lấy ID của các sản phẩm mà người dùng đã xem gần đây
        $recentViewedProductIds = UserActivity::where('user_id', $user_id)
                                              ->where('type', 'view')
                                              ->orderBy('created_at', 'desc')
                                              ->limit(3)
                                              ->pluck('product_id')
                                              ->toArray();

        // Lấy danh sách sản phẩm liên quan từ sản phẩm đã xem gần đây
        $recommendedProductsFromViews = Product::whereIn('id', $recentViewedProductIds)->get();

        
        $recommendedProducts = $recommendedProductsFromSearch->merge($recommendedProductsFromViews);
        $recommendedProducts = $recommendedProducts->where('status', 1)->shuffle()->take(20);

        return $recommendedProducts;
    }
}
