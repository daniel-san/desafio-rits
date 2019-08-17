@extends('layouts.vagaform')

@section('content')
<div class="jumbotron formhero">

    <div class="col justify-content-center formhero-calltoaction">
        <p class="formhero-calltoaction-city">Natal/RN - Brasil</p>
        <h2 class="formhero-calltoaction-function">Desenvolvedor PHP</h2>
        <a class="btn btn-rounded btn-green formhero-calltoaction-action" href="#">Candidate-se</a>
    </div>

    <div class="row col-md-12 formhero-section">
        <div class="col-md-4 formhero-textbox">
            <h6>Na função de Desenvolvedor Frontend aqui na Rits, você vai:</h6>
            <ul>
                <li>Transformar layouts (XD e Photoshop) em montagens responsivas utilizando HTML + CSS + JS;</li>
                <li>Integrar montagem com APIs desenvolvidas por outras equipes;</li>
                <li>Manter e melhorar a base de código existente corrigindo bugs e refatorando código quando necessário;</li>
            </ul>
        </div>

        <div class="col-md-4 formhero-textbox">
            <h6>Procuramos alguém que</h6>
            <ul>
                <li>Possua habilidades arquiteturais para desenvolvimento de software;</li>
                <li>Goste de trabalhar em equipe;</li>
                <li>Seja focado, proativo, tenha boa comunicação e relacionamento interpessoal;</li>
            </ul>
        </div>

        <div class="col-md-4 formhero-textbox">
            <h6>No dia a dia na Rits, você trabalhará também com:</h6>
            <ul>
                <li>Wordpress e sistemas em PHP em geral;</li>
                <li>Webpack e Bootstrap;</li>
                <li>Frameworks javascript modernos (Vue2, React);</li>
            </ul>
        </div>
    </div>
</div>


<div class="container vagaform">
    <div class="row justify-content-center">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endforeach
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('candidate.store') }}" enctype="multipart/form-data">
            @csrf
            <h4 class="col-md-12 text-center mx-auto">{{ __('Dados Pessoais') }}</h4>
            <div class="form-group row">
                <div class="col-md-7 mx-auto">
                    <label for="name" class="col-md-6 col-form-label text-md-left">{{ __('Nome Completo') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                <br>
                <div class="col-md-7 mx-auto">
                    <label for="email" class="col-md-6 col-form-label text-md-left">{{ __('E-Mail') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
            </div>

            <h4 class="col-md-12 text-center mx-auto">{{ __('Carta de Apresentação') }}</h4>
            <div class="form-group row">
                <div class="col-md-7 mx-auto">
                    <label for="motivation" class="col-md-6 col-form-label text-md-left">{{ __('Conte sua Motivação (Opcional)') }}</label>
                    <textarea id="motivation" type="text" class="form-control" name="motivation">{{ old('motivation') }}</textarea>
                </div>
            </div>

            <h4 class="col-md-12 text-center mx-auto">{{ __('Ultimas Perguntas') }}</h4>
            <div class="form-group row">
                <div class="col-md-7 mx-auto">
                    <label for="linkedinUrl" class="col-md-6 col-form-label text-md-left">{{ __('Url do seu LinkedIn') }}</label>
                    <input id="linkedinUrl" type="text" class="form-control" name="linkedinUrl" value="{{ old('linkedinUrl') }}" required>
                </div>
                <div class="col-md-7 mx-auto">
                    <label for="githubUrl" class="col-md-6 col-form-label text-md-left">{{ __('Url do seu Github') }}</label>
                    <input id="githubUrl" type="text" class="form-control" name="githubUrl" value="{{ old('githubUrl') }}" required>
                </div>
                <div class="col-md-7 mx-auto">
                    <label for="english" class="col-md-6 col-form-label text-md-left">{{__('Qual seu nível de Inglês?')}}</label>
                    <select name="english" id="english" class="form-control">
                        <option value="" selected>Escolha</option>
                        <option value="starter">Iniciante</option>
                        <option value="intermediate">Intermediário</option>
                        <option value="advanced">Avançado</option>
                    </select>
                </div>

                <div class="col-md-7 mx-auto">
                    <label for="salary" class="col-md-6 col-form-label text-md-left">{{ __('Pretensão Salarial') }}</label>
                    <input id="salary" type="number" step="0.1" min="0" class="form-control" name="salary" value="{{ old('salary') }}" required placeholder="R$">
                </div>
            </div>

            <h4 class="col-md-12 text-center mx-auto">{{ __('Anexe seu currículo em PDF ou DOC') }}</h4>
            <div class="form-group row">
                <div class="col-md-5 mx-auto">
                    <div class="custom-file">
                        <input type="file" class="custom-file btn-rounded" name="resume" id="resume">
                        <label class="custom-file-label btn-rounded btn-rounded-file-upload" for="resume">
                            <span id="upload-filename">Escolha o arquivo</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0 mx-auto">
                <div class="col-md-12 text-center">
                    <button type="submit" class="col-md-7 btn btn-success btn-block btn-rounded btn-green mx-auto">
                        {{ __('Enviar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<footer class="container vagaform-footer row">
    <div class="col-md-4 vagaform-footer-textbox">
        <img src="" alt="" class="vagaform-footer-logo">
    </div>
    <div class="col-md-4 vagaform-footer-textbox">
        <h5>Rits Tecnologia. Todos os direitos reservados</h5>
        <p>Desenvolver e evoluir soluções digitais para negócios que acreditam na tecnologia como força propulsora</p>
    </div>
    <div class="col-md-4 vagaform-footer-textbox">
        <p class="vagaform-footer-url">Rits.com.br</p>
    </div>
</footer>
@push('scripts')
    <script src="{{ asset("js/vagaform.js") }}"></script>
@endpush
@endsection
