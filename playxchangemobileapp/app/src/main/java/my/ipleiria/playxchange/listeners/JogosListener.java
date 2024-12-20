package my.ipleiria.playxchange.listeners;

import java.util.ArrayList;

import my.ipleiria.playxchange.models.Jogo;

public interface JogosListener {
    void onRefreshListaJogos(ArrayList<Jogo> jogos);

    void onRefreshListaJogosRecentes(ArrayList<Jogo> jogos);

    void onRefreshListaJogosPopulares(ArrayList<Jogo> jogos);

    void onRefreshListaJogosFavoritos(ArrayList<Jogo> jogos);

    void onRefreshListaJogosJogados(ArrayList<Jogo> jogos);

    void onRefreshListaJogosDesejados(ArrayList<Jogo> jogos);
}
