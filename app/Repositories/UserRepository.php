<?php

namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class UserRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model=$user;
    }

    public function search($data)
    {
        /**
         * @var Builder $qb
         */
        $qb=\App\User::select('users.id','users.name','date_of_birth','users.position');
        if (array_key_exists('age',$data)){
            if (array_key_exists('from',$data['age'])){
                $from=new \DateTime();
                $from->sub(new \DateInterval('P'.$data['age']['from'].'Y'));
                $qb->whereDate('date_of_birth','<=',$from->format('Y-m-d'));
            }
            if (array_key_exists('to',$data['age'])){
                $to=new \DateTime();
                $to->sub(new \DateInterval('P'.$data['age']['to'].'Y'));
                $qb->whereDate('date_of_birth','>=',$to);
            }
        }
        if (array_key_exists('gender',$data)){
            $qb->join('gender','gender.id','=','users.gender_id');
            $qb->where('gender.name',$data['gender']);
        }
        if (array_key_exists('hobby',$data)){
            $qb->whereHas('hobby', function ($q) use ($data){
                $q->whereIn('name',$data['hobby']);
            });
            $qb->with(array('hobby'=>function($query){
                $query->select('hobby.name')->pluck('hobby.name');
            }));
        }
        if (array_key_exists('geo_location',$data)){
            $isPrepare=false;
            if ((array_key_exists('nw',$data['geo_location']))&&(array_key_exists('se',$data['geo_location']))){
                if ((array_key_exists('lat',$data['geo_location']['nw']))&&(array_key_exists('lng',$data['geo_location']['nw']))){
                    $nwLat=$data['geo_location']['nw']['lat'];
                    $nwLng=$data['geo_location']['nw']['lng'];
                    $isPrepare=true;
                }
                if ((array_key_exists('lat',$data['geo_location']['se']))&&(array_key_exists('lng',$data['geo_location']['se']))){
                    $seLat=$data['geo_location']['se']['lat'];
                    $seLng=$data['geo_location']['se']['lng'];
                } else {
                    $isPrepare=false;
                }
            }
            if ($isPrepare){

                $sql="SELECT id FROM users WHERE  position @ ST_MakeEnvelope (:xmin, :ymin, :xmax, :ymax,4326)";
                $usersIdsByPosition= DB::select($sql,['xmin'=>$seLng,'ymin'=>$seLat,'xmax'=>$nwLng,'ymax'=>$nwLat]);
                if (count($usersIdsByPosition)!=0){
                    $qb->whereIn('users.id',array_reduce($usersIdsByPosition,function ($arr,$item){
                        $arr[]=$item->id;
                        return $arr;
                    }));
                }
            }

        }

        $users=$qb->orderBy('date_of_birth')->get();

        return $users;
    }

}