<?php
return [
    'providers' => [
        Maatwebsite\Excel\ExcelServiceProvider::class,
    ],
    'aliases' => [
        'Excel'     => Maatwebsite\Excel\Facades\Excel::class,
    ],
];