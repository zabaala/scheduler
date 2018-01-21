<?php

use Illuminate\Http\Request;

Route::get('test', function () {
    echo "foo";
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});