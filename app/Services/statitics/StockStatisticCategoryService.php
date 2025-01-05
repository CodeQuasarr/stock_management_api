<?php

namespace App\Services\statitics;

use App\Http\Resources\Stocks\StockStatisticResource;
use App\Models\StockStatistic;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

abstract class StockStatisticCategoryService extends BaseService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function userProductsCategories()
    {
        try {
            $seller = User::find(3);
            $stockModel = $seller->stocks();
            $stockItems = $stockModel->get(['id', 'name'])->toArray();
            // Retour en cas de succès
            return [
                'success' => true,
                'stockItems' => $stockItems,
                'message' => 'Categories de produits récupérées avec succès.',
                'status' => 200,
            ];

        } catch (\Exception $e) {
            // En cas d'erreur : log et retour structuré
            Log::error('Erreur lors de la récupération des catégories : ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la recuperation des categories de produits.',
                'error' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

}
