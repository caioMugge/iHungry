@if ($produto->avaliacoes_count > 0)
    @php($media = (int) round($produto->avaliacoes_avg_nota))
    <span>{{ str_repeat('★', $media) }}{{ str_repeat('☆', 5 - $media) }}</span>
    <span>{{ number_format($produto->avaliacoes_avg_nota, 1, ',') }} ({{ $produto->avaliacoes_count }})</span>
@else
    <span>Sem avaliações</span>
@endif