<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
  // Méthode pour afficher la liste des produits
    public function index()
    {
        // Votre logique pour récupérer la liste des produits ici
        $products = Product::all();
        return view('admin.admin');
    }

 // Méthode pour afficher le formulaire de création de produit
    public function create()
    {
        return view('admin.create', compact('products'));
    }


}
