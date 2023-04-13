<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories\Eloquent;
use Bosnadev\Repositories\Eloquent\Repository;

/**
 * Description of OrderRepository
 *
 * @author ierek
 */
class OrderRepository extends Repository{
    
    
    function model() {
        return 'App\Models\Orders';
    } 
}
