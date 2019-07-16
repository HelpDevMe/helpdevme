<?php

use App\Question;

return [
    Question::status['analyzing'] => 'Analyzing Proposals',
    Question::status['warranty'] => 'Awaiting Warranty Payment',
    Question::status['payment'] => 'Payment Made',
    Question::status['finalized'] => 'Finalized'
];
