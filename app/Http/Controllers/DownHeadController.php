<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DownHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req) : JsonResponse {
        // SECTION AGENT
        if($req->user()->hasRole('agent')) {
            $data = User::with([
                'plan',
                'info',
                'pay_type',
            ])
            ->where('created_at', '>=', $req->start)
            ->where('created_at', '<=', $req->end)
            ->withSum('client_transactions', 'amount')
            ->whereHas('info', function($q) use($req){
                $q->where('agent_id', $req->user()->id)
                ->where('lastName', 'LIKE', '%'.$req->search.'%');
            })
            ->get();
            return response()->json([...$this->G_ReturnDefault(), 'data' => $data]);
        }

        return $this->G_UnauthorizedResponse();
    }
}
