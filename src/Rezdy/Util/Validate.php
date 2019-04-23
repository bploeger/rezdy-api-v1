<?php
namespace Rezdy\Util;

/**
 * Validation class for Requests.
 *
 * @package     Util
 * @author      Brad Ploeger
 */

class Validate {
    
    public static function enumFields() {
      	return [ 
                            'booking-modes'         =>  [   'NO_DATE','DATE_ENQUIRY','INVENTORY'                                              ],
                            
                            'credit-card-type'      =>  [   'VISA', 'MASTERCARD', 'AMEX', 'DINERS','DISCOVER', 'JCB'                          ],
                            
                            'commission-type'       =>  [   'NET_RATE','PERCENT'                                                              ],
                            
                            'confirm-modes'         =>  [   'MANUAL','AUTOCONFIRM','MANUAL_THEN_AUTO','AUTO_THEN_MANUAL'                      ],

                            'currency-types'        =>  [   'AED','ANG','ARS','AUD','AWG','AZN','BGN','BHD','BOB','BRL','BYR','CAD','CHF','CLP',
                                                            'CNY','COP','CZK','DKK','EGP','EUR','FJD','GBP','GEL','HKD','HRK','HUF','IDR','ILS',
                                                            'INR','ISK','JOD','JPY','KES','KRW','KWD','KZT','LTL','LVL','MAD','MKD','MUR','MXN',
                                                            'MYR','NGN','NOK','NZD','PGK','PHP','OMR','PEN','PLN','PYG','QAR','RON','RSD','RUB',
                                                            'SAR','SBD','SEK','SGD','SRD','SYP','THB','TOP','TRY','TWD','UAH','USD','UYU','VEF',
                                                            'VUV','WST','XAF','XOF','XPF','YER','ZAR','AFA','ALL','DZD','AMD','BSD','BDT','BBD',
                                                            'BZD','BMD','BWP','BND','BIF','KHR','CVE','KYD','KMF','BAM','CRC','CUP','CYP','DJF',
                                                            'DOP','XCD','ECS','SVC','ERN','EEK','ETB','FKP','CDF','GMD','GHS','GIP','GTQ','GNF',
                                                            'GWP','GYD','HTG','HNL','IRR','IQD','JMD','AOA','KGS','KIP','LAK','LBP','LRD','LYD',
                                                            'LSL','MOP','MGF','MGA','MWK','MVR','MTL','MRO','MDL','MNT','MZM','MMK','NAD','NPR',
                                                            'NIO','KPW','PKR','PAB','RWF','STD','SCR','SLL','SKK','SIT','SOS','LKR','SHP','SDD',
                                                            'SZL','TJS','TZS','TTD','TND','TMM','UGX','UZS','VND','YUM','ZMK','ZWD','AFN','MZN',
                                                            'UYI','ZMW','GHC','GGP','IMP','JEP','TRL','TVD'                                   ],

                            'extra-price-type'      =>  [   'ANY','FIXED','QUANTITY'                                                          ],

                            'field-type'            =>  [   'String','List','Boolean','Phone','Date'                                          ],

                            'gender'                =>  [   'MALE','FEMALE'                                                                   ],

                            'online-payment-options'=>  [   'CREDITCARD','PAYPAL','BANKTRANSFER','CASH','INVOICE','EXTERNAL','ALIPAY'         ],

                            'price-group-type'      =>  [   'EACH','TOTAL'                                                                    ],

                            'product-type'          =>  [   'ACTIVITY','DAYTOUR','MULTIDAYTOUR','ENQUIRY','PRIVATE_TOUR','TICKET','RENTAL',
                                                            'CHARTER','EVENT','PASS','HOPONHOPOFF','GIFT_CARD','TRANSFER','LESSON',
                                                            'MERCHANDISE','CUSTOM'                                                            ],

                            'qr-code-types'         =>  [   'INTERNAL', 'EXTERNAL'                                                            ],
                            
                            'source'                =>  [   'ONLINE','INTERNAL','PARTNERS','COMMUNITY','MARKETPLACE','MARKETPLACE_PREF_RATE', 
                                                            'API'                                                                             ],

                            'status'                =>  [   'PROCESSING','NEW','ON_HOLD','PENDING_SUPPLIER','PENDING_CUSTOMER','CONFIRMED', 
                                                            'CANCELLED','ABANDONED_CART'                                                      ],

                            'tag-types'             =>  [   'TYPE','CATEGORY','INTEREST','INTENSITY','SKILL_LEVEL','AGE','ACCESSIBILITY',
                                                            'SUITABILITY'                                                                     ],

                            'tag-values'            =>  [   'TYPE'          => ['ATTRACTION','TOUR','ACTIVITY','RENTAL','EVENT','LESSON',
                                                                                'TICKET','TRANSPORT'                                          ],

                                                            'CATEGORY'      => ['ABSEILING','ACCOMMODATION PACKAGE','ACTIVE_TOURS',
                                                                                'ADVENTURE_TOURS','AEROBATIC_FLIGHTS','ANIMAL_EXPERIENCES',
                                                                                'AQUARIUM_&_ZOO','ARCHERY','ART_&_CRAFT_CLASSES','ATTRACTION',
                                                                                'BACKPACKERS_TOURS','BALLOON_FLIGHTS','BEER_TOURS',
                                                                                'BICYCLE_RENTALS','BOAT_DAY_TRIPS','BREWERY_TOURS',
                                                                                'BRIDGE_CLIMBING','BUNGEE_JUMPING','BUS_TOURS','BUSHWALKING',
                                                                                'CAMPING','CANOEING','CANYONING','CAR_RENTAL','CAVING',
                                                                                'CHARTER_BOAT','CITY_BUS_TOURS','CITY_TOURS','CLIMBING',
                                                                                'COACH_TOURS','COOKING_LESSONS','CORPORATE','CRUISES',
                                                                                'CULTURAL_TOURS','CYCLING_TOURS','DANCE_CLASSES','DAY_TOURS',
                                                                                'DISTILLERY_TOURS','DIVING','DOG_MUSHING',
                                                                                'DRIVING_GUIDED_TOURS','ECO-TOURS','ESCAPE_ROOM','EXCURSION',
                                                                                'EXTREME_FLYING','EXTREME_SPORTS','FAMILY_FUN','FARM_TOURS',
                                                                                'FERRY','FESTIVAL','FISHING','FITNESS','FLIGHT_SIMULATOR',
                                                                                'FLYING_FOX','FLYING_LESSONS','FOOD_TOURS',
                                                                                'FOUR_WHEEL_DRIVE_TOURS','GARDEN_TOURS','GHOST_TOURS',
                                                                                'GLIDING','GO-KARTING','GOLF_LESSONS_&_ROUNDS','GOLFING',
                                                                                'GORGE_WALKING','GOURMET_TOURS','GUIDED_TOURS','HARLEY_RIDES',
                                                                                'HELICOPTER_FLIGHTS','HIGH_ROPES_COURSE','HIKING_&_TREKKING',
                                                                                'HISTORIC_TOURS','HORSE_RIDING','HOT_AIR_BALLOONING',
                                                                                'JET_FIGHTER','JET_SKIING','JETBOAT','JOY_FLIGHTS','KAYAKING',
                                                                                'KITESURFING','LASER_SHOOTING','LUXURY','LUXURY_CAR',
                                                                                'MARTIAL_ARTS','MOTORBIKE_TOURS','MOUNTAIN_BIKING',
                                                                                'MULTI-SPORT_TOURS','MUSEUM','MUSIC_EXPERIENCES','OFF_ROAD',
                                                                                'OUTDOOR_EVENTS','PAINTBALL','PARAGLIDING','PARASAILING',
                                                                                'PERSONAL_CHEF','PERSONALISED_GIFTS','PHOTOGRAPHY_LESSONS',
                                                                                'PHOTOGRAPHY_TOURS','PRIVATE_TOURS','PUB_TOURS','QUAD_BIKING',
                                                                                'RACE_CAR_DRIVING','RAFTING','RALLY_DRIVING','ROMANTIC_DINING',
                                                                                'SAFARIS','SAILING','SCENIC_FLIGHTS','SCENIC_TOURS',
                                                                                'SCUBA_DIVING_&_SNORKELING','SEAPLANE_FLIGHTS','SEGWAYS',
                                                                                'SELF-DRIVING','SHOOTING','SHOPPING_TOURS','SHUTTLE',
                                                                                'SIGHTSEEING','SKATING','SKIING_&_SNOW','SKYDIVING',
                                                                                'SMALL_GROUP_TOURS','SPIRIT_TASTING','SPORTING_ATTRACTIONS',
                                                                                'SPORTS_TOURS','STAND_UP_PADDLEBOARDING','STEAM_TRAINS',
                                                                                'STUNT_DRIVING','SURFING','SWIM_WITH_DOLPHINS','TEAM_BUILDING',
                                                                                'TENNIS','THEME_PARKS','TIGER_MOTH','V8_CAR_RACING',
                                                                                'V8_EXPERIENCES','VIRTUAL_REALITY','WALKING_TOURS',
                                                                                'WATER_SPORT','WHALE_&_DOLPHIN WATCHING','WHITE_WATER_RAFTING',
                                                                                'WILDLIFE_TOURS','WILDLIFE_WATCHING','WINDSURFING',
                                                                                'WINE_TASTING','WINTER_SPORTS','YOGA_&_PILATES','ZIPLINING',
                                                                                'ZORBING'                                                      ],

                                                            'INTEREST'       => ['FAMILY','CULTURAL','SIGHTSEEING','LIFESTYLE','LUXURY',
                                                                                 'RELAXATION','ROMANCE','SPECIAL_INTEREST','ECOTOURISM',
                                                                                 'VOLUNTOURISM'                                                ],
                                                            
                                                            'INTENSITY'      => ['RELAXED','QUIET','ACTIVE','SPORTY','EXTREME'                 ],
                                                            
                                                            'SKILL_LEVEL'    => ['BEGINNER','INTERMEDIATE','ADVANCED','EXPERT'                 ],
                                                            
                                                            'AGE'            => ['ADULT','INFANT','CHILD','TEENAGER','SENIOR'                  ],
                                                            
                                                            'ACCESSIBILITY'  => ['VISION_IMPAIRED','HEARING_IMPAIRED','PARAPLEGIC',
                                                                                 'QUADRIPLEGIC','EPILEPTIC','ASTHMATIC'                        ],

                                                            'SUITABILITY'    => ['ANY_WEATHER','DAY_TIME','NIGHT_TIME','FAMILY','GIFT_VOUCHER',
                                                                                 'GROUPS','ONLY_ADULTS','ONLY_MEN','ONLY_WOMEN','SCHOOLS'      ],
                                                                                                                                               ],

                            'tax-types'             =>  [   'PERCENT', 'FIXED_PER_QUANTITY', 'FIXED_PER_ORDER', 'FIXED_PER_DURATION'           ],

                            'title'                 =>  [   'MR','MS','MRS','MISS'                                                             ], 

                            'voucher-status'        =>  [   'ISSUED','REDEEMED','PARTIALLY_REDEEMED','EXPIRED'                                 ], 

                            'voucher-value-type'    =>  [   'VALUE_LIMITPRODUCT','VALUE','VALUE_LIMITCATALOG','PERCENT_LIMITPRODUCT',
                                                            'PERCENT','PERCENT_LIMITCATALOG','PRODUCT'                                         ],  
        ];
    }    

    public static function string ($object, $param, $length = null) {

        if(!is_string($object->$param)) { 
             $object->setError($param . ' is not a string');
        }
        
        if ($length != null) {                               
            if ( $this->withinRange( strlen($object->$param), $length)) {
                $object->setError($param . ' must contain between ' . min($length) . ' and ' . max($length) . 'characters');
            }                       
        }
    } 

    private function withinRange(float $value, $range) {
        return ($value >= min($range) && $value <= max($range));
    } 
}
