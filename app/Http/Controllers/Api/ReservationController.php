<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Mail\ReservationMail;
use App\Models\Chambre;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;//bibliothèque pour les dates
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
     public function AjouterReservation(StoreReservationRequest $request)
{
   
    $user = Auth::user();//user qui a fait login
    $client = $user->client;


    return DB::transaction(function () use ($request, $client) {
         

        
        $exists = Reservation::where('id_chambre', $request->id_chambre)
            ->where(function ($query) use ($request) {
                $query->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                      ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('date_debut', '<=', $request->date_debut)
                            ->where('date_fin', '>=', $request->date_fin);
                      });
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => __('messages.room_already_reserved')
            ], 400);
        }

        $reservation = Reservation::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'id_client' => $client->id_client,
            'id_chambre' => (int) $request->id_chambre,
        ]);
       

      Mail::to($reservation->client->user->email)
     ->send(new ReservationMail($reservation));
        
       

        return response()->json([
    'message' => __('messages.reservation_success'),
    'data' => $reservation
      ], 201);

    });
}

public function SupprimerReservation($id)
{
    $reservation = Reservation::findOrFail($id);

    $reservation->delete();

}

public function index()
{
    return Reservation::with(['client.user', 'chambre'])->get();
}

public function mesReservations()
{
    $user = Auth::user();
    $client = $user->client;

    $reservations = Reservation::with('chambre')
        ->where('id_client', $client->id_client)
        ->get();

    return response()->json($reservations);
}

public function stats(Request $request)
{
    $result = DB::select(
        'CALL stats_reservations(?, ?)',//procedure
        [$request->date_debut, $request->date_fin]
    );

    return response()->json($result);
}

public function downloadPdf($id)
{
    $reservation = Reservation::with(['client.user', 'chambre'])
        ->findOrFail($id);

        // total nuit
    $dateDebut = Carbon::parse($reservation->date_debut);
    $dateFin = Carbon::parse($reservation->date_fin);

    $nbNuits = $dateDebut->diffInDays($dateFin);

    // total prix
    $total = $nbNuits * $reservation->chambre->prix;

    $pdf = Pdf::loadView('pdf.reservation', compact('reservation', 'nbNuits', 'total'));
    //genere pdf d'apré blade file

   return response()->streamDownload(function () use ($pdf) {
    echo $pdf->output();//telechargement
}, 'reservation_'.$reservation->id_reservation.'.pdf');//reservation_1.pdf
}

public function roomsTypes()
{
    $data = Chambre::selectRaw('type as name, COUNT(*) as value')
        ->groupBy('type')
        ->get();

    return response()->json($data);
}

public function statsByMonth()
{
    $stats = DB::table('reservations')
        ->join('chambres', 'reservations.id_chambre', '=', 'chambres.id_chambre')
        ->select(
            DB::raw('MONTH(reservations.date_debut) as mois'),
            DB::raw('COUNT(reservations.id_reservation) as total_reservations'),
            DB::raw('SUM(DATEDIFF(reservations.date_fin, reservations.date_debut) * chambres.prix) as total_revenus')
        )
        ->groupBy(DB::raw('MONTH(reservations.date_debut)'))
        ->orderBy('mois')
        ->get();

    return response()->json($stats);
}







public function exportXML()
{
    $reservations = Reservation::with('client.user','chambre')->get();

    $xml = new \SimpleXMLElement('<reservations/>');//class php fait XML

    foreach ($reservations as $reservation) {
        $item=$xml->addChild('reservation');
       
        $item->addChild('id_client', $reservation->id_client);
        $item->addChild('id_chambre', $reservation->id_chambre);
        $item->addChild('date_debut', $reservation->date_debut);
        $item->addChild('date_fin', $reservation->date_fin);
    }

        ob_clean();//for clean xml
    $xmlString = $xml->asXML();//object--/string
$xmlString = preg_replace('/<\?xml.*\?>/', '', $xmlString);//supprimer header -- eviter conflit
return response($xmlString, 200)
    ->header('Content-Type', 'application/xml')//browser
    ->header('Content-Disposition', 'attachment; filename="reservations.xml"');//download

}

public function importXML(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xml'
    ]);

    $xmlContent = file_get_contents($request->file('file'));//lire contenu xml
    $xml = simplexml_load_string($xmlContent);//--objet

   DB::beginTransaction();
    try {

        foreach ($xml->reservation as $item) {

            Reservation::create([
                'id_client'   => (int)$item->id_client,
                'id_chambre'  => (int)$item->id_chambre,
                'date_debut'  => (string)$item->date_debut,
                'date_fin'    => (string)$item->date_fin,
                'etat'        => 'confirmée'
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => __('messages.xml_import_success')
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'error' =>  __('messages.xml_import_error')
        ], 500);
    }
}
public function registerClient(Request $request)
{
    $user = User::create([
        'name' => $request->nom,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role_id' => 2
    ]);

    Client::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'telephone' => $request->telephone,
        'user_id' => $user->id
    ]);

    return response()->json([
        'message' => __('messages.client_register')
    ]);
}

public function changerEtat(Request $request, $id)
{
    $request->validate([
        'etat' => 'required|in:Nouvelle,Confirmée,Annulée'
    ]);

    $reservation = Reservation::find($id);


    $reservation->etat = $request->etat;
    $reservation->save();

    return response()->json([
        'message' => __('messages.change_etat_reservation'),
        'data' => $reservation
    ]);
}
}
