@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Services\ViewStateController $viewCtrl */ ?>
@php($viewCtrl->navItemActive = 'dash-user')
@push('lib-script')
    <script src="{{ asset('js/plugins.dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins.select2.min.js') }}"></script>
@endpush
@push('lib-styles')
    <link rel="stylesheet" href="{{ asset('css/plugins.select2.min.css') }}">
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
      window._uploadedFile = window._uploadedFile || {};

      (function () {
        new Vue({
          el: '#app-form',
          data: {
            isAdmin: false,
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
          // voltar
        }).catch((error) => {
          const responseData = error.response.data

          const errorsMessage = {
            'radio/create/invalid_color': 'Cor não é valida',
            'radio/create/invalid_avatar/mimetype': 'Tipo do avatar não é uma imagem valida',
            'radio/create/invalid_avatar/size': 'Tamanho do avatar não é valida',
            'radio/create/invalid_stream_url': 'Stream Url não é valida',
          }

          const msg = errorsMessage[responseData._cod] || ''
          alert('Algo falhou. ' + msg)

          buttonCarregando.hidden = true
          buttonEnviar.hidden = false
        })
      }
    </script>
@endpush
@push('script')
    <script>
      (function () {
        let _uploadedFile = window._uploadedFile || null
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
                <form onsubmit="enviarDashUserSalvar(event)">
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
                                       name="streamUrl"
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
                                    <input type="radio" id="customRadioInline1" name="is_admin"
                                           class="custom-control-input" :value="false" v-model="isAdmin"
                                    >
                                    <label class="custom-control-label" for="customRadioInline1">Não</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="is_admin"
                                           class="custom-control-input" :value="true" v-model="isAdmin"
                                    >
                                    <label class="custom-control-label" for="customRadioInline2">Sim</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-if="isAdmin">
                            <label for="example-select-input" class="col-md-2 col-form-label form-control-label">
                                Radio
                            </label>
                            <div class="col-md-10">
                                <select class="form-control" id="example-select-input" data-toggle="select">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <form>
                    <select class="form-control" data-toggle="select" multiple data-placeholder="Select multiple options">
                        <option>Alerts</option>
                        <option>Badges</option>
                        <option>Buttons</option>
                        <option>Cards</option>
                        <option>Forms</option>
                        <option>Modals</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
@endsection