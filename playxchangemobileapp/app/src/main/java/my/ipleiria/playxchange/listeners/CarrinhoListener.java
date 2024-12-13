package my.ipleiria.playxchange.listeners;

import my.ipleiria.playxchange.models.Carrinho;

public interface CarrinhoListener {
 void onRefreshCarrinho(Carrinho carrinho);
 void onLinhaCarrinhoChanged();

 void onDescontoApplied();
}
