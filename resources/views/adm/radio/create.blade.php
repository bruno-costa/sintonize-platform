@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Services\ViewStateController $viewCtrl */ ?>
<?php /** @var \App\Models\Radio[]|\Illuminate\Support\Collection $radios */ ?>
@php($viewCtrl->navItemActive = 'radio')
@push('lib-script')
    <script src="{{ asset('js/plugins.dropzone.min.js') }}"></script>
@endpush


@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('radio.index') }}">Radio</a>
    </li>
    <li class="breadcrumb-item active">
        Criar nova radio
    </li>
@endpush


@push('script')
    <script>
      window._uploadedFile = window._uploadedFile || {}

      function enviarRadioSalvar (event) {
        event.preventDefault()
        if (!_uploadedFile.file) {
          alert('Escolha uma avatar')
          return
        }
        if (_uploadedFile.file.size >= 3000000) {
          alert('Escolha uma avatar menor que 3MB')
          return
        }
        const form = event.target
        const data = new FormData(form)
        data.append('avatar', _uploadedFile.file)
        const buttonCarregando = $('button:disabled', form).get(0)
        const buttonEnviar = $('button:submit', form).get(0)
        buttonCarregando.hidden = false
        buttonEnviar.hidden = true
        axios({
          method: 'post',
          url: '{{ route('radio.store') }}',
          data,
        }).then((response) => {
          buttonCarregando.hidden = false
          if (response.data._cod === 'ok') {
              window.location = "{{  route('radio.index') }}"
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

          const msg = errorsMessage[responseData._cod] || '';
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
            <div class="card">
                <form onsubmit="enviarRadioSalvar(event)">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h3 class="mb-0">Cadastro da Radio</h3>
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
                                Cor Tema
                            </label>
                            <div class="col-md-10">
                                <input class="form-control" type="color" id="example-color-input" name="themeColor"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-url-input" class="col-md-2 col-form-label form-control-label">
                                Stream url
                            </label>
                            <div class="col-md-10">
                                <input class="form-control" type="url" value="" id="example-url-input" name="streamUrl"
                                       required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection