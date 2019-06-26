@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Models\Radio $radio */ ?>
<?php /** @var string $typeContent */ ?>
@php($viewCtrl->navItemActive = 'radio-content')

@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('content.index') }}">Radio {{ $radio->name }}</a>
    </li>
    <li class="breadcrumb-item active">
        Criar novo conteúdo {{ $typeContent }}
    </li>
@endpush

@push('lib-script')
    <script src="{{ asset('js/plugins.dropzone.min.js') }}"></script>
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
          let e, n, o, t
          e = $(this)
          n = e.find(a)
          t = e.attr('name')
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
              this.on('addedfile', (file) => _uploadedFile[t] = file)
            },
          }
          n.html('')
          e.dropzone(o)
        })
      })()
    </script>
@endpush