<?php

use Illuminate\Http\Request;

Route::get('doctors', 'DoctorsController@index')->name('doctors.index');
