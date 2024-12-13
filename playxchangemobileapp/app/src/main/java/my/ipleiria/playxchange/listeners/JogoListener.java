package my.ipleiria.playxchange.listeners;

import my.ipleiria.playxchange.models.Jogo;

public interface JogoListener {
    void onRefreshJogo(Jogo jogo);
    void onAddCarrinho();
    void onInteract(int action);

    void onRatingCreated(double numEstrelas);
    void onRatingChanged(double numEstrelas);
    void onRatingDeleted();



}
