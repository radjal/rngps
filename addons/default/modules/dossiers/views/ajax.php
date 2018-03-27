<script type="text/javascript">
<?php 
//echo $this->dossiers_m->getfile('js/dossiers.js' );
?>
//dossiers ajax ****************
 if(typeof dossiers === 'undefined') var dossiers = [];  
 {{ dossiers.entries }}
//dossiers {{id}}
dossiers[{{ id }}] = {
    id:{{id}},
    name:{{js_name}},
    hours:{{js_hours}},
    address:{{js_address}},
    town:{{js_town}},
    area_name:{{js_area_name}},
    hours:{{js_hours}},
    dossiers_zone_title:{{dossiers_zone:js_dossiers_zone_title }} ,
    days:{
{{ days }}
    {{ if key == 1 }}1:1,{{endif}}
    {{ if key == 2 }}2:2,{{endif}}
    {{ if key == 3 }}3:3,{{endif}}
    {{ if key == 4 }}4:4,{{endif}}
    {{ if key == 5 }}5:5,{{endif}}
    {{ if key == 6 }}6:6,{{endif}}
    {{ if key == 0 }}0:0{{endif}}
{{ /days }}
        
}
};
{{ /dossiers.entries }}
</script>
<ol> 
        {{ dossiers.entries }}
        <li class="dossiers" style="clear: both;">
            <h4>{{ name }}</h4>
		
                        <p>
                        {{ if image:thumb}}<img src="{{ image:thumb }}" height="80" style="float:left;margin-right:20px;"/>{{endif}}
			   {{ if telephone }} Téléphone:  {{ telephone }}  <br/>{{ endif }}
			   {{ if mobile }} Mobile:  {{ mobile }} <br/>{{ endif }}
			   {{ if mail }} Email: {{ mail }} <br/>{{ endif }} 
                            
			   {{ address }}
                           {{ area_name }} {{ town }}
                        </p>
                        
                        <p>
                           <strong>Jours de livraison sur ce Point Relais</strong>  <br/>
                        
			{{ days }} 
			<span data-dayno="{{ key }}" data-dayname="{{ value }}">
                           {{ value }}
			</span>
			{{ /days }}
                        </p>
                        <p>
                        <strong>Heures d'ouverture:</strong><br/>
                        {{ helper:nl2br string=hours }} {{# hours #}}<br/>
			{{ if description }}{{ description }}<br/>{{endif}}
                        
			   {{# dossiers_zone:dossiers_zone_title #}} 
			</p>
                <a id="dossiers-{{id}}" data-id="{{id}}" name="{{name}}" class="btn" onclick="selectDoctor(this)">Sélectionner ce Point Relais</a>

        </li>
        {{ /dossiers.entries }}
</ol>

