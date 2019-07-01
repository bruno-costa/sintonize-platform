@extends('layouts.app')
@inject('viewCtrl', 'App\Services\ViewStateController')
<?php /** @var \App\Models\Radio $radio */ ?>
<?php /** @var string $typeContent */ ?>
<?php /** @var App\Models\Advertiser $advertisers */ ?>
@php($viewCtrl->navItemActive = 'radio-content')

@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('content.index') }}">Radio {{ $radio->name }}</a>
    </li>
    <li class="breadcrumb-item active">
        Criar novo conteúdo @switch($typeContent)
            @case(\App\Repositories\Promotions\PromotionLink::getType()) Link
            @break
            @case(\App\Repositories\Promotions\PromotionAnswer::getType()) Pergunta
            @break
            @case(\App\Repositories\Promotions\PromotionTest::getType()) Enquete
        @endswitch
    </li>
@endpush

@push('styles')
    <style>
        .test-switch-option {
            align-self: stretch;
            display: grid;
            place-items: center;
            grid-template-columns: 1fr 1fr;
            margin: 0;
            cursor: pointer;
        }
    </style>
@endpush

@push('lib-script')
    <script src="{{ asset('js/plugins.dropzone.min.js') }}"></script>
@endpush
@push('script')
    <script>
      window._uploadedFile = {};
      (function () {
        const _uploadedFile = window._uploadedFile || {}
        new Vue({
          el: '#createContentRadio',
          data: {
            advertisers: [
              {
                'name': 'Sem patrocinador',
                'id': null,
              },
            ],
            advertiserId: null,
            premLimit: {
              value: null,
              oldValue: null,
              semLimit: false,
            },
            dataSorteio: {
              value: null,
              type: 'chronologic',
            },
            advertiser: {
              enviandoAddAdvertisers: false,
              name: null,
              url: null,
            },
            testAnswers: [],
            enviando: false,
            contemPremiacao: true,
          },
          watch: {
            'premLimit.semLimit' () {
              if (this.premLimit.semLimit) {
                this.premLimit.oldValue = this.premLimit.value
                this.premLimit.value = null
              } else {
                this.premLimit.value = this.premLimit.oldValue
              }
            },
          },
          methods: {
            salvar () {
              this.enviando = true
              if (this.testAnswers.length === 0 &&
                      @json(\App\Repositories\Promotions\PromotionTest::getType() === $typeContent)
                &&
                !confirm('Parece que não escolhida nenhuma resposta correta. \nDESEJA CONTINUAR?')) {
                this.enviando = false
                return
              }
              //const form = this.$advertiserForm.find('form').get(0)
              const data = new FormData(this.$refs.form)
              if (_uploadedFile.coverMedia) {
                data.append('image', _uploadedFile.coverMedia)
              } else {
                alert('Selecione uma imagem valido')
                this.enviando = false
                return
              }
              axios({
                method: 'post',
                url: '{{ route('content.store') }}',
                data,
              }).
                then(response => {
                  if (response.data._cod === 'ok') {
                    window.location = "{{  route('content.index') }}"
                  }
                  else {
                    throw {response}
                  }
                }).
                catch(error => {
                  const responseData = error.response.data

                  let msg = []
                  if (responseData._cod === 'radio-content/create/validation') {
                    msg = Object.values(responseData.errors).reduce((cur, total) => [...total, ...cur], [])
                  } else {
                    msg = []
                  }

                  alert('Algo falhou. ' + msg.join('\n'))

                  this.enviando = false
                })
            },
            showModalAdvertiserForm () {
              this.$advertiserForm.modal('show')
            },
            addAdvertisers () {
              this.advertiser.enviandoAddAdvertisers = true
              const form = this.$advertiserForm.find('form').get(0)
              const data = new FormData(form)
              if (_uploadedFile.advartiserAvatar) {
                data.append('avatar', _uploadedFile.advartiserAvatar)
              } else {
                alert('Selecione um avatar valido')
                this.advertiser.enviandoAddAdvertisers = false
                return
              }

              axios({
                method: 'post',
                url: '{{ route('advertiser.store') }}',
                data,
              }).then((response) => {
                if (response.data._cod !== 'ok') {
                  throw {response}
                }
                this.advertisers = [
                  ...this.advertisers, {
                    'name': this.advertiser.name,
                    'id': response.data.advertiserId,
                  }]
                this.advertiserId = response.data.advertiserId
                this.$advertiserForm.modal('hide')
              }).catch((error) => {
                const responseData = error.response.data

                let msg = []
                if (responseData._cod === 'advertiser/create/validation') {
                  msg = Object.values(responseData.errors).reduce((cur, total) => [...total, ...cur], [])
                } else {
                  msg = []
                }

                alert('Algo falhou. ' + msg.join('\n'))
              }).finally(() => {
                console.table([...data])
                this.advertiser.enviandoAddAdvertisers = true
              })
            },
          },
          computed: {
            $advertiserForm () {
              return $(this.$refs.modalForm)
            },
          },
          created () {
            this.advertisers = [...this.advertisers, ...@json($advertisers)]
          },
          mounted () {
            this.$advertiserForm.on('hidden.bs.modal', () => {
              this.advertiser.name = null
              this.advertiser.url = null
              this.advertiser.enviandoAddAdvertisers = false
            })
          },
        })
      })();
      (function () {
        let _uploadedFile = window._uploadedFile || {}
        let e = $('[data-toggle="dropzone"]'), a = $('.dz-preview')
        if (!e.length) {
          return
        }
        Dropzone.autoDiscover = !1
        e.each(function () {
          let e, n, o, t
          e = $(this)
          n = e.find(a)
          t = e.data('name')
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

@section('content')

    <div class="row justify-content-center" id="createContentRadio">
        <div class="col col-md-9">
            <div class="card">
                <form @submit.prevent="salvar" ref="form">
                    <input type="hidden" name="promKind" value="{{ $typeContent }}">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h3 class="mb-0">Cadastro
                                @switch($typeContent)
                                    @case(\App\Repositories\Promotions\PromotionLink::getType()) Link
                                    @break
                                    @case(\App\Repositories\Promotions\PromotionAnswer::getType()) Pergunta
                                    @break
                                    @case(\App\Repositories\Promotions\PromotionTest::getType()) Enquete
                                    @break
                                    @case(\App\Repositories\Promotions\PromotionVoucher::getType()) Cupom
                                @endswitch
                            </h3>
                            <div class="ml-auto">
                                <button class="btn btn-primary" type="submit" :hidden="enviando">Salvar</button>
                                <button class="btn btn-primary" type="button" disabled="" :hidden="!enviando">Enviando
                                    ...
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="example-search-input"
                                   class="col-form-label form-control-label">Imagem</label>
                            <div>
                                <div class="dropzone dropzone-single mb-3" data-toggle="dropzone"
                                     data-name="coverMedia">
                                    <div class="fallback">
                                        <div class="custom-file" hidden>
                                            <input type="file" class="custom-file-input" id="projectCoverUploads">
                                            <label class="custom-file-label" for="projectCoverUploads"></label>
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
                        <div class="form-group">
                            <label for="example-text-input"
                                   class="col-form-label form-control-label">Texto</label>
                            <div>
                                <input class="form-control" type="text" id="example-text-input" name="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-color-input"
                                   class="col-form-label form-control-label text-overflow"
                                   title="Patrocinador">
                                Patrocinador
                            </label>
                            <div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <select class="form-control" id="example-color-input" name="advertiserId"
                                                v-model="advertiserId">
                                            <option v-for="advertise in advertisers" :value="advertise.id"
                                                    :key="'advertise_id' + advertise.id">@{{ advertise.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-icon btn-success btn-block text-overflow h-100"
                                                type="button" @click="showModalAdvertiserForm">
                                            <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                                            <span class="btn-inner--text">Adicionar novo</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @switch($typeContent)
                            @case(\App\Repositories\Promotions\PromotionVoucher::getType())
                            <hr class="my-6">
                            <h2>Detalhes do cupom</h2>
                            <div class="form-group">
                                <label for="answer-label-input" class="col-form-label form-control-label">
                                    Texto do botão
                                </label>
                                <div>
                                    <select class="form-control" id="answer-label-input" name="voucherLabel" required>
                                        <option>Obter agora</option>
                                        <option>Garantir o meu</option>
                                    </select>
                                </div>
                            </div>
                            @break
                            @case(\App\Repositories\Promotions\PromotionLink::getType())
                            <div class="form-group">
                                <hr class="my-6">
                                <h2>Detalhes do Link</h2>
                                <label for="link-label-input" class="col-form-label form-control-label">
                                    Texto do botão
                                </label>
                                <div>
                                    <select class="form-control" name="linkLabel" id="link-label-input">
                                        <option>Saiba mais</option>
                                        <option>Veja aqui</option>
                                        <option>Acesse agora</option>
                                        <option>Entre aqui</option>
                                        <option>Comprar agora</option>
                                        <option>Cadastre-se</option>
                                        <option>Reservar agora</option>
                                        <option>Solicitar agora</option>
                                        <option>Obter oferta</option>
                                        <option>Ajudar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-url-input" class="col-form-label form-control-label">
                                    Url
                                </label>
                                <div>
                                    <input class="form-control" type="url" value="" id="example-url-input"
                                           name="linkUrl" required>
                                </div>
                            </div>
                            @break
                            @case(\App\Repositories\Promotions\PromotionAnswer::getType())
                            <hr class="my-6">
                            <h2>Detalhes da pergunta</h2>
                            <div class="form-group">
                                <label for="answer-label-input" class="col-form-label form-control-label">
                                    Texto do botão
                                </label>
                                <div>
                                    <select class="form-control" id="answer-label-input" name="answerLabel" required>
                                        <option>Responder</option>
                                        <option>Responda agora</option>
                                        <option>Eu sei a resposta</option>
                                        <option>Eu acho que ...</option>
                                        <option>Ajudar</option>
                                    </select>
                                </div>
                            </div>
                            @break
                            @case(\App\Repositories\Promotions\PromotionTest::getType())
                            <hr class="my-6">
                            <h2>Detalhes da Enquete</h2>
                            <label for="answer-label-input" class="col-form-label form-control-label">
                                Opções do Teste
                            </label>
                            <div class="">
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="mr-2">
                                        <label class="test-switch-option">
                                            <span class="text-nowrap mr-2">Resposta correta</span>
                                            <span class="custom-toggle">
                                                <input type="checkbox" v-model="testAnswers"
                                                       name="testAnswersCorrectly[]" value="0">
                                                <span class="custom-toggle-slider rounded-circle"
                                                      data-label-off="Não" data-label-on="Sim"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Opção 1"
                                           name="testAnswers[]" required>
                                </div>
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="mr-2">
                                        <label class="test-switch-option">
                                            <span class="text-nowrap mr-2">Resposta correta</span>
                                            <span class="custom-toggle">
                                                <input type="checkbox" v-model="testAnswers"
                                                       name="testAnswersCorrectly[]" value="1">
                                                <span class="custom-toggle-slider rounded-circle"
                                                      data-label-off="Não" data-label-on="Sim"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Opção 2"
                                           name="testAnswers[]" required>
                                </div>
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="mr-2">
                                        <label class="test-switch-option">
                                            <span class="text-nowrap mr-2">Resposta correta</span>
                                            <span class="custom-toggle">
                                                <input type="checkbox" v-model="testAnswers"
                                                       name="testAnswersCorrectly[]" value="2">
                                                <span class="custom-toggle-slider rounded-circle"
                                                      data-label-off="Não" data-label-on="Sim"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Opção 3"
                                           name="testAnswers[]" required>
                                </div>
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="mr-2">
                                        <label class="test-switch-option">
                                            <span class="text-nowrap mr-2">Resposta correta</span>
                                            <span class="custom-toggle">
                                                <input type="checkbox" v-model="testAnswers"
                                                       name="testAnswersCorrectly[]" value="3">
                                                <span class="custom-toggle-slider rounded-circle"
                                                      data-label-off="Não" data-label-on="Sim"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Opção 4"
                                           name="testAnswers[]" required>
                                </div>
                            </div>
                            @break
                        @endswitch
                        <hr class="my-6">
                        <label class="col-form-label form-control-label d-inline-flex">
                            <span class="h2">Premiação</span>
                            @if(\App\Repositories\Promotions\PromotionVoucher::getType() == $typeContent)
                                <input type="hidden" v-model="contemPremiacao" :value="'on'" name="hasPremium">
                            @else
                                <span class="custom-toggle ml-3">
                                                            <input type="checkbox" v-model="contemPremiacao"
                                                                   name="hasPremium">
                                                            <span class="custom-toggle-slider rounded-circle"
                                                                  data-label-off="Não" data-label-on="Sim"></span>
                                                        </span>
                            @endif
                        </label>
                        <div v-if="contemPremiacao">
                            <div class="form-group">
                                <label for="prem-label-name" class="col-form-label form-control-label">
                                    Premio
                                </label>
                                <input class="form-control" type="text" id="prem-label-name" name="premiumName"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="prem-label-rule" class="col-form-label form-control-label">
                                    Regras
                                </label>
                                <textarea class="form-control" id="prem-label-rule" name="premiumRule" rows="3"
                                          style="resize: none;" required
                                          placeholder="Enquanto durar o estoque"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="prem-label-valid-at" class="col-form-label form-control-label">
                                    Validade
                                </label>
                                <input class="form-control col col-md-3" type="date" id="prem-label-valid-at" required
                                       name="premiumValidAt" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group">
                                <label for="prem-num-reward" class="col-form-label form-control-label">
                                    Quantidade de ganhadores
                                </label>
                                <div class="d-flex align-items-center">
                                    <div class="col col-md-2">
                                        <input class="form-control" id="prem-num-reward" v-model="premLimit.value"
                                               type="number" name="premiumRewardAmount" :disabled="premLimit.semLimit"
                                               :required="!premLimit.semLimit" min="1">
                                    </div>
                                    <div class="custom-control custom-checkbox ml-3">
                                        <input class="custom-control-input" id="customCheck1" type="checkbox"
                                               v-model="premLimit.semLimit">
                                        <label class="custom-control-label" for="customCheck1">Sem limite</label>
                                    </div>
                                </div>
                            </div>
                            @if(\App\Repositories\Promotions\PromotionTest::getType() === $typeContent)
                                <div class="form-group">
                                    <label class="col-form-label form-control-label d-inline-flex">
                                        Participar da premiação somente quem acertou a alternativa?
                                        <span class="custom-toggle ml-3">
                                            <input type="checkbox" name="premiumRewardOnlyCorrect"
                                                   value="1">
                                            <span class="custom-toggle-slider rounded-circle"
                                                  data-label-off="Não" data-label-on="Sim"></span>
                                        </span>
                                    </label>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="" class="col-form-label form-control-label">
                                    Metodo de premiar
                                </label>
                                <div class="d-flex align-items-center">
                                    <div class="custom-control custom-radio">
                                        <input name="premiumWinMethod" class="custom-control-input" id="customRadio56"
                                               type="radio" checked value="chronologic" v-model="dataSorteio.type">
                                        <label class="custom-control-label" for="customRadio56">Ordem das
                                            participações</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-5">
                                        <input name="premiumWinMethod" class="custom-control-input" id="customRadio5"
                                               value="lottery" type="radio" v-model="dataSorteio.type">
                                        <label class="custom-control-label" for="customRadio5">Data de Sorteio</label>
                                    </div>
                                    <div class="ml-3" v-if="dataSorteio.type == 'lottery' ">
                                        <input class="form-control" type="date" id="" name="premiumLotteryAt" required
                                               min="{{ date('Y-m-d') }}" v-model="dataSorteio.value"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div ref="modalForm" class="modal fade" id="modal-default" tabindex="-1" role="dialog"
             aria-labelledby="modal-default"
             aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Adicionar novo patrocinador</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form action="" @submit.prevent="addAdvertisers">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="advAvatar"
                                       class="col-form-label form-control-label">Avatar</label>
                                <div>
                                    <div class="dropzone dropzone-single mb-3" data-toggle="dropzone"
                                         data-name="advartiserAvatar" style="width: 200px; height: 200px; margin: auto">
                                        <div class="fallback">
                                            <div class="custom-file" hidden>
                                                <input type="file" class="custom-file-input" id="advAvatar">
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
                            <div class="form-group">
                                <label for="adv-text-input"
                                       class="col-form-label form-control-label">Nome</label>
                                <input class="form-control" type="text" id="adv-text-input" name="name" required
                                       v-model="advertiser.name">
                            </div>
                            <div class="form-group">
                                <label for="example-text-url"
                                       class="col-form-label form-control-label">Url</label>
                                <input class="form-control" type="url" id="example-text-url" name="url"
                                       v-model="advertiser.url">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" :hidden="advertiser.enviandoAddAdvertisers">
                                Salvar
                            </button>
                            <button type="button" class="btn btn-primary" disabled
                                    :hidden="!advertiser.enviandoAddAdvertisers">Enviando ...
                            </button>
                            <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection