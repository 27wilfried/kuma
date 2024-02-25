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
        return view('admin.product.index', compact('products'));
    }


// Méthode pour enregistrer un nouveau produit
   public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required',
            'prix' => 'required',
            'image' => 'required',
        ]);

        // Enregistrement du produit
        $product = new Product();
        $product->nom = $validatedData['nom'];
        $product->prix = $validatedData['prix'];

        // Traitement de l'image (téléchargement, stockage, etc.)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('storage/images', $imageName);
            $product->image = $imageName;
        }
        $product->save();

        // Redirection vers la liste des produits avec un message de succès
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

// Méthode pour éditer un produit
    public function update(Request $request, $id)
    {
        // Validation des données du formulaire
        $request->validate([
            'nom' => 'required',
            'prix' => 'required',
            'image' => 'image' // Exemple de validation pour l'image
        ]);

        // Récupérer le produit à éditer
        $product = Product::findOrFail($id);

        // Mettre à jour les informations du produit
        $product->nom = $request->nom;
        $product->prix = $request->prix;

        // Vérifier s'il y a une nouvelle image
        if ($request->hasFile('image')) {
            // Enregistrer la nouvelle image
            $imagePath = $request->file('image')->store('storage/images');
            // Mettre à jour le chemin de l'image dans la base de données
            $product->image = $imagePath;
        }
        // Sauvegarder les modifications
        $product->save();

        // Redirection vers la liste des produits avec un message de succès
        return redirect()->route('product.index')->with('success', 'Produit mis à jour avec succès');
    }

 // Méthode pour afficher le formulaire de création de produit
    public function create()
    {
        return view('admin.create', compact('products'));
    }

    public function destroy($id)
{
    // Récupérer l'instance du produit
    $product = Product::findOrFail($id);

    // Vérifier si le produit existe
    if ($product) {
        // Supprimer le produit de la base de données
        $product->delete();

        // Rediriger l'utilisateur vers la page souhaitée avec un message de succès
        return redirect()->route('product.index')->with('success', 'Produit supprimé avec succès.');
    }

    // Si le produit n'existe pas, rediriger avec un message d'erreur
    return redirect()->route('product.index')->with('error', 'Produit non trouvé.');
}


}
