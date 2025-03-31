@extends('adminlte::page')

@section('title', 'Calendário Escolar')

@section('content_header')
    <h1>📅 Calendário Escolar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Escolha a Turma</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="turma">Selecione a Turma:</label>
                <select id="turma" class="form-control">
                    <option value="">Selecione...</option>
                    @foreach($turmas as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div id="calendario"></div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendario = new FullCalendar.Calendar(document.getElementById('calendario'), {
                initialView: 'timeGridWeek',
                locale: 'pt-br',
                events: []
            });

            calendario.render();

            $('#turma').change(function () {
                let turmaId = $(this).val();

                if (turmaId) {
                    $.getJSON(`/calendario/horarios/${turmaId}`, function (data) {
                        calendario.removeAllEvents();
                        calendario.addEventSource(data);
                    });
                }
            });
        });
    </script>
@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
