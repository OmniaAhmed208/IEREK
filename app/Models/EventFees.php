<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFees extends Model
{

	public function event_attendance_type()
    {
        return $this->hasOne('App\Models\EventAttendanceType', 'event_attendance_type_id', 'event_attendance_type_id');
    }

    public function event_date_type()
    {
        return $this->hasOne('App\Models\EventDateType', 'event_date_type_id', 'event_date_type_id');
    }

    public function fees_category_type()
    {
        return $this->hasOne('App\Models\FeesCategoryType', 'fees_category_id', 'fees_category_id');
    }
    
    public function scopeAttendanceFees($query){
        return $query->where('fees_category_id', 1);
    }
    
    public function scopeAccommodationFees($query){
        return $query->where('fees_category_id', 2);
    }
    
    /**
     * in case of user paid online with visa we will charge him the gateway fees
     * @param type $query
     * @return type
     */
    public function scopeVisaFees($query){
        return $query->where('fees_category_id', 3);
    }
    
    public function scopePublishingFees($query){
        return $query->where('fees_category_id', 4);
    }
    
    public function scopePaperFees($query){
        return $query->where('fees_category_id', 5);
    }
    
    public function scopeCustomFees($query){
        return $query->where('fees_category_id', 6);
    }
    
    public function scopeShortPaperFees($query){
        return $query->where('fees_category_id', 7);
    }
    
    public function scopePaymentTypes($query, $paymentTypes){
        return $query->whereIn('event_date_type_id', $paymentTypes);
    }
    
    public function scopeAllAndAudience($query){
        return $query->whereIn('event_attendance_type_id', [0,1]);
    }
    
    public function scopeAllAndAuther($query){
        return $query->whereIn('event_attendance_type_id', [0,3]);
    }
    
    public function scopeAllAndCoAuther($query){
        return $query->whereIn('event_attendance_type_id', [0,2]);
    }
    
    public function scopeAllAndAttendTypeIs($query, $attendanceType){
        return $query->whereIn('event_attendance_type_id', [0,$attendanceType]);
    }
    
    public function scopeEvent($query, $eventId){
        return $query->where('event_id',$eventId);
    }
    
    public function scopeEgpCurrency($query){
        return $query->where('currency','EGP');
    }
    
    public function scopeCurrency($query, $currency){
        return $query->where('currency',$currency);
    }
    
    public function scopeAmountGreaterThanOne($query){
        return $query->where('amount','>=', 1);
    }
    
    public function scopeNotSoftDeleted($query){
        return $query->where('deleted', 0);
    }
    
    public static function getFeesOfAttendanceForAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->attendanceFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    
    public static function getFeesOfVisaForAudienceOnAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->visaFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    
    public static function getFeesOfPublishingForAudienceOnAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->publishingFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    
    public static function getFeesOfAccommodationForAudienceOnAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->accommodationFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    
    public static function getFeesOfPaperForAudienceOnAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->paperFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    
    public static function getFeesOfShortPaperForAudienceOnAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->ShortPaperFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    
    public static function getFeesOfCustomForAudienceOnAllPaymentTypes($eventId, $paymentType, $attendanceType, $currency){
       return  self::event($eventId)
                     ->paymentTypes($paymentType)
                            ->allAndAttendTypeIs($attendanceType)
                            ->customFees() //fees of attendance
                            ->currency($currency)
                            ->amountGreaterThanOne()
                            ->notSoftDeleted()
                            ->get();
        
    }
    //
    protected $table = 'event_fees';

    protected $fillable = ['event_id','event_date_type_id','event_attendance_type_id','fees_category_id','title_en','title_ar','amount','currency','created_by','updated_by'];
}
