<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentações por Turma - Imprimir</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 16px; }
        .header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;
        }
        .header .left { max-width: 40%; }
        .header .right { max-width: 40%; text-align: right; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 12px; }
        th { background: #f5f5f5; text-align: left; }
        .actions { margin: 12px 0; }
        @media print {
            .actions { display: none; }
        }
    </style>
    <script>
        window.addEventListener('load', () => {
            // Abra o diálogo de impressão automaticamente
            window.print();
        });
    </script>
    </head>
<body>
    <div class="header">
        <div class="left">
            <img src="http://localhost:8000/assets/images/logos/logo-comprida.webp" alt="Logo" style="width: 90%;">
        </div>
        <div class="right">
            <img src="{{ asset($school && $school->logo ? 'storage/'.$school->logo : 'assets/images/logos/school-placeholder.svg') }}" alt="Logo {{ $school->nome ?? 'Escola' }}" class="rounded bg-white p-2 shadow-sm" style="width: 180px; height: 180px; object-fit: contain;" onerror="this.onerror=null; this.src='http://localhost:8000/assets/images/logos/school-placeholder.svg';">
        </div>
    </div>
    <h1>Relatório de Movimentações por Turma</h1>
    <div class="meta">
        <div><strong>Turma:</strong> {{ $turma->nome }}</div>
        <div><strong>Período:</strong> {{ $data_inicio }} até {{ $data_fim }}</div>
    </div>

    <div class="actions">
        <button onclick="window.print()">Imprimir</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data/Hora</th>
                <th>Aluno</th>
                <th>Turma</th>
                <th>Antena</th>
                <th>RSSI</th>
                <th>Fonte</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $ev)
                <tr>
                    <td>{{ $ev->seen_at }}</td>
                    <td>{{ $ev->aluno_nome }}</td>
                    <td>{{ $ev->turma_nome }}</td>
                    <td>{{ $ev->antenna }}</td>
                    <td>{{ $ev->rssi }}</td>
                    <td>{{ $ev->source }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>