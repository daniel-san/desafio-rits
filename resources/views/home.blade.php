@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Candidatos</div>

                <div class="card-body">
                    @if(count($candidates) > 0)
                        <table class="table mb-0">
                            <tbody style="text-align: center">
                                @foreach($candidates as $candidate)
                                <tr>
                                    <td style="vertical-align: middle">{{ $candidate->name }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('candidate.show', $candidate->id) }}">Visualizar Dados</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Não há candidatos cadastrados no sistema</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
