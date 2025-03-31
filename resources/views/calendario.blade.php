<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <label for="turma">Escolha a Turma:</label>
    <select id="turma">
        <option value="">Selecione...</option>
        @foreach($turmas as $turma)
            <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
        @endforeach
    </select>

    <div id="calendario"></div>

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
</body>
</html>
