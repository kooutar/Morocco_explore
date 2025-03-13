<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class itineraireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifier si une recherche a été effectuée
        if ($request->has('search')) {
            $search = $request->search;
    
            $itineraires = DB::table('itineraires')
                ->join('destinations', 'destinations.itineraire_id', '=', 'itineraires.id')
                ->select('itineraires.*', 'destinations.nom as destination_nom', 'destinations.lieu_logement')
                ->where(function ($query) use ($search) {
                    $query->where('itineraires.titre', 'like', '%' . $search . '%')
                          ->orWhere('itineraires.categorie', 'like', '%' . $search . '%');
    
                    if (is_numeric($search)) {
                        $query->orWhere('itineraires.duree', '=', $search);
                    }
                })
                ->get();
    
            return response()->json(['itineraires' => $itineraires]);
        }
    
        // Si aucun paramètre de recherche, retourner tous les itinéraires
        $itineraires = DB::table('itineraires')
            ->join('destinations', 'destinations.itineraire_id', '=', 'itineraires.id')
            ->select('itineraires.*', 'destinations.nom as destination_nom', 'destinations.lieu_logement')
            ->get();
    
        return response()->json(['itineraires' => $itineraires]);
    }
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Afficher les données reçues pour débogage
    // dd($request->all());

    $validation = $request->validate([
        'titre' => 'required|min:5|unique:itineraires',
        'categorie' => 'required|min:5',
        'duree' => 'required',
        'images' => 'required',
        'destination' => 'required|array|min:2',
        'destination.nom' => 'required|string|min:3',
        'destination.lieu_logement' => 'required|string|min:3',
        'destination.endroits_visite' => 'nullable|string',
        'destination.activites' => 'nullable|string',
        'destination.plats' => 'nullable|string',
    ]);

    // Insérer l'itinéraire et récupérer son ID
    $id_itineraires = DB::table('itineraires')->insertGetId([
        'titre' => $validation['titre'],
        'categorie' => $validation['categorie'],
        'duree' => $validation['duree'],
        'images' => $validation['images'],
        'user_id' => auth()->id(),
    ]);

    // Insérer la destination liée
    DB::table('destinations')->insert([
        "itineraire_id" => $id_itineraires,
        "nom" => $validation['destination']['nom'],
        "lieu_logement" => $validation['destination']['lieu_logement'],
        "endroits_visite" => json_encode(explode(',', $validation['destination']['endroits_visite'] ?? '')),
        "activites" => json_encode(explode(',', $validation['destination']['activites'] ?? '')),
        "plats" => json_encode(explode(',', $validation['destination']['plats'] ?? '')),
    ]); 
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $itineraires=DB::table('itineraires')->join('destinations','destinations.itineraire_id','=','itineraires.id')
        ->select('itineraires.*','destinations.*')->where('itineraires.id',$id)->get();
        return response()->json(['itineraires' => $itineraires]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $iduser=DB::table('itineraires')->where('user_id',auth()->id())->where('id',$id)->get();

        if($iduser){
            DB::table('itineraires')->where('id',$id)->update([
                'titre'=>$request->titre,
                'categorie'=>$request->categorie,
                'duree'=>$request->duree,
                'images'=>$request->images,
               ]);
               return response()->json('update  with succes');
        }else{
            return response()->json('vous etes pas le createur de ce itineraire');
        }
        
     
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $itineraire=DB::table('itineraires')->where('user_id',auth()->id())->where('id',$id)->get();
        if($itineraire)
        {
            DB::table('itineraires')->where('user_id',auth()->id())->where('id',$id)->delete();
            return response()->json('delete with succes');
        }else{
            response()->json('sir ila 3andk mt9di sir 9dih');
        }
    }
}
