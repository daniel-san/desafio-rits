@extends('layouts.app')

@section('content')
<style>
    .custom-file label::after {
        content: none;
    }
</style>
<section>
    <div class="container">

    </div>
</section>


<div class="container">
  <div class="row justify-content-center">
    <form method="POST" action="">
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
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
        </div>

        <h4 class="col-md-12 text-center mx-auto">{{ __('Carta de Apresentação') }}</h4>
        <div class="form-group row">
            <div class="col-md-7 mx-auto">
                <label for="motivation" class="col-md-6 col-form-label text-md-left">{{ __('Conte sua Motivação (Opcional)') }}</label>
                <textarea id="motivation" type="text" class="form-control" name="motivation" value="{{ old('motivation') }}"></textarea>
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
                <input id="salary" type="text" class="form-control" name="salary" value="{{ old('salary') }}" required placeholder="R$">
            </div>
        </div>

        <h4 class="col-md-12 text-center mx-auto">{{ __('Anexe seu currículo em PDF ou DOC') }}</h4>
        <div class="form-group row">
            <div class="col-md-5 mx-auto">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="resume" id="resume">
                    <label class="custom-file-label" for="resume">Escolha o arquivo</label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0 mx-auto">
            <div class="col-md-12 text-center">
                <button type="submit" class="col-md-7 btn btn-success btn-block mx-auto">
                    {{ __('Enviar') }}
                </button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection