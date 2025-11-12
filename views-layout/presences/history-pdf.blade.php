<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico detalhado - {{ $aluno->nome }}</title>
    <style>
        /* Formato de página A4 com margens adequadas para PDF */
        @page { size: A4 portrait; margin: 12mm 10mm 12mm 10mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; margin: 0; }
        h1 { font-size: 18px; margin: 0 0 6mm 0; }
        .meta { color: #555; margin-bottom: 8mm; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f5f5f5; }
        /* Cabeçalho posicionado no topo do conteúdo, com espaçamento em mm para coerência no A4 */
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8mm; }
        .header .left { max-width: 45%; }
        .header .right { max-width: 45%; text-align: right; }
        .header img { height: 18mm; width: auto; object-fit: contain; }
    </style>
    </head>
<body>
    <div class="header">
        <div class="left">
            <img src="{{ asset('assets/images/logos/logo-comprida.webp') }}" alt="Logo Projeto">
        </div>
        <div class="right">
            <img src="{{ asset($school && $school->logo ? 'storage/'.$school->logo : 'assets/images/logos/school-placeholder.svg') }}" alt="Logo {{ $school->nome ?? 'Escola' }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/logos/school-placeholder.svg') }}';">
        </div>
    </div>
    <h1>Histórico detalhado de presença</h1>
    <div class="meta">
        <div><strong>Aluno:</strong> {{ $aluno->nome }} (Ref: {{ $aluno->referencia }})</div>
        @if($from || $to)
            <div><strong>Período:</strong> {{ $from ?? 'início' }} até {{ $to ?? 'agora' }}</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Data/Hora</th>
                <th>Fonte</th>
                <th>Antena</th>
                <th>EPC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $e)
                <tr>
                    <td>{{ \Illuminate\Support\Carbon::parse($e['seen_at'])->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $e['source'] }}</td>
                    <td>{{ $e['antenna'] ?? '-' }}</td>
                    <td>{{ $e['epc'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>