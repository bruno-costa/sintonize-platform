@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Models\Radio $radio */ ?>
@php($viewCtrl->navItemActive = 'radio-content')
@php($bgDeg = [
\App\Repositories\Promotions\PromotionTest::getType() => 'bg-gradient-orange text-white',
\App\Repositories\Promotions\PromotionAnswer::getType() => 'bg-gradient-red text-white',
\App\Repositories\Promotions\PromotionLink::getType() => 'bg-gradient-green text-white'
])

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
    <li class="breadcrumb-item active">Conteúdos Radio {{ $radio->name }}</li>
@endpush

@section('header-content')

    <div class="card">
        <div class="card-header">
            <h3 class="my-0">
                Adicionar novo conteúdo
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col"><a href="" class="btn btn-block btn-default border-0 bg-gradient-orange shadom">Conteúdo
                        Test</a></div>
                <div class="col"><a href="" class="btn btn-block btn-default border-0 bg-gradient-red shadom ">Conteúdo
                        Response</a></div>
                <div class="col"><a href="" class="btn btn-block btn-default border-0 bg-gradient-green shadom ">Conteúdo Link</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Lista de Conteúdos</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Participações</th>
                                <th scope="col">Data Criação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($radio->contents as $content)
                                <tr>
                                    <th scope="row">
                                        <a class="media align-items-center"
                                           href="{{ route('content.show', $content->id) }}">
                                            <span class="avatar rounded-circle mr-3 shadow">
                                                <img alt="Image placeholder" src="{{ $content->imageUrl() }}">
                                            </span>
                                            <div class="media-body">
                                                <span class="badge {{ $bgDeg[$content->promotion()->getType()] ?? 'badge-default' }}">{{ $content->promotion()->getType() }}</span>
                                                <br>
                                                <span class="name mb-0 text-sm text-dark">{{ $content->text }}</span>
                                            </div>
                                        </a>
                                    </th>
                                    <td>
                                        {{ $content->participations()->count() }}
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                    </td>
                                    <td>
                                        {{ $content->created_at->format('d/m/Y') }}
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