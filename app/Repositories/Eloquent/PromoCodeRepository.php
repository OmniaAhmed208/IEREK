<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories\Eloquent;

use Bosnadev\Repositories\Eloquent\Repository;
use App\Repositories\Criteria\PromoCode\ValidPromoCode;

/**
 * Description of PromoCodeRepository
 *
 * @author ierek
 */
class PromoCodeRepository extends Repository {

    const DISCOUNT_2ND_ATTENDACE  = 5;
    const DISCOUNT_3RD_ATTENDACE = 10;
    const DISCOUNT_4TH_ATTENDACE = 15;
    const DISCOUNT_5TH_ATTENDACE = 20;
    const DISCOUNT_SC_ATTENDACE = 25;
    const MORE_THAN_ONE_PAPER_DISCOUNT = 40;

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\PromoCode';
    }

    /**
     * function to generate random promo code
     * @return string 
     */
    public function generatePromoCode($isScientificCommittee = false , $attendTimes = 0) {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $promocode = '';

        for ($p = 0; $p < $length; $p++) {
            $promocode .= $characters[mt_rand(0, strlen($characters))];
        }
        
        $discountAmount = 0;
        
        if($isScientificCommittee){
            $discountAmount = self::DISCOUNT_SC_ATTENDACE;
        }else{
            if($attendTimes == 1){
                $discountAmount = self::DISCOUNT_2ND_ATTENDACE;
            }
            elseif($attendTimes == 2){
                $discountAmount = self::DISCOUNT_3RD_ATTENDACE;
            }  
            elseif($attendTimes == 3){
                $discountAmount = self::DISCOUNT_4TH_ATTENDACE;
            }
            elseif($attendTimes >= 4){
                $discountAmount = self::DISCOUNT_5TH_ATTENDACE;
            }  
        }
        
        
        return array("promocode" => $promocode, "discountAmount" => $discountAmount);
    }
      
    public function getValidPromoCodeBy(array $where){
        $criteria = new ValidPromoCode();
        $this->pushCriteria($criteria);
        
        return $this->findWhere($where)->first(); 
    }
 

}
