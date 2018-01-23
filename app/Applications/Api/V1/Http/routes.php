<?php

Route::get('doctors', 'DoctorsController@index')->name('doctors.index');
Route::get('patients', 'PatientsController@index')->name('patients.index');
Route::get('schedules', 'SchedulesController@index')->name('schedules.index');
