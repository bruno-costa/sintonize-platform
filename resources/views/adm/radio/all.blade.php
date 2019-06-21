@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Services\ViewStateController $viewCtrl */ ?>
<?php /** @var \App\Models\Radio[]|\Illuminate\Support\Collection $radios */ ?>
@php($viewCtrl->navItemActive = 'radio')

@push('styles')
    <style>
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@push('breadcrumbs')
    <li class="breadcrumb-item active">Radio</li>
@endpush

@section('content')
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Radios</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('radio.create') }}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Cor tema</th>
                                <th scope="col">Conteudos</th>
                                <th scope="col">Stream</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($radios as $radio)
                                <tr>
                                    <th scope="row">
                                        <a class="media align-items-center"
                                           href="{{ route('radio.show', $radio->id) }}">
                                        <span class="avatar rounded-circle mr-3">
                                            <img alt="Image placeholder" src="{{ $radio->avatarUrl() }}">
                                        </span>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $radio->name }}</span>
                                            </div>
                                        </a>
                                    </th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ $radio->themeColor() }}
                                            <div class="rounded ml-1" style="width: 60px; height: 25px; background-color: {{ $radio->themeColor() }}"></div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $radio->contents->count() }}
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                    </td>
                                    <td>
                                        <a href="{{ $radio->streamUrl() }}" target="_blank">{{ $radio->streamUrl() }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection