package my.ipleiria.playxchange.listeners;

import java.util.ArrayList;

import my.ipleiria.playxchange.models.Jogo;

public interface JogosListener {
    void onRefreshListaJogos(ArrayList<Jogo> jogos);
}
