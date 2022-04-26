<?php

use Eduframe\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/vendor/autoload.php';

/*
$categorie_id=920;
$leverancier_code="flb";
$feed_base="https://secure.flane.de/NL/nl/data-export/schedule?format=edudex";

// Ga als eerste door de feed heen om de mapping te bepalen
$textMapping=[
    "objectives" => 159, // course tab id
    "student profile" => 125,
    "curriculum" =>126
];

// Ga als eerste door de Feed heen om locaties te bepalen
$locationMapping=[
    "utrecht" => [
        "location"=>117,  // locatie Utrecht
        "meeting"=>556     // Meeting locatie
    ],
    "virtual"=> [
        "location"=>687,
        "meeting"=>1161
    ]
];

$debug=" (fastlane)";
*/


// develop
//$categorie_id=968;
//productie
$categorie_id=990;
$virtueelCode="-v";
$leverancier_code="the";
$toevoeging="B-";
$debug=" (boost)";
$feed_base="https://portal.the-academy.nl/edudex/directory?filter=dictstar";
$textMapping=[

    "characteristics" => 125,
    "curriculum" => 126,
    "graduation" => 159
];

$locationMapping=[
    "eindhoven" => [
        "virtueel"=>false,
        "location"=>953,  
        "meeting"=> 1440    
    ],
    "utrecht" =>[ 
        "virtueel"=>false,
        "location"=>117,  // locatie Utrecht
        "meeting"=>556     // Meeting locatie
    ],
    "rotterdam" => [
        "virtueel"=>false,
        "location"=>954,  
        "meeting"=>1441    
    ],
    "drachten" => [
        "virtueel"=>false,
        "location"=>538,  // locatie Utrecht
        "meeting"=>1135     // Meeting locatie
    ],
    "rotterrdam" => [
        "virtueel"=>false,
        "location"=>954,  
        "meeting"=>1441    
    ],
    "virtueel trainen" => [ //virtueel
        "virtueel"=>true,
        "location"=>687,  
        "meeting"=>1161   
    ]
 
    ];




$educator_slug = 'startel';
// initialiseer develop apsi
//$access_token  = 'xqm_oLnFXu2VdeD7IhBtuVW8KV760iyq8qCm_yts93xw0YNQ8VFyOzjwhn_UBpR7';

// initialiseer productie apsi
$access_token  = 'oegGgk6LtJgkIkgX02jF2jZrYU7i4-MM5Hv91kW8Bs2tt6y_j-Ja86WeNcu0WA5g';

$connection = new Eduframe\Connection();
$connection->setAccessToken( $access_token );
//$connection->setEducatorSlug( $educator_slug );
//$connection->setStage( Eduframe\STAGING );
$connection->setStage( Eduframe\PRODUCTION );




$client = new Eduframe\Client( $connection );


try {
    $all_courses = $client->courses()->all();
} catch (ApiException $e) {
    echo "Api Exception:";
    print_r($e);
    exit();
} catch (GuzzleException $e) {
    echo "GuzzleException:";
    print_r($e);
    exit();
}
foreach($all_courses as $item)
{
    $lookup[$item->code]=$item->id;
}


// Read EDU-DEX feed and process


$Bases_feed=SimpleDOM::loadFile($feed_base);

/**
 * @param SimpleDOM $leverancier_course
 * @return string
 */
function getDurationStr(SimpleDOM $leverancier_course)
{
    return (string)$leverancier_course->programClassification->programDuration . " " . $leverancier_course->programClassification->programDuration->getAttribute("unit");
}

