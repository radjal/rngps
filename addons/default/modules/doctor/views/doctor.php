
<section class="doctor" data-rid="{{id}}" data-town="{{town}}" data-address="{{address}}" data-area_name="{{area_name}}" data-name="{{name}}">
    <div class="well">
    
            <div class="col-sm-4 col-xs-4"> 
            <!-- image --> 
            <?php 
                    if($image['filename'])
                    {
                        $path = $image['filename'];
                    } 
                    elseif( $doctor_cat['speciality'] ) { //default image for speciality
                        switch ( $doctor_cat['speciality'] ) 
                        {
                            case "Médecins généralistes": 
                                $path = 'e6ef08347e274fc655f20c172baad122.jpg';
                                break; 
                            case "Ophtalmologue": 
                                $path = 'da81bbdd7f739e786f674638e29ba433.jpg';
                                break; 
                            case "ORL": 
                                $path = '29edb0b1c84e0ed4df17c82fe658d9d5.jpg';
                                break; 
                            case "Cardiologue": 
                                $path = 'f40501b53bd7d3e0f62c5086ea1ecc2b.jpg';
                                break; 
                            case "Spécialistes femme": 
                                $path = '41f6ec9ed1a988081b7e137dee039c0d.jpg';
                                break; 
                            case "Dentiste": 
                                $path = '1717f2a8194f53253de0df0c7f5f998c.jpg';
                                break; 
                            case "Radiologue": 
                                $path = 'c9c12e653b087854ac27bf50eac5a6cc.jpg';
                                break; 
                            case "Autres médecins": 
                                $path = 'e6ef08347e274fc655f20c172baad122.jpg';
                                break; 
                            case "Etablissements de santé": 
                                $path = '056d27356ff595697ce2352501d71633.jpg';
                                break; 
                            default:
                                $path = '8b37a2a2cbf9537714125a8f8476e63a.jpg';
                                break;
                        }
                    } else { //default placeholder
                        $path = '8b37a2a2cbf9537714125a8f8476e63a.jpg';
                    }
                    echo '<img src="'.site_url()."files/large/$path".'" height="80" class="img-circle" />';
                ?>
            </div>    
            <div class="col-sm-4">

                    <h4>{{name}}
                        <!--<a href="doctors/doctor/{{id}}">{{name}}</a>-->
                    </h4>
                    <h5><?php 
                            if($doctor_cat['speciality']) echo $doctor_cat['speciality'];
                            if($doctor_cat['speciality'] and $groupe['subset']) echo " &bullet; ";
                            if($groupe['subset']) echo $groupe['subset'];
                        ?></h5> 


            <!--
                        <strong>Téléphone:</strong> <?php echo $telephone ?><br/>
                        <strong>Mobile:</strong> <?php echo $mobile ?><br/>
                        <strong>Email:</strong> <?php echo $email ?><br/>-->

                        <?php echo $address; ?>  
                        <?php echo $area_name .', '. $town; ?>  
            <!--            
                               <?php echo $daysopenstr ?>
                            -->
            </div> 
			<div class="hidden-xs "><?php echo $description ?></div>
        <span class="clearfix"></span>
    </div> 

            <div class="weekcalendar ">

                <center class="h4">
                    Semaine {{ cal_week:week }} 
                    <!--<a class="btn btn-default next-week" href="{{ url:site }}calendar/week/{{ cal_week:next_week_no }}/{{url:segments segment="4"}}">--> 
                    <a class="btn btn-default next-week" href="{{ url:site }}doctor/view/{{id}}/{{ cal_week:next_week_no }}"> 
                        <i class="glyphicon glyphicon-calendar"></i> semaine suivante<i class="glyphicon glyphicon-chevron-right"></i>
                    </a>
                </center>
 
                <h3 class="text-center ">
                    Choisir votre date de RDV
                </h3>
                 
<!--                <p>
                    <strong>Prochaine disponibilités</strong> Semaine <?php echo $cal_week['week']; ?> 
                </p>   -->
                <div class="weekdays well well-sm">
                    <?php 
                    $this->load->view('micro-calendar' ) ?> 
                </div>
            </div>

        {{ if user:has_cp_permissions }} 
                <a target="_blank" class="adminlink" href="<?php echo site_url() ?>admin/doctor/edit/{{id}}">Modifier</a>
        {{endif}}
</section>
