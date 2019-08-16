@component('mail::message')
# Olá, {{ $adminName }}

@if($newCandidatesCount == 0)
    Não há novos candidatos registrados.
@else
    Há {{ $newCandidatesCount }} novo(s) candidato(s) para a vaga.
@endif

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
