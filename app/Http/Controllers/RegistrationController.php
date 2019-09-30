<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationUserRequest;
use App\Models\Territory;
use App\Models\User;

class RegistrationController extends Controller
{
    /**
     * @var Territory
     */
    private $territory;
    /**
     * @var User
     */
    private $user;
    
    /**
     * RegistrationController constructor.
     * @param Territory $territory
     * @param User $user
     */
    public function __construct(Territory $territory, User $user)
    {
        
        $this->territory = $territory;
        $this->user = $user;
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $regions = $this->territory->getRegions();
        
        return view('registration', ['regions' => $regions]);
    }
    
    /**
     * @param $terId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function findCities($terId): \Illuminate\Http\JsonResponse
    {
        $cities = $this->territory->getCities()->where('ter_pid', $terId);
        $data = view('ajax-select-cities', compact('cities'))->render();
        
        return response()->json(['cities' => $data], 200);
    }
    
    /**
     * @param $terId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function findDistricts($terId): \Illuminate\Http\JsonResponse
    {
        $districts = $this->territory->getDistricts()->where('ter_pid', $terId);
        $data = view('ajax-select-districts', compact('districts'))->render();
        
        return response()->json(['districts' => $data], 200);
    }
    
    /**
     * @param $terId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function findException($terId): \Illuminate\Http\JsonResponse
    {
        $exceptions = $this->territory->getException()->where('ter_pid', $terId);
        $data = view('ajax-select-exception', compact('exceptions'))->render();
        
        return response()->json(['exceptions' => $data], 200);
    }
    
    /**
     * @param RegistrationUserRequest $registrationUserRequest
     *
     * @return
     */
    public function store(RegistrationUserRequest $registrationUserRequest)
    {
        $data = $registrationUserRequest->all();
        $email = $registrationUserRequest->email;
        
        $user = $this->user->where('email', $email)->with('territory')->first();
        if ($user) {
            return view('show_registred_email', ['user' => $user]);
        } elseif ($registrationUserRequest->district) {
            $data['territory_id'] = $registrationUserRequest->district;
            $this->user->create($data);
            return redirect()->route('index');
        } else {
            $data['territory_id'] = $registrationUserRequest->city;
            $this->user->create($data);
            return redirect()->route('index');
        }
    }
}