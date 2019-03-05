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
        $gender=['male'=>true,'famale'=>false];

        $hobby = \App\Models\Hobby::all();
        $hobbyList=[];
        foreach ($hobby as $hobbyItem){
            $hobbyList[$hobbyItem->name]=$hobbyItem->id;
        }

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
            if (array_key_exists($data['gender'],$gender)){
                $qb->where('male',$gender[$data['gender']]);
            }
        }

        if (array_key_exists('hobby',$data)){
            $hobbyIds=[];
            foreach ($data['hobby'] as $searchHobby){
                if (array_key_exists($searchHobby,$hobbyList)){
                    $hobbyIds[]="jsonb_exists(data->'hobby','".$hobbyList[$searchHobby]."')";
                }
            }
            if (count($hobbyIds)!=0){
                $sql="select id from users where ".implode(" or ",$hobbyIds);
                $usersIdsByPosition= DB::select($sql);
                if (count($usersIdsByPosition)!=0){
                    $qb->whereIn('users.id',array_reduce($usersIdsByPosition,function ($arr,$item){
                        $arr[]=$item->id;
                        return $arr;
                    }));
                }
            }
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
                } else {
                    $qb->whereIn('users.id',[-1]);
                }
            }

        }

        $users=$qb->orderBy('date_of_birth')->get();

        return $users;
    }

}