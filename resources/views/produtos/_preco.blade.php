@if ($produto->em_promocao)
    <s>R$ {{ number_format($produto->preco, 2, ',', '.') }}</s>
    <strong>-{{ $produto->desconto_percentual }}%</strong>
    <br>
    <span>R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}</span>
@else
    <span>R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
@endif