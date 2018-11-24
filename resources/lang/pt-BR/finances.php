<?php

use App\Finance;

return [
    'types' => [
        Finance::types['deduction'] => 'Desconto',
        Finance::types['payment'] => 'Pagamento',
        Finance::types['received'] => 'Recebido'
    ]
];
