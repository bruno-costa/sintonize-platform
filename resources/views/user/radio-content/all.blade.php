@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Models\Radio $radio */ ?>
@php($viewCtrl->navItemActive = 'radio-content')
@php($bgDeg = [
\App\Repositories\Promotions\PromotionTest::getType() => 'bg-gradient-orange text-white',
\App\Repositories\Promotions\PromotionAnswer::getType() => 'bg-gradient-red text-white',
\App\Repositories\Promotions\PromotionLink::getType() => 'bg-gradient-green text-white'
])
@php($degName = [
\App\Repositories\Promotions\PromotionTest::getType() => 'Enquete',
\App\Repositories\Promotions\PromotionAnswer::getType() => 'Resposta',
\App\Repositories\Promotions\PromotionLink::getType() => 'Link'
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

@push('script')
    <script>
      (function () {
        const path = '{{ route('content.destroy', ':UID') }}'

        new Vue({
          el: '#table-content-radio',
          methods: {
            deleteContent (uid) {
              const response = confirm('Deseja remover esse Conteudo?')
              if (response) {
                axios({
                  method: 'delete',
                  url: path.replace(':UID', uid),
                }).then((response) => {
                  if (response.data._cod === 'ok') {
                    window.location = window.location
                  }
                  else {
                    throw {response}
                  }
                }).catch((error) => {
                  // const responseData = error.response.data
                  alert('Algo falhou. ')
                })
              }
            },
          },
        })
      })()
    </script>
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
                <div class="col">
                    <a href="{{ route('content.create', [\App\Repositories\Promotions\PromotionTest::getType()]) }}"
                       class="btn btn-block btn-default border-0 bg-gradient-orange shadom">Promoção Enquete</a>
                </div>
                <div class="col">
                    <a href="{{ route('content.create', [\App\Repositories\Promotions\PromotionAnswer::getType()]) }}"
                       class="btn btn-block btn-default border-0 bg-gradient-red shadom ">Promoção Resposta</a>
                </div>
                <div class="col">
                    <a href="{{ route('content.create', [\App\Repositories\Promotions\PromotionLink::getType()]) }}"
                       class="btn btn-block btn-default border-0 bg-gradient-green shadom ">Divulgar Link</a>
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
                        <table class="table align-items-center table-flush" id="table-content-radio">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Patrocinios</th>
                                <th scope="col">Participações</th>
                                <th scope="col">Data Criação</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($radio->contents->sortByDesc('created_at') as $content)
                                <tr>
                                    <th scope="row">
                                        <a class="media align-items-center"
                                           href="{{ route('content.show', $content->id) }}">
                                            <span class="avatar rounded-circle mr-3 shadow">
                                                <img alt="Image placeholder" src="{{ $content->imageUrl() }}">
                                            </span>
                                            <div class="media-body">
                                                <span class="badge {{ $bgDeg[$content->promotion()->getType()] ?? 'badge-default' }}">{{ $degName[$content->promotion()->getType()] ?? '' }}</span>
                                                <br>
                                                <span class="name mb-0 text-sm text-dark">{{ $content->text }}</span>
                                            </div>
                                        </a>
                                    </th>
                                    <td>
                                        @php($advertiser = $content->advertiser())
                                        <?php /** @var \App\Models\Advertiser $advertiser */ ?>
                                        @if($advertiser)
                                            <div class="media align-items-center">
                                                <span class="avatar rounded-circle mr-3 shadow">
                                                    <img alt="Image placeholder" src="{{ $advertiser->avatarUrl() }}">
                                                </span>
                                                <div class="media-body">
                                                    {{ $advertiser->name }}
                                                </div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $content->participations()->count() }}
                                        <i class="fas fa-arrow-up text-success mr-3" hidden></i>
                                    </td>
                                    <td>
                                        {{ $content->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <a href="" @click.prevent="deleteContent('{{ $content->id }}')">
                                            <span class="text-danger"><i class="fas fa-trash mr-2"></i> Remover</span>
                                        </a>
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