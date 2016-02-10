<?php

/**
 * Created by PhpStorm.
 * User: Juan Camilo
 * Date: 29/01/2016
 * Time: 13:09
 */
class PropertySearch {

    private $pdo;

    function __construct( array $db_settings=['dsn'=>'sqlite:mydb.sq3','u'=>null,'p'=>null]   )
    {

        //NEEDS SQLITE DRIVER FOR if using SQLITE (sudo apt-get install php5-sqlite)
        $this->pdo=new PDO(
            $db_settings['dsn'],
            $db_settings['u'],
            $db_settings['p']
        );
        //DB set up
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    function generateFilter($request)
    {
        $filter='WHERE 1 ';
        //if lat and lng add filter for
        if(isset($request['nw'])&& isset($request['se'])&& $request['nw']&&$request['se'])
        {
            //"lat,lng"
            $nw=explode(',',$request['nw']);
            $se=explode(',',$request['se']);

            $filter.=' AND (
            `lat` BETWEEN '.floatval ($se[0] ).' AND '.floatval ( $nw[0]).'
            AND (`lng` BETWEEN '.floatval ($nw[1] ).' AND -180 OR `lng` BETWEEN '.floatval ($se[1] ).' AND 180)
            )';

        }


        if(isset($request['price_max']) && $request['price_max'])
        {
            $filter.=' AND(
            price <= '.intval($request['price_max']).'
            )
            ';
        }


        if(isset($request['price_min']) && $request['price_min'])
        {
            $filter.=' AND(
            price >= '.intval($request['price_min']).'
            )
            ';
        }

        if(isset($request['beds']))
        {
            if($request['beds']=='0')
            {
                $filter.=' AND(
                beds = '.intval($request['beds']).'
                )
                ';
            }
            else
            {
                $filter.=' AND(
                beds >= '.intval($request['beds']).'
                )
                ';
            }


        }

        if(isset($request['baths'])&&$request['baths'])
        {

            $filter.=' AND(
            baths >= '.intval($request['baths']).'
            )
            ';



        }

        if(isset($request['type']))
        {
            switch($request['type'])
            {
                case 'studio':
                    $filter.=' AND(
                        type LIKE "studio"
                    )
                    ';

                    break;
                case 'apartment':
                    $filter.=' AND(
                        type LIKE "apartment"
                    )
                    ';

                    break;
                case 'town house':
                    $filter.=' AND(
                        type LIKE "town house"
                    )
                    ';

                    break;
                case 'detached house':
                    $filter.=' AND(
                        type LIKE "detached house"
                    )
                    ';

                    break;
            }



        }


        $order='';
        if(isset($request['sort']))
        {
            switch ($request['sort'])
            {
                case 'high':
                    $order=' ORDER BY price DESC';
                    break;
                case 'low':
                    $order=' ORDER BY price ASC';
                    break;
                default:
                    $order=' ORDER BY date_added DESC';
            }
        }

        return $filter.$order;
    }

    function getPropertyJson()
    {
            $filter=$this->generateFilter($_REQUEST);
            $query='SELECT * FROM `property` '.$filter;
       // echo $query;
            $stmt =$this->pdo->prepare($query);
            $stmt->execute() ;
            $properties= $stmt->fetchAll(PDO::FETCH_ASSOC);
           return json_encode($properties);

    }

    function getProperties()
    {
        $filter=$this->generateFilter($_REQUEST);
        $query='SELECT * FROM property '.$filter;
        $stmt =$this->pdo->prepare($query);
        $stmt->execute() ;
        $properties= $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $properties;
    }

    function getPropertiesHTML()
    {
        $filter=$this->generateFilter($_REQUEST);
        $query='SELECT * FROM property '.$filter;
        $stmt =$this->pdo->prepare($query);
        $stmt->execute() ;
        $properties= $stmt->fetchAll(PDO::FETCH_ASSOC);
        $html='';

        foreach($properties as $property)
        {

           $html.= '<div class="row property-result-row" data-rel="'.$property['id'].'">
                        <div class="property-image" style="background-image: url(\''.$property['image'].'\');"></div>
                        <div class="col-md-12 result-text">
                            <div class="row"><strong>'.$property['name'].'</strong> '. $property['address'] .'  </div>
                            <div class="row"><strong class="prop-price"> '. money_format('%.2n', $property['price']).'</strong>  '. $property['beds'] .' bd - '. $property['baths'] .' ba   </div>
                        </div>

             </div>';
        }

        return $html;

    }



}