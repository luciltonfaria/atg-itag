@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Histórico detalhado de presenças</h4>

                    <form method="GET" action="{{ route('movements.history') }}" class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Buscar aluno</label>
                            <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Digite o nome do aluno" />
                            @if(!empty($alunos))
                            <div class="small text-muted mt-1">Resultados da busca (selecione abaixo):</div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Aluno</label>
                            <select name="aluno_id" class="form-select">
                                <option value="">Selecione...</option>
                                @foreach($alunos as $al)
                                    <option value="{{ $al->id }}" {{ request('aluno_id') == $al->id ? 'selected' : '' }}>{{ $al->nome }}</option>
                                @endforeach
                                @if($selectedAluno && ! $alunos->contains('id', $selectedAluno->id))
                                    <option value="{{ $selectedAluno->id }}" selected>{{ $selectedAluno->nome }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">De</label>
                            <input type="datetime-local" name="from" value="{{ $from }}" class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Até</label>
                            <input type="datetime-local" name="to" value="{{ $to }}" class="form-control"/>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                            @if($selectedAluno)
                                <a class="btn btn-outline-danger" href="{{ route('movements.history.pdf', ['aluno_id' => $selectedAluno->id, 'from' => $from, 'to' => $to]) }}" target="_blank">Exportar PDF</a>
                            @endif
                        </div>
                    </form>

                    @if($selectedAluno)
                        <div class="mb-3">
                            <h5 class="mb-1">Aluno: {{ $selectedAluno->nome }}</h5>
                            <div class="text-muted">Referência: {{ $selectedAluno->referencia }}</div>
                        </div>

                        @if($timeline->isEmpty())
                            <div class="alert alert-info">Nenhum evento encontrado no período selecionado.</div>
                        @else
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="timeline-modern">
                                        @foreach($timeline as $idx => $event)
                                            <div class="timeline-entry">
                                                <div class="timeline-left">
                                                    <div class="time">{{ \Illuminate\Support\Carbon::parse($event['seen_at'])->format('d/m/Y H:i') }}</div>
                                                    <div class="meta">Fonte: {{ $event['source'] }} • EPC: {{ $event['epc'] }}</div>
                                                </div>
                                                <div class="timeline-dot"></div>
                                                <div class="timeline-content">
                                                    @if(!empty($event['antenna']))
                                                        <div class="title">Antena: {{ $event['antenna'] }}</div>
                                                    @else
                                                        <div class="title">Evento de presença</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card antenna-card">
                <div class="card-body text-center">
                    <div class="antenna-illustration" aria-label="Ilustração de antena captando sinal">
                        <img src="{{ asset('assets/images/svgs/antenna-tag-monitor.svg') }}" alt="Antena de monitoramento de Tags" />
                    </div>
                    <div class="antenna-caption">MONITORAMENTO DE TAGS</div>
                </div>
            </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-secondary">Use a busca acima para selecionar um aluno e visualizar a timeline.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Timeline moderna */
.timeline-modern {
  position: relative;
  margin-left: 24px;
  padding-left: 24px;
}
.timeline-modern::before {
  content: "";
  position: absolute;
  left: 16px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: #e5e7eb; /* gray-200 */
}
.timeline-entry {
  position: relative;
  display: grid;
  grid-template-columns: 180px 24px 1fr;
  gap: 12px;
  align-items: center;
  padding: 12px 0;
}
.timeline-left .time {
  font-weight: 600;
}
.timeline-left .meta {
  color: #6b7280; /* gray-500 */
  font-size: 0.875rem;
}
.timeline-dot {
  width: 12px;
  height: 12px;
  border-radius: 999px;
  background: linear-gradient(135deg, #4f46e5, #22d3ee);
  box-shadow: 0 0 0 4px #eef2ff; /* indigo-50 halo */
}
.timeline-content {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  padding: 12px 14px;
  box-shadow: 0 1px 2px rgba(16,24,40,0.04);
}
.timeline-content .title { font-weight: 600; }

/* Card com ilustração de antena */
.antenna-card { border-radius: 12px; }
.antenna-illustration img {
  width: 100%;
  max-width: 320px; /* discreta e responsiva */
  height: auto;
}
.antenna-caption {
  font-weight: 500;
  color: #6b7280; /* gray-500 */
  font-size: 0.9rem;
  letter-spacing: 0.04em;
  margin-top: 8px;
}
</style>
@endsection