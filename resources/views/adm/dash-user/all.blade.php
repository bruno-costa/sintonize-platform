@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Services\ViewStateController $viewCtrl */ ?>
<?php /** @var \App\User[]|\Illuminate\Support\Collection $users */ ?>
@php($viewCtrl->navItemActive = 'dash-user')

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
        const path = '{{ route('dash-user.destroy', ':UID') }}'

        new Vue({
          el: '#table-users-dash',
          methods: {
            deleteUser (uid) {
              const response = confirm('Deseja remover esse usuario?')
              console.log(path.replace(':UID', uid), response)
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
    <li class="breadcrumb-item active">Dash users</li>
@endpush


@section('content')
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Dash users</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('dash-user.create') }}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush" id="table-users-dash">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Radios</th>
                                <th scope="col">Email</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">
                                        <a class="media align-items-center"
                                           href="{{ route('dash-user.show', $user->id) }}">
                                            <span class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="{{ $user->avatarUrl() }}">
                                            </span>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $user->name }}</span>
                                                @if($user->isAdmin())
                                                    <br><span class="badge badge-pill badge-primary">Admin</span>
                                                @endif
                                            </div>
                                        </a>
                                    </th>
                                    <td>
                                        @forelse($user->radios as $radio)
                                            <a href="{{ route('radio.show', $radio->id) }}"
                                               style="background-color: {{ $radio->themeColor() }}"
                                               class="badge badge-lg badge-pill badge-default">
                                                {{ $radio->name }}
                                            </a>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        <a href="" @click.prevent="deleteUser({{ $user->id }})">
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