<?php

use App\Question;

return [
    'status' => [
        Question::status['analyzing'] => 'Analizando propostas',
        Question::status['warranty'] => 'Aguardando pagamento de garantia',
        Question::status['payment'] => 'Pagamento Realizado'
    ]
];
