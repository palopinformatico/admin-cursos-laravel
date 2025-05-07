<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listarEstudiantes', function () {
    return view('listarEstudiantes');
});

Route::get('/crearEstudiantes', function () {
    return view('crearEstudiantes');
});

Route::get('/actualizarEstudiantes', function () {
    return view('actualizarEstudiantes');
});

Route::get('/actualizarEstudiantes2', function () {
    return view('actualizarEstudiantes2');
});

Route::get('/eliminarEstudiantes', function () {
    return view('eliminarEstudiantes');
});


Route::get('/listarCursos', function () {
    return view('listarCursos');
});

Route::get('/crearCursos', function () {
    return view('crearCursos');
});

Route::get('/actualizarCursos', function () {
    return view('actualizarCursos');
});

Route::get('/actualizarCursos2', function () {
    return view('actualizarCursos2');
});

Route::get('/eliminarCursos', function () {
    return view('eliminarCursos');
});


Route::get('/asignar', function () {
    return view('asignar');
});

Route::get('/top3CursosMasEstudiantes', function () {
    return view('top3CursosMasEstudiantes');
});

Route::get('/cursoDeEstudiantes', function () {
    return view('cursoDeEstudiantes');
});