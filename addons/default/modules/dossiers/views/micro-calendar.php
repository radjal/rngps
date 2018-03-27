<?php 
$days = array(1=>'lundi',2=>'mardi',3=>'mercredi',4=>'jeudi',5=>'vendredi',6=>'samedi',7=>'dimanche');
//start loop for days
for($d=1;$d<=7;$d++): 
$day = $days[$d]; 
$calendar_titre=$cal_week['week_dates_iso'][$d]['dayname'].' '.$cal_week['week_dates_iso'][$d]['day'] ;  
echo '';
?>
<!--<div class="calendar {{ if data:today_no_iso > 1 }}date-passed {{ endif }}">-->
						<!--<div class="calendar-day">-->  
								<?php 
								$appts_total = 0 ; $appts_pre_break = $appts_post_break = false;
								$prds_count = $prds_pre_break = $prds_post_break = 0;  
                                                                //loop for day periods
								foreach ( $calendar[$day] as $periods ) 
								{   
//                                                                    echo $periods['break']=='false'?'<br/>'.$periods['dt']:'';  
//                                                                    echo !strstr( $daysopenstr, $day ) ? 'Day off ' : '';
//									echo $periods['dt'];
//									echo " ({$periods['end']})";
                                                                        $dayopen = !strstr( $daysopenstr, $day ) ? false : true ;
									$prds_count = $periods['break'] == 'false' ? $prds_count+1 : $prds_count;
									if($periods['break'] == 'true')
									{
//										echo ' En pause'; 
										$appts_pre_break = $appts_total;
										$prds_pre_break = $prds_count; 
									}
									if(isset($periods['appointment']) && count($periods['appointment'])>0 )
									{   
										$appts_total += count($periods['appointment']);
//										echo $this->calendar_m->html_caldots($periods['appointment']) ; 
									} 
//									echo '<br/>'; 
								}  //end periods loop
//								//post periods loop
								$appts_post_break = $appts_total - $appts_pre_break ;
								$prds_post_break = $prds_count - $prds_pre_break;
                                                                //output
                                                                
//								echo $dayopen ? 'Ouvert<br/>' : 'Fermé<br/>' ; 
//								echo '<br/>'; 
                                                                
//								echo "periods_pre_break: $prds_pre_break periods_post_break: $prds_post_break<br/>" ;
//								echo $appts_pre_break>=0?"$appts_pre_break RDV avant la pause <br/>":'';
//                                                                echo $appts_pre_break >= $prds_pre_break ? "Plus de disponibilité le matin<br/>":'';
//                                                                
//								echo $appts_post_break>=0?"$appts_post_break RDV après la pause <br/>":'';
//                                                                echo $appts_post_break >= $prds_post_break ? "Plus de disponibilité l'après midi<br/>":'';
////								echo $appts_total >0?"$appts_total RDV au total":''; 
								?>
                                                        <div class="btn <?=  !$dayopen ? "disabled closed" : '' ?>"> 
                                                                <div class="calendar_titre"><?= $calendar_titre ?></div>
                                                                <div class="btn-group-vertical">
                                                                        <a href="{{url:site}}calendar/<?= $cal_week['week_dates_iso'][$d]['dayname'].'/'.$cal_week['week'].'/'.$id ?>/?show=am" 
                                                                           class="break-pre btn btn-default <?=  $appts_total>=$prds_count ? "btn-danger " : 'btn-success '; ?><?=  $appts_pre_break >= $prds_pre_break ? " full" : '' ?>">Matin <?=  $appts_total>=$prds_count ? "Plein " : ''; ?></a>
                                                                           <!--<a class="disabled btn btn-default ">&nbsp;</a>-->
                                                                        <a href="{{url:site}}calendar/<?= $cal_week['week_dates_iso'][$d]['dayname'].'/'.$cal_week['week'].'/'.$id ?>/?show=pm" 
                                                                           class="break-post btn btn-default <?=  $appts_total>=$prds_count ? "btn-danger " : 'btn-success '; ?><?=  $appts_post_break >= $appts_post_break ? " full" : '' ?>">Midi <?=  $appts_total>=$prds_count ? "Plein " : ''; ?></a>
                                                                </div>
                                                        </div> 
						<!--</div>-->
						<!--<div class="calendar-spacer"></div>-->
			<!--</div>-->
<?php endfor; //end days loop ?> 