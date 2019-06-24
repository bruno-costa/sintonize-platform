@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Services\ViewStateController $viewCtrl */ ?>
<?php /** @var \App\Models\Radio[] $radios */ ?>
@php($viewCtrl->navItemActive = 'dash-user')
@push('lib-script')
    <script src="{{ asset('js/plugins.dropzone.min.js') }}"></script>
@endpush


@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('dash-user.index') }}">Dash users</a>
    </li>
    <li class="breadcrumb-item active">
        Adicionar novo usuario
    </li>
@endpush


@push('script')
    <script>
      const _uploadedFile = {};

      (function () {
        new Vue({
          el: '#app-form',
          data: {
            isAdmin: '0',
          },
        })
      })()

      function enviarDashUserSalvar (event) {
        event.preventDefault()
        const form = event.target
        const data = new FormData(form)
        if (_uploadedFile.file) {
          data.append('avatar', _uploadedFile.file)
        }
        const buttonCarregando = $('button:disabled', form).get(0)
        const buttonEnviar = $('button:submit', form).get(0)
        buttonCarregando.hidden = false
        buttonEnviar.hidden = true
        axios({
          method: 'post',
          url: '{{ route('dash-user.store') }}',
          data,
        }).then((response) => {
          buttonCarregando.hidden = false
          if (response.data._cod === 'ok') {
            window.location = "{{  route('dash-user.index') }}"
          }
          else {
            throw {response}
          }
        }).catch((error) => {
          const responseData = error.response.data

          let msg = []
          if (responseData._cod === 'user-dash/create/validation') {
            msg = Object.values(responseData.errors).reduce((cur, total) => [...total, ...cur], [])
          } else {
            msg = []
          }

          alert('Algo falhou. ' + msg.join('\n'))

          buttonCarregando.hidden = true
          buttonEnviar.hidden = false
        })
      }
      (function () {
        let e = $('[data-toggle="dropzone"]'), a = $('.dz-preview')
        if (!e.length) {
          return
        }
        Dropzone.autoDiscover = !1
        e.each(function () {
          let e, n, o
          e = $(this)
          n = e.find(a)
          o = {
            url: 'http://',
            thumbnailWidth: null,
            thumbnailHeight: null,
            previewsContainer: n.get(0),
            previewTemplate: n.html(),
            maxFiles: 1,
            acceptedFiles: 'image/*',
            dictDefaultMessage: 'Clique ou Solte sua foto aqui',
            init: function () {
              this.on('addedfile', (file) => _uploadedFile.file = file)
            },
          }
          n.html('')
          e.dropzone(o)
        })
      })()
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col col-md-8 col-lg-6 offset-md-2 offset-lg-3">
            <div class="card" id="app-form">
                <form onsubmit="enviarDashUserSalvar(event)" novalidate>
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h3 class="mb-0">Cadastro do Usuário</h3>
                            <div class="ml-auto">
                                <button class="btn btn-primary" type="submit">Salvar</button>
                                <button class="btn btn-primary" type="button" disabled="" hidden>Enviando ...
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-md-2 col-form-label form-control-label">Nome</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="example-text-input" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input"
                                   class="col-md-2 col-form-label form-control-label">Avatar</label>
                            <div class="col-md-10">
                                <div class="dropzone dropzone-single mb-3" data-toggle="dropzone"
                                     style="width: 210px; height: 210px">
                                    <div class="fallback">
                                        <div class="custom-file" hidden>
                                            <input type="file" class="custom-file-input" id="projectCoverUploads">
                                            <label class="custom-file-label" for="projectCoverUploads">Choose
                                                file</label>
                                        </div>
                                    </div>
                                    <div class="dz-preview dz-preview-single">
                                        <div class="dz-preview-cover">
                                            <img class="dz-preview-img" src="" alt="" data-dz-thumbnail>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-color-input" class="col-md-2 col-form-label form-control-label">
                                Email
                            </label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" id="example-color-input" name="email"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-url-input" class="col-md-2 col-form-label form-control-label">
                                Senha
                            </label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="senha321" id="example-url-input"
                                       name="password"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-2 col-form-label form-control-label text-overflow"
                                   title="Administrador">
                                Administrador
                            </label>
                            <div class="col-md-10 d-flex align-items-center">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="isAdmin" checked
                                           class="custom-control-input" value="0" v-model="isAdmin"
                                    >
                                    <label class="custom-control-label" for="customRadioInline1">Não</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="isAdmin"
                                           class="custom-control-input" value="1" v-model="isAdmin"
                                    >
                                    <label class="custom-control-label" for="customRadioInline2">Sim</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-if="isAdmin === '0'">
                            <label for="example-select-input" class="col-md-2 col-form-label form-control-label">
                                Radio
                            </label>
                            <div class="col-md-10">
                                <select class="form-control" id="example-select-input" name="radioId">
                                    @foreach($radios as $radio)
                                        <option value="{{ $radio->id }}">{{ $radio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection