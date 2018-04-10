{{ custom:disable_theme }}
{{if false}}
//<!-- réponse depuis {{url:site}} --> 
rngps: {{ d:rngps}}<br>
ancien_no: {{ d:ancien_no  }}
birth_date: {{ birth_date  }}
nom: {{ d:nom  }}
prenom: {{ d:prenom  }}
{{endif}}
<?php
echo json_encode($d);
 