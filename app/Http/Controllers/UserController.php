<?php
namespace App\Http\Controllers;

use App\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Show the profile for the given user.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function apiUserSearch(Request $request)
    {
        $data=$request->query->all();
        $users = $this->users->search($data);

        return $users;
    }

    /**
     * Show the profile for the given user.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function apiUserMap(Request $request)
    {
        $data=$request->query->all();
        $users = $this->users->search($data);

        $userList=[
            'type'=>'FeatureCollection',
            'features'=>[]
        ];

        foreach ($users as $item){
            $userList['features'][]=[
                'type'=>"Feature",
                'properties'=>['name'=>$item->name],
                'geometry'=>[
                    'type'=>'Point',
                    'icon'=>'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                    'coordinates'=>[$item->position->getLat(),$item->position->getLng()]
                ]
            ];
        }



        return json_encode($userList);
    }
}