foreach($Bases_feed->programResource as $Program ){
    //print_r($Program);
    
    $a=(string)$Program->programId;
    $url=(string)$Program->resourceUrl;

    $check_array[$a]=SimpleDOM::loadFile($url);
    echo $a." : ".$check_array[$a]->programDescriptions->programName.'('.$check_array[$a]->programClassification->programId.')'.PHP_EOL;
    
    $leverancier_course=$check_array[$a];

    if (empty($lookup[$leverancier_code.$a])) 
    {
        $eduframe = $client->courses();
        $eduframe->category_id=$categorie_id;
        $eduframe->name=(string) $leverancier_course->programDescriptions->programName."(".$toevoeging.$leverancier_course->programClassification->programId.")".$debug;
        $eduframe->code = $leverancier_code.$leverancier_course->programClassification->programId; 
        $eduframe->duration = getDurationStr($leverancier_course);// <programDuration unit="day">5</programDuration>
        $eduframe->meta_title = (string )$leverancier_course->programDescription->programName; 
        $eduframe->meta_description = (string) $leverancier_course->programDescription->programSummaryText;
        foreach($leverancier_course->programSchedule->programRun as $ProgramRun)
        {
          $cost=$ProgramRun->cost->amount;    
        }
        if ((empty($cost)) or($cost==0)){
            $eduframe->cost_scheme ="tbd";
        } else {
            $eduframe->cost=(int) $cost;
            $eduframe->cost_scheme ="student";
        }


        $content= array();
        
        $content[] = $client->courseTabContents([
            //'id'=>0,    
            'content' => (string)$leverancier_course->programDescriptions->programDescriptionText,
            'course_tab_id'=>158
            //,'course_tab' => $client->courseTab(['id'=>158,'name'=>'Algemene omschrijving','position'=>1])
        ]);
        $content[] = $client->courseTabContents([
            //'id'=>1,    
            'content' => (string)$leverancier_course->programClassification->requirementDescription,
            'course_tab_id'=>161
            //,'course_tab' => $client->courseTab(['id'=>161,'name'=>'Voorkennis','position'=>5])
        ]); 
        $content[] = $client->courseTabContents([
              
            'content' => (string) $leverancier_course->programDescription->programSummaryText,
            'course_tab_id'=>157
            
        ]); 
        
        
        foreach($leverancier_course->programDescriptions->subjectText as $subjectText) 
        {
            if (empty($textMapping[(string) $subjectText->subject])) {
                echo "@->".$subjectText->subject.PHP_EOL;
            } else {
                $content[] = $client->courseTabContents([
                    'content' => (string)$subjectText->summaryText,
                        'course_tab_id'=>$textMapping[(string) $subjectText->subject]
                ]);
            }

        } 

        $eduframe->course_tab_contents=$content;
        $eduframe->is_published=false;
        //print_r($content);
        //echo json_encode(json_decode($eduframe->json()), JSON_PRETTY_PRINT).PHP_EOL;
        $eduframe_result=$eduframe->insert();
        echo "course insert: ".$eduframe_result->id;
    } else {
        $eduframe=$client->courses()->find($lookup[$leverancier_code.$a]);
        //print_r($eduframe);
        $eduframe->category_id=$categorie_id;
        $eduframe->name=(string) $leverancier_course->programDescriptions->programName."(".$toevoeging.$leverancier_course->programClassification->programId.")".$debug;
        $eduframe->duration = getDurationStr($leverancier_course);// <programDuration unit="day">5</programDuration>
        $eduframe->meta_title = (string )$leverancier_course->programDescription->programName; 
        $eduframe->meta_description = (string) $leverancier_course->programDescription->programSummaryText;
        foreach($leverancier_course->programSchedule->programRun as $ProgramRun)
        {
          $cost=$ProgramRun->cost->amount;    
        }
        if ((empty($cost)) or($cost==0)){
            $eduframe->cost_scheme ="tbd";
        } else {
            $eduframe->cost=(int) $cost;
            $eduframe->cost_scheme ="student";
        }
        $eduframe_result=$eduframe->update();
        echo "update: ".$eduframe_result->id;
    }
    // virtele uitvoering
    

    // Update planning

    foreach($leverancier_course->programSchedule->programRun as $leverancier_programma)
    {
        $objDateTime = new DateTime($leverancier_programma->startDate);
        if ($objDateTime->diff(new DateTime( "NOW"))->days >15){
            
            $planned_courses=$client->planned_courses()->all(['include'=>'meetings','status'=>'planned','course_id'=> $eduframe_result->id]); //['include'=>'meetings','course_id'=>$to_copy_course]
            $found=false;
            echo "aantal geplannde data : ".count($planned_courses).PHP_EOL;
            foreach ($planned_courses as $planned_course){
                if ($objDateTime->diff(new DateTime( (string) $planned_course->start_date))->days == 0) 
                {
                    $found=true;
                    
                    break;
                }
            }
            if (! $found)
            {
                echo $leverancier_programma->startDate."  " .PHP_EOL;
                
            
                    $planned_course=$client->planned_courses();
                    $planned_course->course_id=$eduframe_result->id;
                    $planned_course->type="FixedPlannedCourse";
                    $objDateTime = new DateTime($leverancier_programma->startDate);
                    $planned_course->start_date=$objDateTime->format("c");
                    $objDateTime = new DateTime($leverancier_programma->endDate);
                    $planned_course->end_date=$objDateTime->format("c");
                    echo $objDateTime->format("c")."  " .PHP_EOL;
                
            }
            
            if ($leverancier_programma->startDate->getAttribute("isFinal")=="true") {
                $planned_course->course_variant_id=322;// klassikaal, doorgangsgarantie
            } else {
                $planned_course->course_variant_id=59;// klassikaal
            }
            //echo $leverancier_programma->cost->amount."  " .PHP_EOL;
            if (empty($locationMapping[strtolower ((string)$leverancier_programma->location->city)])) 
            {
                echo "City: ".(string)$leverancier_programma->location->city.PHP_EOL;
            } else {
                $planned_course->course_location_id=$locationMapping[strtolower ((string)$leverancier_programma->location->city)]["location"];
            }
            
            if (empty($leverancier_programma->cost->amount) or ($leverancier_programma->cost->amount==0))
            {
                $planned_course->cost_scheme="tbd";

            } else {
                $planned_course->cost_scheme="student";
                $planned_course->cost=(string)$leverancier_programma->cost->amount;
            }
            //echo json_encode(json_decode($planned_courses->json()), JSON_PRETTY_PRINT).PHP_EOL;
            $planned_courses_result=$planned_course->save();
            echo "planned_course".PHP_EOL;
            if (! $found)
            {

                $teller=0;
                foreach($leverancier_programma->courseDay as $leverancier_courseday)
                {
                    // date time moet nog naar de juiste zone geconverteerd worden
                    $objDateTime = new DateTime($leverancier_courseday->date);
                    $startTime=new DateTime($objDateTime->format("Y-m-d")." ".$leverancier_courseday->startTime);
                    $endTime=new DateTime($objDateTime->format("Y-m-d")." ".$leverancier_courseday->endTime);
                    $name_string="meeting ".$teller;

                    echo $name_string.":".$startTime->format("c")." ---->". $endTime->format("c").PHP_EOL;
                    $meeting=$client->meetings([
                        "name"=>$name_string,
                        "planned_course_id"=>$planned_courses_result->id,
                        "meeting_location_id"=>$locationMapping[strtolower((string)$leverancier_programma->location->city)]["meeting"],
                        "start_date_time"=>$startTime->format("c"),
                        "end_date_time"=>$endTime->format("c")
                    ]);
                    $teller +=1;

                    $meeting->insert();
                    echo "    meeting".PHP_EOL;

                }
            } else {
                $teller=0;
                foreach($planned_course->meetings as $meeting)
                {
                    $name_string="meeting ".$teller;

                $meeting->meeting_location_id=$locationMapping[strtolower((string)$leverancier_programma->location->city)]["meeting"];
                $meeting->name=$name_string;
                $meeting->save();
                    echo $name_string.": meeting".PHP_EOL;
                    $teller+=1;
                }
            }
        }

        
    }
    //----------------------------- VIRTUEEL PLANNEN -------
    // PAS OP: slechte code
    if (empty($lookup[$leverancier_code.$a."-v"])) 
    {
        $eduframe = $client->courses();
        $eduframe->category_id=$categorie_id;
        $eduframe->name=(string) $leverancier_course->programDescriptions->programName."(".$toevoeging.$leverancier_course->programClassification->programId.") (Virtueel)".$debug;
        $eduframe->code = $leverancier_code.$leverancier_course->programClassification->programId."-v"; 
        $eduframe->duration = getDurationStr($leverancier_course);// <programDuration unit="day">5</programDuration>
        $eduframe->meta_title = (string )$leverancier_course->programDescription->programName." virtueel"; 
        $eduframe->meta_description = (string) $leverancier_course->programDescription->programSummaryText;
        foreach($leverancier_course->programSchedule->programRun as $ProgramRun)
        {
          $cost=$ProgramRun->cost->amount;    
        }
        if ((empty($cost)) or($cost==0)){
            $eduframe->cost_scheme ="tbd";
        } else {
            $eduframe->cost=(int) $cost;
            $eduframe->cost_scheme ="student";
        }


        $content= array();
        
        $content[] = $client->courseTabContents([
            //'id'=>0,    
            'content' => (string)$leverancier_course->programDescriptions->programDescriptionText,
            'course_tab_id'=>158
            //,'course_tab' => $client->courseTab(['id'=>158,'name'=>'Algemene omschrijving','position'=>1])
        ]);
        $content[] = $client->courseTabContents([
            //'id'=>1,    
            'content' => (string)$leverancier_course->programClassification->requirementDescription,
            'course_tab_id'=>161
            //,'course_tab' => $client->courseTab(['id'=>161,'name'=>'Voorkennis','position'=>5])
        ]); 
        $content[] = $client->courseTabContents([
              
            'content' => (string) $leverancier_course->programDescription->programSummaryText,
            'course_tab_id'=>157
            
        ]); 
        
        
        foreach($leverancier_course->programDescriptions->subjectText as $subjectText) 
        {
            if (empty($textMapping[(string) $subjectText->subject])) {
                echo "@->".$subjectText->subject.PHP_EOL;
            } else {
                $content[] = $client->courseTabContents([
                    'content' => (string)$subjectText->summaryText,
                        'course_tab_id'=>$textMapping[(string) $subjectText->subject]
                ]);
            }

        } 

        $eduframe->course_tab_contents=$content;
        $eduframe->is_published=false;
        //print_r($content);
        //echo json_encode(json_decode($eduframe->json()), JSON_PRETTY_PRINT).PHP_EOL;
        $eduframe_result=$eduframe->insert();
        echo "course insert: ".$eduframe_result->id;
    } else {
        $eduframe=$client->courses()->find($lookup[$leverancier_code.$a."-v"]);
        //print_r($eduframe);
        $eduframe->category_id=$categorie_id;
        $eduframe->name=(string) $leverancier_course->programDescriptions->programName."(".$toevoeging.$leverancier_course->programClassification->programId.") (Virtueel)".$debug;
        $eduframe->duration = getDurationStr($leverancier_course);// <programDuration unit="day">5</programDuration>
        $eduframe->meta_title = (string )$leverancier_course->programDescription->programName." virtueel"; 
        $eduframe->meta_description = (string) $leverancier_course->programDescription->programSummaryText;
        foreach($leverancier_course->programSchedule->programRun as $ProgramRun)
        {
          $cost=$ProgramRun->cost->amount;    
        }
        if ((empty($cost)) or($cost==0)){
            $eduframe->cost_scheme ="tbd";
        } else {
            $eduframe->cost=(int) $cost;
            $eduframe->cost_scheme ="student";
        }
        $eduframe_result=$eduframe->update();
        echo "update: ".$eduframe_result->id;
    }
   
    

    // Update planning

    foreach($leverancier_course->programSchedule->programRun as $leverancier_programma)
    {
        $objDateTime = new DateTime($leverancier_programma->startDate);
        if ($objDateTime->diff(new DateTime( "NOW"))->days >15){
            
            $planned_courses=$client->planned_courses()->all(['include'=>'meetings','status'=>'planned','course_id'=> $eduframe_result->id]); //['include'=>'meetings','course_id'=>$to_copy_course]
            $found=false;
            echo "aantal geplannde data : ".count($planned_courses).PHP_EOL;
            foreach ($planned_courses as $planned_course){
                if ($objDateTime->diff(new DateTime( (string) $planned_course->start_date))->days == 0) 
                {
                    $found=true;
                    
                    break;
                }
            }
            if (! $found)
            {
                echo $leverancier_programma->startDate."  " .PHP_EOL;
                $planned_course=$client->planned_courses();
                $planned_course->course_id=$eduframe_result->id;
                $planned_course->type="FixedPlannedCourse";
                $objDateTime = new DateTime($leverancier_programma->startDate);
                $planned_course->start_date=$objDateTime->format("c");
                $objDateTime = new DateTime($leverancier_programma->endDate);
                $planned_course->end_date=$objDateTime->format("c");
                echo $objDateTime->format("c")."  " .PHP_EOL;
            }
            //echo $leverancier_programma->cost->amount."  " .PHP_EOL;
            if ($leverancier_programma->startDate->getAttribute("isFinal")=="true") {
                $planned_course->course_variant_id=328;// virtueel, doorgangsgarantie
            } else {
                $planned_course->course_variant_id=327;// Virtueel
            }
            $planned_course->course_location_id=687;
            
            
            if (empty($leverancier_programma->cost->amount) or ($leverancier_programma->cost->amount==0))
            {
                $planned_course->cost_scheme="tbd";

            } else {
                $planned_course->cost_scheme="student";
                $planned_course->cost=(string)$leverancier_programma->cost->amount;
            }
            //echo json_encode(json_decode($planned_courses->json()), JSON_PRETTY_PRINT).PHP_EOL;
            $planned_courses_result=$planned_course->save();
            echo "planned_course".PHP_EOL;
            if (! $found)
            {

                $teller=0;
                foreach($leverancier_programma->courseDay as $leverancier_courseday)
                {
                    // date time moet nog naar de juiste zone geconverteerd worden
                    $objDateTime = new DateTime($leverancier_courseday->date);
                    $startTime=new DateTime($objDateTime->format("Y-m-d")." ".$leverancier_courseday->startTime);
                    $endTime=new DateTime($objDateTime->format("Y-m-d")." ".$leverancier_courseday->endTime);
                    $name_string="meeting ".$teller;
                    echo $startTime->format("c")." ---->". $endTime->format("c").PHP_EOL;
                    $meeting=$client->meetings([
                        "name"=>$name_string,
                        "planned_course_id"=>$planned_courses_result->id,
                        "meeting_location_id"=>1161,
                        "start_date_time"=>$startTime->format("c"),
                        "end_date_time"=>$endTime->format("c")
                    ]);

                    $meeting->insert();
                    echo "    meeting".PHP_EOL;
                    $teller+=1;

                }
            } else {
                $teller=0;
                foreach($planned_course->meetings as $meeting)
                {
                
                    $name_string="meeting ".$teller;
                    $meeting->name=$name_string;
                $meeting->meeting_location_id=1161;
                $meeting->save();
                    echo $teller.": meeting".PHP_EOL;
                    $teller+=1;

                }
            }
        }

        
    }



}


?>