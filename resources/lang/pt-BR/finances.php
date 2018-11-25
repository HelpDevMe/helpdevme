<?php

use App\Finance;

return [
    'types' => [
        Finance::types['deduction'] => 'Desconto',
        Finance::types['payment'] => 'Pagamento para',
        Finance::types['received'] => 'Recebido de',
        Finance::types['fund'] => 'Créditos adicionados'
    ]
];
