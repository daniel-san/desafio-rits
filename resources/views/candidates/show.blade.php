@extends('layouts.app')

@section('content')
    @php
        $englishLevels = [
            "starter" => "Iniciante",
            "intermediate" => "Intermediário",
            "advanced" => "Avançado"];
    @endphp
    <div class="container">
        <a href="{{ URL::previous() }}" class="btn btn-primary ml-0 mb-3">Voltar</a>
        <div class="column mt-2" style="font-size: 1rem">
            <div class="candidate-data">
                <h3>Nome:</h3>
                <p>{{ $candidate->name }}</p>
            </div>

            <div class="candidate-data">
                <h3>E-mail:</h3>
                <p>{{ $candidate->email }}</p>
            </div>

            <div class="candidate-data">
                <h3>Telefone:</h3>
                <p>{{ $candidate->telephone }}</p>
            </div>

            <div class="candidate-data">
                <h3>Motivação:</h3>
                <p>{{ $candidate->motivation }}</p>
            </div>

            <div class="candidate-data">
                <h3>Nível de Inglês:</h3>
                <p>{{ $englishLevels[$candidate->english] }}</p>
            </div>

            <div class="candidate-data">
                <h3>Pretenção Salarial:</h3>
                <p>{{ $candidate->salary }}R$</p>
            </div>

            <div class="candidate-data">
                <h3>Links:</h3>
                <div class=" btn-group">
                    <a class="btn btn-primary" href="{{ $candidate->linkedin_url }}" target="_blank">LinkedIn</a>
                    <a class="btn btn-dark" href="{{ $candidate->github_url }}" target="_blank">Github</a>
                    <a class="btn btn-success" href="{{ asset("storage/resumes/{$candidate->resume}") }}" target="_blank">Currículo</a>
                </div>
            </div>

        </div>
    </div>
@endsection
