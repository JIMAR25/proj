<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Chambre;
use Stripe\Stripe;
use App\Mail\ReservationConfirmation;
use Illuminate\Support\Facades\Mail;

use Barryvdh\DomPDF\PDF;



class ReservationController extends Controller
{
    public function create()
    {
        $chambres = Chambre::all();
        return view('reservations.create', compact('chambres'));
    }
    public function show($id)
    {
        // Retrieve the reservation details
        $reservation = Reservation::findOrFail($id);

        $date_arrivee = new \DateTime($reservation->date_arrivee);
        $date_depart = new \DateTime($reservation->date_depart);
        $nb_nuits = $date_depart->diff($date_arrivee)->days;

        // Display the reservation details in a view
        return view('reservations.infos', compact('reservation', 'nb_nuits'));
    }


    public function store(Request $request)
    {
        Stripe::setApiKey('sk_test_51MlAg4D2dzVBVsLgV6HnejFU9d931M4kKYKTjLIj0Wlpl...');
    
        // Valider les données de la demande
        $this->validate($request, [
            'chambre_id' => 'required',
            'date_arrivee' => 'required|date',
            'date_depart' => 'required|date|after:date_arrivee',
            'nombre_de_personnes' => 'required|integer|min:1',
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'telephone' => 'required|digits:10',
            'payment_method' => 'required',
        ]);
    
        // Récupérer la chambre sélectionnée
        $chambre = Chambre::findOrFail($request->chambre_id);
    
        // Calculer le nombre de nuits réservées
        $date_arrivee = new \DateTime($request->date_arrivee);
        $date_depart = new \DateTime($request->date_depart);
        $nb_nuits = $date_depart->diff($date_arrivee)->days;

        
        
        
        // Vérifier si le nombre de nuits réservées est supérieur à zéro
        if ($nb_nuits <= 0) {
            return back()->withErrors(['date_depart' => 'La date de départ doit être après la date d\'arrivée.']);
        }
    
        // Calculer le prix total de la réservation
        $prix_total = $chambre->prix_par_nuit * $nb_nuits * $request->nombre_de_personnes;
    
        // Créer une nouvelle réservation
        $reservation = new Reservation();
        $reservation->chambre_id = $request->chambre_id;
        $reservation->date_arrivee = $request->date_arrivee;
        $reservation->date_depart = $request->date_depart;
        $reservation->nombre_de_personnes = $request->nombre_de_personnes;
        $reservation->nom = $request->nom;
        $reservation->prenom = $request->prenom;
        $reservation->email = $request->email;
        $reservation->telephone = $request->telephone;

        $reservation->prix_total = $prix_total;
        $reservation->save();

        // Set the number of nights on the reservation object
        $reservation->nb_nuits = $nb_nuits;

        
       
    
        // Envoyer un email de confirmation de réservation
        Mail::to($request->email)->send(new ReservationConfirmation($reservation));
    
        // Rediriger vers la page de confirmation avec un message de succès
        return redirect()->route('reservations.infos', ['id' => $reservation->id])->with(compact('nb_nuits'))->with('success', 'Votre réservation a été effectuée avec succès! Le prix total est de ' . $reservation->prix_total . '€.' .
       "Nous avons envoyé un email contenant les informations de votre réservation à l'adresse que vous avez fournie.Veuillez vérifier votre boîte de réception et votre dossier spam.");
    }
    public function downloadPDF($id, PDF $pdf)
    {
        $reservation = Reservation::findOrFail($id);
        $pdf->loadView('reservations.pdf', compact('reservation'));
        return $pdf->download('reservation-' . $id . '.pdf');
    }
    }